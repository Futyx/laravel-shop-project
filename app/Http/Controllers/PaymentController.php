<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Payment;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{
    public function pay(Order $order)
    {
        try {
            $amount = (int) $order->total_amount;

            if ($amount < 100) {
                return redirect()->back()->with('error', 'مبلغ نامعتبر است. حداقل مبلغ پرداخت ۱۰۰ تومان می‌باشد.');
            }

            // ساخت فاکتور
            $invoice = new Invoice;
            $invoice->amount($amount);

            // ارسال اطلاعات کاربر به درگاه
            if (Auth::check() && Auth::user()->phone) {
                $invoice->detail('mobile', Auth::user()->phone);
            }

            // درخواست پرداخت به درگاه زرین‌پال
            return Payment::via('zarinpal')->purchase($invoice, function ($driver, $transactionId) use ($order) {
                $order->update(['transaction_id' => $transactionId]);
            })->pay()->render();
            
        } catch (\Exception $e) {
            Log::error('Payment gateway error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'amount' => $order->total_amount ?? null,
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'خطا در اتصال به درگاه پرداخت. لطفاً دوباره تلاش کنید.');
        }
    }
    public function callback(Request $request)
    {
        $transactionId = $request->input('Authority');
        $status = $request->input('Status');

        if (!$transactionId) {
            return view('payment.error', [
                'message' => 'اطلاعات تراکنش یافت نشد. لطفاً با پشتیبانی تماس بگیرید.'
            ]);
        }

        try {
            $order = Order::where('transaction_id', $transactionId)->first();

            if (!$order) {
                Log::warning('Order not found for transaction', ['transaction_id' => $transactionId]);
                return view('payment.error', [
                    'message' => 'سفارش یافت نشد. لطفاً با پشتیبانی تماس بگیرید.'
                ]);
            }

            // اگر کاربر از پرداخت انصراف داده باشد
            if ($status === 'NOK' || $status === 'Cancel') {
                $order->update(['payment_status' => 'cancelled']);
                return view('payment.error', [
                    'message' => 'پرداخت توسط شما لغو شد.'
                ]);
            }

            // تایید پرداخت
            $receipt = Payment::via('zarinpal')
                ->amount((int)$order->total_amount)
                ->transactionId($transactionId)
                ->verify();

            // بررسی موفقیت‌آمیز بودن پرداخت
            if ($receipt && $receipt->getReferenceId()) {
                $trackingCode = $order->tracking_code ?? Order::generateTrackingCode();

                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'pending',
                    'tracking_code' => $trackingCode,
                    'bank_ref_id' => $receipt->getReferenceId(),
                ]);

                // پاک کردن سبد خرید
                session()->forget('cart');

                return view('payment.success', [
                    'trackingCode' => $trackingCode,
                    'refId' => $receipt->getReferenceId()
                ]);
            } else {
                $order->update(['payment_status' => 'failed']);
                return view('payment.error', [
                    'message' => 'پرداخت تایید نشد. لطفاً با پشتیبانی تماس بگیرید.'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Payment verification error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'status' => $status,
                'trace' => $e->getTraceAsString(),
            ]);

            // به‌روزرسانی وضعیت سفارش در صورت وجود
            if (isset($order)) {
                $order->update(['payment_status' => 'failed']);
            }

            $errorMessage = 'خطا در تایید پرداخت. ';
            if (str_contains($e->getMessage(), 'timeout') || str_contains($e->getMessage(), 'connection')) {
                $errorMessage .= 'لطفاً چند دقیقه دیگر بررسی کنید.';
            } else {
                $errorMessage .= 'لطفاً با پشتیبانی تماس بگیرید.';
            }

            return view('payment.error', [
                'message' => $errorMessage
            ]);
        }
    }
}

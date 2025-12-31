<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Payment;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{
    public function pay(Order $order)
    {
        $amount = (int) $order->total_amount;

        if ($amount < 100) { // حداقل مبلغ زرین پالش ۱۰۰ تومان است
            return redirect()->back()->with('error', 'مبلغ نامعتبر است.');
        }

        // ۲. ساخت فاکتور
        $invoice = new Invoice;
        $invoice->amount($amount);

        // ۳. ارسال اطلاعات کاربر به درگاه (اختیاری اما کمک به ولیدیشن)
        // اگر موبایل یوزر را داری، اینجا اضافه کن
        if (auth()->user()->phone) {
            $invoice->detail('mobile', auth()->user()->phone);
        }

        try {
            return Payment::via('zarinpal')->purchase($invoice, function ($driver, $transactionId) use ($order) {
                $order->update(['transaction_id' => $transactionId]);
            })->pay()->render();
        } catch (\Exception $e) {
            return "خطا در اتصال به درگاه: " . $e->getMessage();
        }
    }
    public function callback(Request $request)
    {
        $transactionId = $request->Authority;
        $order = Order::where('transaction_id', $transactionId)->firstOrFail();

        try {
            $receipt = Payment::via('zarinpal')
                ->amount((int)$order->total_amount)
                ->transactionId($transactionId)
                ->verify();

            $trackingCode = Order::generateTrackingCode();

            $order->update([
                'payment_status' => 'paid',
                'tracking_code' => $trackingCode,
                'bank_ref_id' => $receipt->getReferenceId(),
            ]);
            return view('payment.success', [
                'trackingCode' => $trackingCode,
                'refId' => $receipt->getReferenceId()
            ]);
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed']);

            return view('payment.error', ['message' => $e->getMessage()]);
        }
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // The line needed if you want to check login status

class HomeController extends Controller
{
    // ... سایر متدهای شما (مانند __construct) ...

    /**
     * نمایش صفحه پروفایل کاربر.
     * این متد جایگزین متد show() شده که در خطا بود.
     */
    public function profile()
    {
        // بررسی می‌کند که آیا کاربر لاگین کرده است یا خیر
        if (!Auth::check()) {
            // اگر لاگین نکرده بود، کاربر را به مسیر ورود (که توسط Breeze تعریف شده) هدایت می‌کند.
            return redirect()->route('login');
        }

        return view('profile.edit'); // فرض می‌کنیم ویو پروفایل شما اینجا باشد
    }

    /**
     * متدی که Laravel Route انتظار دارد. این متد به profile هدایت می‌شود تا خطا برطرف شود.
     */
    public function show() { 
        // در صورت فراخوانی show، متد profile را اجرا کن
        return $this->profile(); 
    }
}

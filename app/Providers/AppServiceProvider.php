<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('rial', function ($expression) {
            return "<?php echo \\App\\Providers\\AppServiceProvider::formatPriceFa($expression); ?>";
        });
          // دستورالعمل جدید @persian: برای تبدیل ساده عدد به فارسی
          Blade::directive('persian', function ($expression) {
            return "<?php echo \\App\\Providers\\AppServiceProvider::convertNumberToFa($expression); ?>";
        });
    }
    

    public static function formatPriceFa($value): string
    {
        $number = (int) $value;

        // ۱. اعمال جداکننده هزارگان به شکل نقطه (Dot)
        // number_format: بدون اعشار (0)، جداکننده اعشار خالی ('') و جداکننده هزارگان نقطه ('.')
        $formatted = number_format($number, 0, '', '.');

        // ۲. تعریف آرایه‌ها برای تبدیل فقط اعداد (نقطه ثابت می‌ماند)
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        // ۳. تبدیل اعداد به فارسی و بازگرداندن (بدون "تومان")
        return str_replace($western, $persian, $formatted);
    }
    public static function convertNumberToFa($value): string
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        // اطمینان از اینکه ورودی به رشته تبدیل شود.
        $string_value = (string) $value;

        return str_replace($western, $persian, $string_value);
    }
}

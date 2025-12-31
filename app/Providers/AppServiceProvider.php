<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Services\SeoService;

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
          Blade::directive('persian', function ($expression) {
            return "<?php echo \\App\\Providers\\AppServiceProvider::convertNumberToFa($expression); ?>";
        });

        // Share default SEO data with all views
        View::composer('*', function ($view) {
            if (!isset($view->getData()['seo'])) {
                $view->with('defaultSeo', (new SeoService()));
            }
        });
    }
    

    public static function formatPriceFa($value): string
    {
        $number = (int) $value;

        
        $formatted = number_format($number, 0, '', '.');

        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

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

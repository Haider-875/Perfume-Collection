<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (file_exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $whatsapp = function_exists('settings') ? settings('site_whatsapp', '923008765432') : '923008765432';
            $cleanWhatsapp = preg_replace('/[^0-9]/', '', (string)$whatsapp);
            if (str_starts_with($cleanWhatsapp, '03')) {
                $cleanWhatsapp = '92' . substr($cleanWhatsapp, 1);
            }
            $view->with('whatsappNum', $cleanWhatsapp ?: '923008765432');
        });
    }
}

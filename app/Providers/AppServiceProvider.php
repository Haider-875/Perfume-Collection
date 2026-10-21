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
        if (config('app.env') === 'production' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Pagination\Paginator::useBootstrapFive();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $whatsapp = function_exists('settings') ? settings('site_whatsapp', '923363685732') : '923363685732';
            $cleanWhatsapp = preg_replace('/[^0-9]/', '', (string)$whatsapp);
            if (str_starts_with($cleanWhatsapp, '03')) {
                $cleanWhatsapp = '92' . substr($cleanWhatsapp, 1);
            }
            $view->with('whatsappNum', $cleanWhatsapp ?: '923363685732');
            $view->with('settings', function_exists('settings') ? settings() : []);

            $cartCount = 0;
            try {
                if (request()->hasSession()) {
                    $cart = app(\App\Services\CartService::class)->getCart(request());
                    $cartCount = (int) $cart->items->sum('quantity');
                }
            } catch (\Throwable $e) {
                // Fail silently
            }
            $view->with('cartCount', $cartCount);
        });
    }
}

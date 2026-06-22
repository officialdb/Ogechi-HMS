<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $keys = ['mail_from_address', 'app_name', 'resend_api_key', 'currency_symbol'];
                $settings = \Modules\Settings\Models\Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

                if (!empty($settings['resend_api_key'])) {
                    config([
                        'mail.default'              => 'resend',
                        'mail.from.address'         => $settings['mail_from_address'] ?? config('mail.from.address'),
                        'mail.from.name'            => $settings['app_name'] ?? config('app.name'),
                        'resend.api_key'            => $settings['resend_api_key'],
                    ]);
                }
                
                \Illuminate\Support\Facades\View::share('currency_symbol', $settings['currency_symbol'] ?? '$');
            }
        } catch (\Exception $e) {
            // Ignore if database/table isn't set up yet
            \Illuminate\Support\Facades\View::share('currency_symbol', '$');
        }
    }
}

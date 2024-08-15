<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::if('IsAdmin', function () {
            return Auth::user()->role_id == 0;
        });
        Blade::if('IsMentor', function () {
            return Auth::user()->role_id == 1;
        });
        Blade::if('IsPeserta', function () {
            return Auth::user()->role_id == 2;
        });
        Blade::if('IsHrd', function () {
            return Auth::user()->role_id == 3;
        });

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // VerifyEmail::toMailUsing(function ($notifiable, $url) {
        //     return (new MailMessage)
        //         ->subject('Verify Email Address')
        //         ->line('Click the button below to verify your email address.')
        //         ->action('Verify Email Address', $url);
        // });
    }
}

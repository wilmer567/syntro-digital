<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

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
        if (app()->isProduction() && config('app.debug')) {
            throw new RuntimeException('APP_DEBUG must be false in production.');
        }

        if (app()->isProduction() || config('app.force_https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        RateLimiter::for('web-global', function (Request $request): Limit {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('admin-login', function (Request $request): array {
            $email = Str::lower(trim((string) $request->input('email')));
            $identity = hash('sha256', $email.'|'.$request->ip());

            return [
                Limit::perMinute(5)->by('admin-login:identity:'.$identity),
                Limit::perMinute(30)->by('admin-login:ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('contact-form', function (Request $request): Limit {
            return Limit::perMinute(5)->by('contact-form:'.$request->ip());
        });

        RateLimiter::for('firebase-admin', function (Request $request): Limit {
            return Limit::perMinute(10)->by('firebase-admin:'.$request->user()?->getAuthIdentifier());
        });
    }
}

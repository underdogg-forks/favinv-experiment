<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        // Routes are now registered in bootstrap/app.php
    }


    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Web Rate Limiting
        RateLimiter::for('web', function (Request $request) {
            $maxAttempts = 600;
            $limits = [];

            $customResponse = function ($request) {
                if (request()->expectsJson()) {
                    return errorResponse(__('message.too_many_attempts'), 429);
                }
                abort(429);
            };

            if ($ip = $request->ip()) {
                $limits[] = Limit::perMinute($maxAttempts)
                    ->by("web:ip:{$ip}")
                    ->response($customResponse);
            }

            if ($userId = $request->user()?->id) {
                $limits[] = Limit::perMinute($maxAttempts)
                    ->by("web:user:{$userId}")
                    ->response($customResponse);
            }

            if ($sessionId = $request->session()->getId()) {
                $limits[] = Limit::perMinute($maxAttempts)
                    ->by("web:session:{$sessionId}")
                    ->response($customResponse);
            }

            return $limits;
        });
    }
}

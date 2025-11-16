<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Maximum rate limit attempts for web routes.
     */
    private const WEB_MAX_ATTEMPTS = 600;

    /**
     * Maximum rate limit attempts for API routes.
     */
    private const API_MAX_ATTEMPTS = 60;

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        // Routes are now registered in bootstrap/app.php
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        $this->configureApiRateLimiting();
        $this->configureWebRateLimiting();
    }

    /**
     * Configure rate limiting for API routes.
     */
    private function configureApiRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $identifier = $request->user()?->id ?: $request->ip();
            
            return Limit::perMinute(self::API_MAX_ATTEMPTS)->by($identifier);
        });
    }

    /**
     * Configure rate limiting for web routes.
     */
    private function configureWebRateLimiting(): void
    {
        RateLimiter::for('web', function (Request $request) {
            $limits = [];
            $customResponse = $this->createRateLimitResponse();

            $this->addIpBasedLimit($request, $limits, $customResponse);
            $this->addUserBasedLimit($request, $limits, $customResponse);
            $this->addSessionBasedLimit($request, $limits, $customResponse);

            return $limits;
        });
    }

    /**
     * Create a custom response for rate limit exceeded.
     */
    private function createRateLimitResponse(): \Closure
    {
        return function () {
            if (request()->expectsJson()) {
                return errorResponse(trans('message.too_many_attempts'), 429);
            }
            
            abort(429);
        };
    }

    /**
     * Add IP-based rate limit to the limits array.
     */
    private function addIpBasedLimit(Request $request, array &$limits, \Closure $customResponse): void
    {
        $ip = $request->ip();
        
        if (!$ip) {
            return;
        }

        $limits[] = Limit::perMinute(self::WEB_MAX_ATTEMPTS)
            ->by("web:ip:{$ip}")
            ->response($customResponse);
    }

    /**
     * Add user-based rate limit to the limits array.
     */
    private function addUserBasedLimit(Request $request, array &$limits, \Closure $customResponse): void
    {
        $userId = $request->user()?->id;
        
        if (!$userId) {
            return;
        }

        $limits[] = Limit::perMinute(self::WEB_MAX_ATTEMPTS)
            ->by("web:user:{$userId}")
            ->response($customResponse);
    }

    /**
     * Add session-based rate limit to the limits array.
     */
    private function addSessionBasedLimit(Request $request, array &$limits, \Closure $customResponse): void
    {
        $sessionId = $request->session()->getId();
        
        if (!$sessionId) {
            return;
        }

        $limits[] = Limit::perMinute(self::WEB_MAX_ATTEMPTS)
            ->by("web:session:{$sessionId}")
            ->response($customResponse);
    }
}

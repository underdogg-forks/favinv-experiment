<?php

use App\Http\Middleware\SecurityEnforcer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Csp\AddCspHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        then: fn() => registerAdditionalRoutes(),
    )
    ->withMiddleware(fn(Middleware $middleware) => configureMiddleware($middleware))
    ->withExceptions(fn(Exceptions $exceptions) => configureExceptions($exceptions))
    ->create();

/**
 * Register additional route groups.
 */
function registerAdditionalRoutes(): void
{
    // Third party routes
    Route::middleware('validateThirdParty')
        ->group(base_path('routes/thirdparty.php'));
    
    // Installer routes
    Route::middleware('isInstalled')
        ->group(base_path('routes/installer.php'));
}

/**
 * Configure application middleware.
 */
function configureMiddleware(Middleware $middleware): void
{
    configureGlobalMiddleware($middleware);
    configureMiddlewareGroups($middleware);
    configureMiddlewareAliases($middleware);
}

/**
 * Configure global middleware stack.
 */
function configureGlobalMiddleware(Middleware $middleware): void
{
    $middleware->use([
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\LanguageMiddleware::class,
        SecurityEnforcer::class,
        AddCspHeaders::class,
    ]);
}

/**
 * Configure middleware groups (web, api, installer).
 */
function configureMiddlewareGroups(Middleware $middleware): void
{
    // Web middleware group
    $middleware->web(append: [
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Spatie\Referer\CaptureReferer::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    // API middleware group
    $middleware->api(prepend: [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    // Installer middleware group
    $middleware->group('installer', [
        \App\Http\Middleware\LanguageMiddleware::class,
    ]);
}

/**
 * Configure middleware aliases.
 */
function configureMiddlewareAliases(Middleware $middleware): void
{
    $middleware->alias([
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'installAgora' => \App\Http\Middleware\Install::class,
        'isInstalled' => \App\Http\Middleware\IsInstalled::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        '2fa' => \PragmaRX\Google2FALaravel\Middleware::class,
        'pulse.enabled' => \App\Http\Middleware\CheckPulseEnabled::class,
        'language' => \App\Http\Middleware\LanguageMiddleware::class,
        'blockFailedVerifications' => \App\Http\Middleware\BlockFailedVerifications::class,
        'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
        'admin' => \App\Http\Middleware\Admin::class,
        'validateThirdParty' => \App\Http\Middleware\VerifyThirdPartyApps::class,
    ]);
}

/**
 * Configure exception handling.
 */
function configureExceptions(Exceptions $exceptions): void
{
    // Custom exception handling can be added here
}


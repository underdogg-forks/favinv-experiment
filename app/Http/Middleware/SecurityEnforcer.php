<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Handles all security related headers.
 *
 * @refer https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Strict_Transport_Security_Cheat_Sheet.html
 * @refer https://www.owasp.org/index.php/Cross_Frame_Scripting
 */
class SecurityEnforcer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! config('database.DB_INSTALL')) {
            return $next($request);
        }

        $response = $next($request);

        if (method_exists($response, 'header')) {
            // Prevent clickjacking attacks - tells browser that faveo cannot be used within an iframe
            $response->header('X-Frame-Options', 'SAMEORIGIN');
            
            // Prevent MIME-sniffing attacks
            $response->header('X-Content-Type-Options', 'nosniff');
            
            // Enable XSS protection in browsers
            $response->header('X-XSS-Protection', '1; mode=block');
            
            // Referrer policy - control how much referrer information is passed
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // Permissions policy - restrict access to browser features
            $response->header('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

            // redirecting to https if configured to open in https
            if ($this->urlScheme(config('app.url')) == 'https' && $this->urlScheme($request->url()) == 'http') {
                return redirect()->secure($request->getPathInfo());
            }

            // Add HSTS header if using HTTPS
            if ($request->secure() || $this->urlScheme(config('app.url')) == 'https') {
                // max-age of 1 year (31536000 seconds), include subdomains
                $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }
        }

        return $response;
    }

    /**
     * Checks if url is http or https.
     *
     * @param  string  $url
     * @return string
     */
    private function urlScheme($url)
    {
        $parsedUrl = parse_url($url);

        if (! $parsedUrl) {
            return '';
        }

        return $parsedUrl['scheme'];
    }
}

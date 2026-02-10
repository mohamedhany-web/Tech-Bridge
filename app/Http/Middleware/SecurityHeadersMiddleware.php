<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers - بدون CSP صارمة لتجنب مشاكل التصميم
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy - مرنة لدعم جميع الموارد
        // تعطيل CSP مؤقتاً في بيئة التطوير لتجنب مشاكل التصميم
        // يمكن تفعيل CSP في الإنتاج بعد التأكد من عمل جميع الموارد
        if (!config('app.debug')) {
            $csp = "default-src 'self' https: data: blob:; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; " .
                   "style-src 'self' 'unsafe-inline' https:; " .
                   "img-src 'self' data: https: blob:; " .
                   "font-src 'self' data: https:; " .
                   "connect-src 'self' https:; " .
                   "frame-src 'self' https:; " .
                   "media-src 'self' https: blob:; " .
                   "object-src 'none'; " .
                   "base-uri 'self'; " .
                   "form-action 'self'; " .
                   "frame-ancestors 'self';";
            
            $response->headers->set('Content-Security-Policy', $csp);
        }
        
        // Strict Transport Security (HTTPS only)
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}

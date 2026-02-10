<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BruteForceProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->getKey($request);
        $attempts = Cache::get($key, 0);
        $maxAttempts = 5; // الحد الأقصى للمحاولات
        $lockoutTime = 900; // 15 دقيقة بالثواني

        // التحقق من الحظر
        if ($attempts >= $maxAttempts) {
            $lockoutKey = $key . ':locked';
            $lockedUntil = Cache::get($lockoutKey);
            
            if ($lockedUntil && $lockedUntil > now()->timestamp) {
                $remaining = $lockedUntil - now()->timestamp;
                $minutes = ceil($remaining / 60);
                
                Log::warning('محاولة وصول محظورة - Brute Force Protection', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'path' => $request->path(),
                    'remaining_minutes' => $minutes,
                ]);
                
                return response()->json([
                    'error' => 'تم حظر الوصول مؤقتاً بسبب كثرة المحاولات الفاشلة. يرجى المحاولة بعد ' . $minutes . ' دقيقة.',
                ], 429)->header('Retry-After', $remaining);
            } else {
                // إعادة تعيين المحاولات بعد انتهاء فترة الحظر
                Cache::forget($key);
                Cache::forget($lockoutKey);
            }
        }

        $response = $next($request);

        // إذا فشل تسجيل الدخول، زيادة عدد المحاولات
        if ($response->getStatusCode() >= 400 && $request->is('login') || $request->is('admin/*')) {
            $attempts++;
            Cache::put($key, $attempts, now()->addMinutes(15));
            
            if ($attempts >= $maxAttempts) {
                $lockoutKey = $key . ':locked';
                Cache::put($lockoutKey, now()->addMinutes(15)->timestamp, now()->addMinutes(15));
                
                Log::warning('تم حظر IP بسبب كثرة المحاولات الفاشلة', [
                    'ip' => $request->ip(),
                    'attempts' => $attempts,
                    'user_agent' => $request->userAgent(),
                ]);
            }
        } else {
            // إذا نجح، إعادة تعيين المحاولات
            Cache::forget($key);
            Cache::forget($key . ':locked');
        }

        return $response;
    }

    /**
     * الحصول على مفتاح فريد للمحاولات
     */
    private function getKey(Request $request): string
    {
        $identifier = $request->ip();
        
        // إذا كان هناك معرف مستخدم، أضفه للمفتاح
        if ($request->filled('phone')) {
            $identifier .= ':' . md5($request->phone);
        } elseif ($request->filled('email')) {
            $identifier .= ':' . md5($request->email);
        }
        
        return 'brute_force:' . md5($identifier);
    }
}

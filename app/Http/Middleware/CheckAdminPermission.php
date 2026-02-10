<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        // التحقق من أن المستخدم نشط
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'حسابك غير نشط. يرجى التواصل مع الإدارة.');
        }

        // التحقق من أن المستخدم هو admin أو super_admin
        $userRole = strtolower(trim($user->role));
        
        // دعم الأدوار القديمة والجديدة
        $allowedRoles = ['super_admin', 'admin'];
        
        if (!in_array($userRole, $allowedRoles)) {
            // إذا لم يكن admin، إعادة توجيه مع رسالة خطأ
            return redirect('/dashboard')->with('error', 'غير مسموح لك بالوصول إلى صفحات الإدارة');
        }

        return $next($request);
    }
}

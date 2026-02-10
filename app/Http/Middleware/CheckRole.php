<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();

        // التحقق من الدور
        $allowedRoles = explode('|', $role);
        $userRole = strtolower(trim($user->role));

        // دعم الأدوار القديمة والجديدة
        $roleMapping = [
            'admin' => 'super_admin',
            'teacher' => 'instructor',
        ];

        if (isset($roleMapping[$userRole])) {
            $userRole = $roleMapping[$userRole];
        }

        if (!in_array($userRole, $allowedRoles)) {
            return redirect('/dashboard')->with('error', 'غير مسموح لك بالوصول لهذه الصفحة');
        }

        return $next($request);
    }
}


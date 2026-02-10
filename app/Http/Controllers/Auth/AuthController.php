<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register', [
            'countryCodes' => config('country_codes.list', []),
        ]);
    }

    public function login(Request $request)
    {
        $key = 'login_attempts:' . $request->ip() . ':' . md5($request->email ?? '');
        $attempts = \Cache::get($key, 0);

        if ($attempts >= 5) {
            return back()->withErrors([
                'email' => 'تم تجاوز الحد الأقصى للمحاولات. يرجى المحاولة بعد 15 دقيقة.',
            ])->withInput();
        }

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'أدخل بريداً إلكترونياً صحيحاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
        ]);

        if ($validator->fails()) {
            \Cache::put($key, $attempts + 1, now()->addMinutes(15));
            return back()->withErrors($validator)->withInput();
        }

        try {
            $email = filter_var(trim($request->email), FILTER_SANITIZE_EMAIL);
            $password = $request->password;

            $user = User::where('email', $email)->first();

            if (!$user) {
                \Cache::put($key, $attempts + 1, now()->addMinutes(15));
                \Log::warning('محاولة دخول فاشلة - مستخدم غير موجود', [
                    'email' => substr($email, 0, 3) . '***',
                    'ip' => $request->ip(),
                ]);
                return back()->withErrors([
                    'email' => 'بيانات الدخول غير صحيحة. تحقق من البريد الإلكتروني.',
                ])->withInput();
            }

            if (!Hash::check($password, $user->password)) {
                \Cache::put($key, $attempts + 1, now()->addMinutes(15));
                \Log::warning('محاولة دخول فاشلة - كلمة مرور خاطئة', [
                    'user_id' => $user->id,
                    'ip' => $request->ip(),
                ]);
                return back()->withErrors([
                    'email' => 'بيانات الدخول غير صحيحة. تحقق من كلمة المرور.',
                ])->withInput();
            }

            if (!$user->is_active) {
                return back()->withErrors([
                    'email' => 'حسابك غير نشط. يرجى التواصل مع الإدارة.',
                ])->withInput();
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            \Cache::forget($key);
            \DB::table('users')->where('id', $user->id)->update(['last_login_at' => now()]);
            \Log::info('دخول ناجح للمستخدم', ['user_id' => $user->id, 'name' => $user->name, 'ip' => $request->ip()]);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            \Log::error('خطأ في تسجيل الدخول: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'حدث خطأ أثناء تسجيل الدخول. حاول مرة أخرى.',
            ])->withInput();
        }
    }

    public function register(Request $request)
    {
        $countryKeys = array_keys(config('country_codes.list', []));
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country_code' => [
                'required',
                'string',
                'in:' . implode(',', $countryKeys),
            ],
            'phone' => 'required|string|max:20',
        ];

        $messages = [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'country_code.required' => 'كود الدولة مطلوب',
            'country_code.in' => 'كود الدولة غير صحيح',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.regex' => 'رقم الهاتف غير صحيح لهذه الدولة',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $countries = config('country_codes.list', []);
        $countryKey = $request->country_code;
        if ($request->filled('phone') && $request->filled('country_code') && isset($countries[$countryKey])) {
            $country = $countries[$countryKey];
            $validator->after(function ($v) use ($country, $request) {
                if (!preg_match($country['regex'], $request->phone)) {
                    $v->errors()->add('phone', 'رقم الهاتف غير صحيح لـ ' . $country['name'] . '. مثال: ' . $country['placeholder']);
                }
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name = $this->sanitizeInput($request->name);
        $email = filter_var(trim($request->email), FILTER_SANITIZE_EMAIL);
        $phoneDigits = preg_replace('/\D/', '', $request->phone);
        $code = config("country_codes.list.{$request->country_code}.code", '');
        $phone = $code . $phoneDigits;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'is_active' => true,
        ]);

        // تفعيل دور الطالب وجميع صلاحيات الطالب تلقائياً (القائمة الجانبية ولوحة التحكم)
        $user->assignRole('student');
        $studentPermissionIds = Permission::where(function ($q) {
            $q->where('name', 'like', 'student.view.%')->orWhere('name', 'view.dashboard');
        })->pluck('id');
        $user->directPermissions()->sync($studentPermissionIds);

        // معالجة كود الإحالة إذا كان موجوداً
        if ($request->filled('referral_code')) {
            $referralService = app(\App\Services\ReferralService::class);
            $referralCode = strtoupper(trim($request->referral_code));
            $referrer = User::where('referral_code', $referralCode)->first();
            
            if ($referrer && $referrer->id !== $user->id) {
                $referralService->processReferral($referrer, $user, $referralCode);
            }
        }

        // إنشاء كود إحالة للمستخدم الجديد
        $referralService = app(\App\Services\ReferralService::class);
        $referralService->generateReferralCode($user);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * تعقيم المدخلات لمنع XSS و SQL Injection
     */
    private function sanitizeInput(string $input): string
    {
        // إزالة HTML tags
        $input = strip_tags($input);
        
        // إزالة الأحرف الخاصة الخطيرة
        $input = preg_replace('/[<>"\']/', '', $input);
        
        // تنظيف المسافات الزائدة
        $input = preg_replace('/\s+/', ' ', $input);
        
        return trim($input);
    }
}

@extends('layouts.public')

@section('title', 'إنشاء حساب - Tech Bridge')

@section('content')
<section class="py-12 sm:py-16 min-h-[80vh] flex items-center bg-slate-50/80">
    <div class="max-w-lg mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="page-card p-6 sm:p-8 rounded-2xl">
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-block mb-3">
                    <span class="text-2xl font-black logo-text-gradient">Tech Bridge</span>
                </a>
                <h1 class="section-title text-2xl mb-2">إنشاء حساب جديد</h1>
                <p class="section-subtitle">انضم إلى منصة التعلم — التسجيل للطلاب</p>
            </div>

            <div class="bg-sky-50 border border-sky-100 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <p class="text-sm text-slate-700">التسجيل متاح للطلاب. إنشاء حسابات المدربين والإدارة يتم من قبل الإدارة.</p>
                </div>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4"
                  x-data="{ showPassword: false, showPasswordConfirm: false }">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">الاسم الكامل</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('name') border-red-300 @enderror"
                           placeholder="أدخل اسمك الكامل">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('email') border-red-300 @enderror"
                           placeholder="example@email.com" dir="ltr">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @php $countryCodes = $countryCodes ?? config('country_codes.list', ['20' => ['code' => '+20', 'name' => 'مصر', 'placeholder' => '1XXXXXXXXX', 'max_length' => 11]]); @endphp
                <div x-data="{ countryCode: '{{ old('country_code', '20') }}', countries: @json($countryCodes) }">
                    <label class="block text-sm font-medium text-slate-700 mb-1">رقم الهاتف</label>
                    <div class="flex flex-wrap gap-2">
                        <select name="country_code" x-model="countryCode" required
                                class="w-full sm:w-auto min-w-0 sm:max-w-[11rem] px-3 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 dark:bg-white text-sm @error('country_code') border-red-300 @enderror"
                                dir="ltr">
                            @forelse($countryCodes as $key => $country)
                            <option value="{{ $key }}" {{ old('country_code', '20') == (string)$key ? 'selected' : '' }}>{{ $country['code'] }} {{ $country['name'] }}</option>
                            @empty
                            <option value="20">+20 مصر</option>
                            @endforelse
                        </select>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                               :placeholder="countries[countryCode] ? countries[countryCode].placeholder : ''"
                               :maxlength="countries[countryCode] ? countries[countryCode].max_length : 15"
                               class="flex-1 min-w-0 sm:min-w-[10rem] px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('phone') border-red-300 @enderror"
                               dir="ltr">
                    </div>
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('country_code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @php $referralCode = request()->get('ref') ?? old('referral_code'); @endphp
                <div>
                    <label for="referral_code" class="block text-sm font-medium text-slate-700 mb-1">كود الإحالة (اختياري)</label>
                    <input type="text" name="referral_code" id="referral_code" value="{{ $referralCode }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all uppercase"
                           placeholder="REF123456" dir="ltr">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('password') border-red-300 @enderror"
                               placeholder="كلمة مرور قوية">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i x-show="!showPassword" class="fas fa-eye"></i>
                            <i x-show="showPassword" class="fas fa-eye-slash" x-cloak></i>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">تأكيد كلمة المرور</label>
                    <div class="relative">
                        <input :type="showPasswordConfirm ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all"
                               placeholder="أعد إدخال كلمة المرور">
                        <button type="button" @click="showPasswordConfirm = !showPasswordConfirm"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i x-show="!showPasswordConfirm" class="fas fa-eye"></i>
                            <i x-show="showPasswordConfirm" class="fas fa-eye-slash" x-cloak></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-start gap-2">
                    <input type="checkbox" id="terms" name="terms" required
                           class="mt-1 w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                    <label for="terms" class="text-sm text-slate-600">
                        أوافق على <a href="{{ route('public.terms') }}" class="text-sky-600 hover:underline">شروط الاستخدام</a>
                        و <a href="{{ route('public.privacy') }}" class="text-sky-600 hover:underline">سياسة الخصوصية</a>
                    </label>
                </div>
                <button type="submit" class="btn-page-primary w-full justify-center py-3">
                    <i class="fas fa-user-plus"></i>
                    إنشاء الحساب
                </button>
            </form>

            <p class="mt-6 text-center text-slate-600 text-sm">
                لديك حساب؟
                <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:text-sky-700">تسجيل الدخول</a>
            </p>
            <p class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-slate-500 text-sm hover:text-slate-700 inline-flex items-center gap-1">
                    <i class="fas fa-arrow-right"></i>
                    العودة للرئيسية
                </a>
            </p>
        </div>
    </div>
</section>
@endsection

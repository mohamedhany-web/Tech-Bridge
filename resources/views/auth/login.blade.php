@extends('layouts.public')

@section('title', 'تسجيل الدخول - Tech Bridge')

@section('content')
<section class="py-16 sm:py-20 min-h-[80vh] flex items-center bg-slate-50/80">
    <div class="max-w-md mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="page-card p-8 rounded-2xl">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block mb-4">
                    <span class="text-2xl font-black logo-text-gradient">Tech Bridge</span>
                </a>
                <h1 class="section-title text-2xl mb-2">تسجيل الدخول</h1>
                <p class="section-subtitle">سجّل دخولك للوصول إلى منصة التعلم</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5" x-data="{ showPassword: false }">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('email') border-red-300 @enderror"
                           placeholder="example@email.com" dir="ltr">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all @error('password') border-red-300 @enderror"
                               placeholder="أدخل كلمة المرور">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i x-show="!showPassword" class="fas fa-eye"></i>
                            <i x-show="showPassword" class="fas fa-eye-slash" x-cloak></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                        <span class="text-slate-600">تذكرني</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sky-600 font-medium hover:text-sky-700">نسيت كلمة المرور؟</a>
                    @endif
                </div>
                <button type="submit" class="btn-page-primary w-full justify-center py-3">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </button>
            </form>

            <p class="mt-6 text-center text-slate-600 text-sm">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:text-sky-700">إنشاء حساب</a>
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

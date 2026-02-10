<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tech Bridge - أكاديمية البرمجة')</title>

    <!-- الخطوط العربية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles from welcome.blade.php -->
    @include('layouts.public-styles')
</head>

<body class="bg-gray-50 text-gray-900"
      x-data="{ mobileMenu: false }"
      :class="{ 'no-scroll': mobileMenu }">
    
    <!-- Navigation Header - نفس الناف بار من الصفحة الرئيسية -->
    <nav id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-white/20 shadow-2xl transition-all duration-300" style="overflow: visible !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="overflow: visible !important; position: relative;">
            <div class="flex justify-between items-center h-24">
                <!-- Enhanced Logo -->
                <div class="flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="flex items-center space-x-4 space-x-reverse">
                        <div class="relative">
                        <div class="w-28 h-28 bg-transparent rounded-2xl flex items-center justify-center logo-animation p-1">
                            <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge Logo" class="w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-3xl\'></i>';">
                        </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-sky-500 rounded-full pulse-animation"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black text-white text-glow">Tech Bridge</h1>
                            <p class="text-sm text-white/80 font-medium">أكاديمية برمجة</p>
                            <p class="text-xs text-white/60">تعلم البرمجة من الصفر إلى الاحتراف</p>
                        </div>
                    </a>
                </div>

                <!-- Enhanced Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="relative {{ request()->routeIs('home') ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">الرئيسية</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs('home') ? '15' : '5' }} rounded-lg {{ request()->routeIs('home') ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.courses') }}" class="relative {{ request()->routeIs('public.courses*') ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">الكورسات</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs('public.courses*') ? '15' : '5' }} rounded-lg {{ request()->routeIs('public.courses*') ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.about') }}" class="relative {{ request()->routeIs('public.about') ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">من نحن</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs('public.about') ? '15' : '5' }} rounded-lg {{ request()->routeIs('public.about') ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.blog.index') }}" class="relative {{ request()->routeIs('public.blog.*') ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">المدونة</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs('public.blog.*') ? '15' : '5' }} rounded-lg {{ request()->routeIs('public.blog.*') ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.contact') }}" class="relative {{ request()->routeIs('public.contact') ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">تواصل معنا</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs('public.contact') ? '15' : '5' }} rounded-lg {{ request()->routeIs('public.contact') ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                </div>

                <!-- Enhanced Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">
                                <i class="fas fa-tachometer-alt bounce-animation"></i>
                                <span>لوحة التحكم</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-white/80 hover:text-white font-medium px-6 py-3 rounded-full transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-sign-in-alt ml-2"></i>
                                دخول
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary shadow-lg">
                                <i class="fas fa-user-plus pulse-animation"></i>
                                <span>انضم الآن</span>
                            </a>
                        @endauth
                    @endif
                </div>

                <!-- Enhanced Mobile Menu Button -->
                <div class="lg:hidden">
                    <button @click="mobileMenu = !mobileMenu" 
                            class="relative w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-bars text-xl" x-show="!mobileMenu"></i>
                        <i class="fas fa-times text-xl" x-show="mobileMenu"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Enhanced Mobile Menu -->
        <div x-show="mobileMenu" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="lg:hidden bg-white/95 backdrop-blur-xl border-t border-white/20 shadow-xl">
            <div class="px-6 py-8 space-y-6 max-h-[calc(100vh-110px)] overflow-y-auto pr-1">
                <a href="{{ route('home') }}" class="block text-gray-900 font-bold text-xl py-3 border-b border-gray-200 hover:text-sky-600 transition-colors {{ request()->routeIs('home') ? 'text-sky-600' : '' }}">
                    <i class="fas fa-home ml-3 text-sky-500"></i>
                    الرئيسية
                </a>
                <a href="{{ route('public.courses') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors {{ request()->routeIs('public.courses*') ? 'text-sky-600 font-semibold' : '' }}">
                    <i class="fas fa-code ml-3 text-sky-500"></i>
                    الكورسات
                </a>
                <a href="{{ route('public.about') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors {{ request()->routeIs('public.about') ? 'text-sky-600 font-semibold' : '' }}">
                    <i class="fas fa-graduation-cap ml-3 text-sky-500"></i>
                    من نحن
                </a>
                <a href="{{ route('public.blog.index') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors {{ request()->routeIs('public.blog.*') ? 'text-sky-600 font-semibold' : '' }}">
                    <i class="fas fa-newspaper ml-3 text-sky-500"></i>
                    المدونة
                </a>
                <a href="{{ route('public.contact') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors {{ request()->routeIs('public.contact') ? 'text-sky-600 font-semibold' : '' }}">
                    <i class="fas fa-envelope ml-3 text-sky-500"></i>
                    تواصل معنا
                </a>

                @if (Route::has('login'))
                    <div class="pt-4 space-y-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary w-full justify-center">
                                <i class="fas fa-tachometer-alt"></i>
                                لوحة التحكم
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline w-full justify-center">
                                <i class="fas fa-sign-in-alt"></i>
                                تسجيل الدخول
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary w-full justify-center">
                                <i class="fas fa-user-plus"></i>
                                إنشاء حساب
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.public-footer')

    @stack('scripts')

    <script>
        // تأثير الناف بار عند السكرول - شفافية مع نص واضح
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    const currentScroll = window.pageYOffset;
                    
                    if (currentScroll > 100) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                });
            }
        });
    </script>
</body>
</html>


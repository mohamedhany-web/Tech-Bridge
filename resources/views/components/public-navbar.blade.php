<!-- Navigation Header -->
<nav id="mainNavbar" 
     x-data="{ mobileMenu: false }"
     class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-white/20 shadow-2xl transition-all duration-300" 
     style="overflow: visible !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="overflow: visible !important; position: relative;">
        <div class="flex justify-between items-center h-24">
            <!-- Logo -->
            <div class="flex items-center space-x-4 space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center space-x-4 space-x-reverse">
                    <div class="relative">
                        <div class="w-28 h-28 bg-transparent rounded-2xl flex items-center justify-center logo-animation p-1">
                            <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge Logo" class="w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-3xl rotate-animation\'></i>';">
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

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
                @php
                    $desktopLinks = [
                        ['route' => 'home', 'label' => 'الرئيسية', 'match' => 'home'],
                        ['route' => 'public.courses', 'label' => 'الكورسات', 'match' => 'public.courses*'],
                        ['route' => 'public.about', 'label' => 'من نحن', 'match' => 'public.about'],
                        ['route' => 'public.blog.index', 'label' => 'المدونة', 'match' => 'public.blog.*'],
                        ['route' => 'public.contact', 'label' => 'تواصل معنا', 'match' => 'public.contact'],
                    ];
                @endphp
                @foreach ($desktopLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="relative {{ request()->routeIs($link['match']) ? 'text-white font-bold' : 'text-white/80 hover:text-white font-medium' }} text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">{{ $link['label'] }}</span>
                        <div class="absolute inset-0 bg-white/{{ request()->routeIs($link['match']) ? '15' : '5' }} rounded-lg {{ request()->routeIs($link['match']) ? 'scale-100' : 'scale-0 group-hover:scale-100' }} transition-transform duration-300"></div>
                    </a>
                @endforeach
            </div>

            <!-- Auth Buttons -->
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

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button x-on:click="mobileMenu = !mobileMenu"
                        class="relative w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenu"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenu"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="lg:hidden fixed inset-x-0 top-24 bottom-0 z-[60] pointer-events-none">
        <div class="h-full bg-white/95 backdrop-blur-xl border-t border-white/20 shadow-xl px-6 py-8 space-y-6 overflow-y-auto pointer-events-auto">
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

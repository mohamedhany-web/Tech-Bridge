<!-- Navigation Header - تصميم محسّن ولوغو واضح -->
<nav id="mainNavbar"
     x-data="{ mobileMenu: false }"
     class="fixed top-0 left-0 right-0 z-50 navbar-bg shadow-lg border-b border-white/10"
     style="overflow: visible !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="overflow: visible !important; position: relative;">
        <div class="flex justify-between items-center h-[4.5rem]">
            <!-- Logo - خلفية بيضاء لظهور اللوغو بوضوح -->
            <div class="flex items-center gap-3 gap-reverse">
                <a href="{{ route('home') }}" class="flex items-center gap-3 gap-reverse group">
                    <div class="nav-logo-box flex items-center justify-center rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge" class="nav-logo-img w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-2xl\'></i>';">
                    </div>
                    <div class="hidden sm:block">
                        <span class="nav-brand-text block font-black text-white leading-tight">Tech Bridge</span>
                        <span class="nav-brand-sub block text-sm text-white/90 font-medium">أكاديمية برمجة</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-1 gap-reverse">
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
                       class="nav-link-item px-4 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200 {{ request()->routeIs($link['match']) ? 'nav-link-active' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Auth Buttons -->
            <div class="hidden lg:flex items-center gap-3 gap-reverse">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-nav-primary">
                            <i class="fas fa-tachometer-alt ml-2"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav-ghost">
                            <i class="fas fa-sign-in-alt ml-2"></i>
                            دخول
                        </a>
                        <a href="{{ route('register') }}" class="btn-nav-primary">
                            <i class="fas fa-user-plus ml-2"></i>
                            <span>انضم الآن</span>
                        </a>
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button x-on:click="mobileMenu = !mobileMenu"
                        class="nav-mobile-btn w-12 h-12 rounded-xl flex items-center justify-center text-white border border-white/25 hover:bg-white/15 transition-all duration-200">
                    <i class="fas fa-bars text-xl" x-show="!mobileMenu"></i>
                    <i class="fas fa-times text-xl" x-show="mobileMenu"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu - درج جانبي من اليمين (بدون teleport لضمان ربط Alpine) -->
    <!-- Overlay - النقر يغلق القائمة -->
    <div x-show="mobileMenu"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-250"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-on:click="mobileMenu = false"
         class="lg:hidden fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm">
    </div>
    <!-- Drawer -->
    <div x-show="mobileMenu"
         x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-250 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="mobile-drawer lg:hidden fixed top-0 right-0 bottom-0 z-[101] w-[min(320px,88vw)] max-w-full flex flex-col shadow-2xl bg-[#0369a1]"
         style="background: linear-gradient(180deg, #0284c7 0%, #0369a1 50%, #0c4a6e 100%);"
         @click.self="mobileMenu = false">
        <div class="mobile-drawer-header flex items-center justify-between px-5 py-4 border-b border-white/30">
            <span class="text-lg font-black text-white">القائمة</span>
            <button type="button" x-on:click="mobileMenu = false"
                    class="mobile-drawer-close w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center hover:bg-white/30 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="mobile-drawer-nav flex-1 overflow-y-auto px-4 py-5 space-y-1">
            <a href="{{ route('home') }}" class="mobile-drawer-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('home') ? 'mobile-drawer-link-active' : '' }}">
                <i class="fas fa-home w-6 text-center text-lg text-white"></i>
                <span class="text-white">الرئيسية</span>
            </a>
            <a href="{{ route('public.courses') }}" class="mobile-drawer-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('public.courses*') ? 'mobile-drawer-link-active' : '' }}">
                <i class="fas fa-code w-6 text-center text-lg text-white"></i>
                <span class="text-white">الكورسات</span>
            </a>
            <a href="{{ route('public.about') }}" class="mobile-drawer-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('public.about') ? 'mobile-drawer-link-active' : '' }}">
                <i class="fas fa-graduation-cap w-6 text-center text-lg text-white"></i>
                <span class="text-white">من نحن</span>
            </a>
            <a href="{{ route('public.blog.index') }}" class="mobile-drawer-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('public.blog.*') ? 'mobile-drawer-link-active' : '' }}">
                <i class="fas fa-newspaper w-6 text-center text-lg text-white"></i>
                <span class="text-white">المدونة</span>
            </a>
            <a href="{{ route('public.contact') }}" class="mobile-drawer-link flex items-center gap-3 px-4 py-3.5 rounded-xl text-white {{ request()->routeIs('public.contact') ? 'mobile-drawer-link-active' : '' }}">
                <i class="fas fa-envelope w-6 text-center text-lg text-white"></i>
                <span class="text-white">تواصل معنا</span>
            </a>

            @if (Route::has('login'))
            <div class="pt-4 mt-4 border-t border-white/30 space-y-3">
                @auth
                <a href="{{ url('/dashboard') }}" class="mobile-drawer-btn-primary flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold">
                    <i class="fas fa-tachometer-alt text-[#0369a1]"></i>
                    <span class="text-[#0369a1]">لوحة التحكم</span>
                </a>
                @else
                <a href="{{ route('login') }}" class="mobile-drawer-btn-outline flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-white border-2 border-white">
                    <i class="fas fa-sign-in-alt text-white"></i>
                    <span class="text-white">تسجيل الدخول</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-drawer-btn-primary flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold">
                    <i class="fas fa-user-plus text-[#0369a1]"></i>
                    <span class="text-[#0369a1]">إنشاء حساب</span>
                </a>
                @endauth
            </div>
            @endif
        </nav>
    </div>
</nav>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>الكورسات - Tech Bridge - أكاديمية البرمجة</title>

        <!-- الخطوط العربية الاحترافية -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Font Awesome للأيقونات -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom Styles - استخدام نفس الستايلات من public-styles -->
        @include('layouts.public-styles')
        <style>
            * { font-family: 'Cairo', system-ui, sans-serif; }
            .card-hover {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                position: relative;
                overflow: hidden;
            }
            .card-hover:hover {
                transform: translateY(-15px) scale(1.02);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }
            .floating-numbers {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }
            .floating-number {
                position: absolute;
                color: rgba(14, 165, 233, 0.3);
                font-size: 2rem;
                font-weight: bold;
                animation: floatNumber 15s linear infinite;
            }
            @keyframes floatNumber {
                0% { transform: translateY(100vh) rotate(0deg) scale(0.5); opacity: 0; }
                10% { opacity: 1; transform: translateY(90vh) rotate(36deg) scale(0.7); }
                50% { opacity: 0.8; transform: translateY(50vh) rotate(180deg) scale(1); }
                90% { opacity: 0.3; transform: translateY(10vh) rotate(324deg) scale(0.8); }
                100% { transform: translateY(-10vh) rotate(360deg) scale(0.3); opacity: 0; }
            }
            .btn-primary {
                background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 35%, #0369a1 60%, #475569 80%, #dc2626 100%);
                color: white;
                padding: 15px 40px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                border: none;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
            }
            .btn-primary:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 15px 35px rgba(14, 165, 233, 0.6);
            }
            .btn-outline {
                background: transparent;
                color: #0ea5e9;
                padding: 15px 40px;
                border-radius: 50px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                border: 2px solid #0ea5e9;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
                position: relative;
                overflow: hidden;
            }
            .btn-outline:hover {
                color: white;
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 15px 35px rgba(14, 165, 233, 0.5);
            }
            .nav-link {
                position: relative;
                transition: all 0.3s ease;
            }
            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                width: 0;
                height: 2px;
                background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 40%, #0369a1 65%, #475569 85%, #dc2626 100%);
                transition: all 0.3s ease;
                transform: translateX(-50%);
            }
            .nav-link:hover::after {
                width: 100%;
            }
            .course-card-hover {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                position: relative;
            }
            .course-card-hover:hover {
                transform: translateY(-10px) rotateX(5deg);
                box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            }
            .course-card-hover .course-header {
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
            }
            .course-card-hover:hover .course-header {
                transform: scale(1.05);
            }
            .particles {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }
            .particle {
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                animation: particleFloat 10s infinite linear;
            }
            @keyframes particleFloat {
                0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
                10% { opacity: 1; }
                90% { opacity: 1; }
                100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
            }
            .text-glow:hover {
                text-shadow: 0 0 20px rgba(14, 165, 233, 0.8);
                transition: all 0.3s ease;
            }
            .logo-animation {
                transition: all 0.4s ease;
            }
            .logo-animation:hover {
                transform: scale(1.1) rotate(5deg);
            }
            .pulse-animation {
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            .bounce-animation {
                animation: bounce 2s infinite;
            }
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            .rotate-animation {
                animation: rotate 4s linear infinite;
            }
            @keyframes rotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .fade-in {
                animation: fadeIn 1s ease-out;
            }
            @keyframes fadeIn {
                0% { opacity: 0; transform: translateY(30px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .slide-in-left {
                animation: slideInLeft 0.8s ease-out;
            }
            @keyframes slideInLeft {
                0% { opacity: 0; transform: translateX(-50px); }
                100% { opacity: 1; transform: translateX(0); }
            }
            [x-cloak] { display: none !important; }
            
            /* Gradient Animation */
            @keyframes gradient {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            .animate-gradient {
                background-size: 200% auto;
                animation: gradient 3s ease infinite;
            }
            
            /* Line Clamp */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            
            /* Enhanced Card Hover */
            .course-card-hover {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
            .course-card-hover:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 20px 40px rgba(14, 165, 233, 0.2);
            }
            
            /* Glass Effect Enhancement */
            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
            }
            
            /* Select Arrow Customization */
            select {
                background-image: none;
            }
            
            /* Smooth Transitions */
            * {
                transition-property: color, background-color, border-color, transform, box-shadow;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            /* Mobile Menu Fix */
            .no-scroll {
                overflow: hidden !important;
                height: 100vh !important;
                position: fixed !important;
                width: 100% !important;
            }
            
            /* Ensure mobile menu is on top */
            nav[x-data] {
                position: relative;
                z-index: 9999;
            }
            
            /* Mobile menu overlay */
            [x-show*="mobileMenu"] {
                z-index: 9998 !important;
            }
        </style>
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

                <!-- Enhanced Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="relative text-white/80 hover:text-white font-medium text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">الرئيسية</span>
                        <div class="absolute inset-0 bg-white/5 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.courses') }}" class="relative text-white font-bold text-lg nav-link group">
                        <span class="relative z-10">الكورسات</span>
                        <div class="absolute inset-0 bg-white/10 rounded-lg scale-100 transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.about') }}" class="relative text-white/80 hover:text-white font-medium text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">من نحن</span>
                        <div class="absolute inset-0 bg-white/5 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.blog.index') }}" class="relative text-white/80 hover:text-white font-medium text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">المدونة</span>
                        <div class="absolute inset-0 bg-white/5 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.contact') }}" class="relative text-white/80 hover:text-white font-medium text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">تواصل معنا</span>
                        <div class="absolute inset-0 bg-white/5 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
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
                <a href="{{ route('home') }}" class="block text-gray-900 font-bold text-xl py-3 border-b border-gray-200 hover:text-sky-600 transition-colors">
                    <i class="fas fa-home ml-3 text-sky-500"></i>
                    الرئيسية
                </a>
                <a href="{{ route('public.courses') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors">
                    <i class="fas fa-code ml-3 text-sky-500"></i>
                    الكورسات
                </a>
                <a href="{{ route('public.about') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors">
                    <i class="fas fa-graduation-cap ml-3 text-sky-500"></i>
                    من نحن
                </a>
                <a href="{{ route('public.blog.index') }}" class="block text-gray-700 font-medium text-lg py-3 border-b border-gray-200 hover:text-sky-600 transition-colors">
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

    <!-- Floating Code Symbols Background -->
    <div class="floating-numbers">
        <div class="floating-number" style="left: 10%; animation-delay: 0s;">{}</div>
        <div class="floating-number" style="left: 20%; animation-delay: 3s;">&lt;/&gt;</div>
        <div class="floating-number" style="left: 30%; animation-delay: 6s;">#</div>
        <div class="floating-number" style="left: 40%; animation-delay: 9s;">{}</div>
        <div class="floating-number" style="left: 50%; animation-delay: 12s;">&lt;/&gt;</div>
        <div class="floating-number" style="left: 60%; animation-delay: 15s;">#</div>
        <div class="floating-number" style="left: 70%; animation-delay: 18s;">()</div>
        <div class="floating-number" style="left: 80%; animation-delay: 21s;">[]</div>
        <div class="floating-number" style="left: 90%; animation-delay: 24s;">{}</div>
    </div>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-[60vh] flex items-center relative overflow-hidden pt-28 sm:pt-32"
             style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.85) 25%, rgba(14, 165, 233, 0.7) 50%, rgba(14, 165, 233, 0.75) 75%, rgba(2, 132, 199, 0.8) 100%);">
        <!-- Background Particles -->
        <div class="particles">
            <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
            <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
            <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
            <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
            <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
            <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
            <div class="particle" style="left: 70%; animation-delay: 12s;"></div>
            <div class="particle" style="left: 80%; animation-delay: 14s;"></div>
            <div class="particle" style="left: 90%; animation-delay: 16s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="text-center text-white">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight slide-in-left">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-500 via-sky-600 to-slate-400 text-glow">الكورسات البرمجية</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed fade-in">
                    اكتشف مجموعة شاملة من الكورسات البرمجية المصممة لتناسب جميع المستويات
                </p>
                
                <!-- Search and Filter -->
                <div class="max-w-4xl mx-auto mt-10">
                    <div class="glass-effect rounded-3xl p-6 sm:p-8 backdrop-blur-xl border border-white/30 shadow-2xl">
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- Search -->
                            <div class="flex-1 relative group">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/80 group-focus-within:text-white transition-colors">
                                    <i class="fas fa-search text-lg"></i>
                                </div>
                                <input type="text" 
                                       x-model="searchQuery"
                                       placeholder="ابحث عن كورس، لغة برمجة، أو موضوع..." 
                                       class="w-full px-12 py-4 sm:py-5 rounded-2xl bg-white/15 border-2 border-white/30 text-white placeholder-white/60 focus:outline-none focus:ring-4 focus:ring-sky-400/50 focus:border-white/50 transition-all duration-300 text-base sm:text-lg backdrop-blur-sm">
                            </div>
                            
                            <!-- Level Filter -->
                            <div class="relative">
                                <select x-model="selectedLevel" 
                                        class="w-full md:w-auto px-6 py-4 sm:py-5 rounded-2xl bg-white/15 border-2 border-white/30 text-white focus:outline-none focus:ring-4 focus:ring-sky-400/50 focus:border-white/50 transition-all duration-300 text-base sm:text-lg backdrop-blur-sm appearance-none cursor-pointer pr-10">
                                    <option value="" class="bg-gray-800 text-white">جميع المستويات</option>
                                    <option value="beginner" class="bg-gray-800 text-white">مبتدئ</option>
                                    <option value="intermediate" class="bg-gray-800 text-white">متوسط</option>
                                    <option value="advanced" class="bg-gray-800 text-white">متقدم</option>
                                </select>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none text-white/80">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Results Count -->
                        <div x-show="searchQuery || selectedLevel" 
                             x-cloak
                             class="mt-4 pt-4 border-t border-white/20">
                            <p class="text-white/80 text-sm">
                                <span x-text="filteredCourses.length"></span> كورس متاح
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    @if(isset($packages) && $packages->count() > 0)
    <section class="py-20 bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600">باقات الكورسات</span>
                </h2>
                <p class="text-xl text-gray-600">اختر الباقة المناسبة لك واحصل على أفضل قيمة</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($packages as $package)
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden course-card-hover border-2 {{ $package->is_popular ? 'border-sky-500 ring-4 ring-sky-200 scale-105' : 'border-gray-200' }} transition-all duration-300 hover:shadow-3xl group">
                    @if($package->is_popular)
                    <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-orange-500 text-white text-center py-3 shadow-lg">
                        <span class="font-black text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-crown text-lg"></i>
                            الأكثر شعبية
                        </span>
                    </div>
                    @endif
                    
                    <!-- Package Header -->
                    <div class="h-56 sm:h-64 bg-gradient-to-br flex items-center justify-center relative overflow-hidden course-header
                        @if($loop->index % 3 == 0) from-sky-400 via-sky-500 to-sky-600
                        @elseif($loop->index % 3 == 1) from-blue-500 via-blue-600 to-blue-700
                        @else from-indigo-500 via-indigo-600 to-indigo-700
                        @endif">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>
                        @if($package->thumbnail)
                            <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <i class="fas fa-box text-white text-7xl sm:text-8xl pulse-animation relative z-10 group-hover:scale-110 transition-transform duration-300"></i>
                        @endif
                        @if($package->is_featured)
                            <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 px-4 py-1.5 rounded-full text-xs font-bold shadow-lg bounce-animation z-20">
                                <i class="fas fa-star ml-1"></i>
                                مميز
                            </div>
                        @endif
                    </div>
                    
                    <!-- Package Content -->
                    <div class="p-6 sm:p-7">
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900 mb-3 group-hover:text-sky-600 transition-colors">
                            {{ $package->name }}
                        </h3>
                        <p class="text-gray-600 mb-5 text-sm sm:text-base leading-relaxed line-clamp-2">
                            {{ Str::limit($package->description ?? 'باقة شاملة من الكورسات البرمجية', 100) }}
                        </p>
                        
                        <!-- Features -->
                        @if($package->features && count($package->features) > 0)
                        <div class="mb-5 space-y-2.5">
                            @foreach(array_slice($package->features, 0, 3) as $feature)
                            <div class="flex items-center text-sm sm:text-base text-gray-700">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center ml-3">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                                <span class="font-medium">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        <!-- Courses Count -->
                        <div class="mb-5 p-4 bg-gradient-to-r from-sky-50 to-blue-50 rounded-xl border border-sky-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-graduation-cap text-sky-600"></i>
                                    <span class="text-sm font-medium">عدد الكورسات:</span>
                                </div>
                                <span class="font-black text-lg text-sky-700">{{ $package->courses_count ?? 0 }} كورس</span>
                            </div>
                        </div>
                        
                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-5 border-t-2 border-gray-100">
                            <div>
                                @if($package->original_price && $package->original_price > $package->price)
                                <div class="flex items-baseline gap-2 mb-1">
                                    <span class="text-lg text-gray-400 line-through">{{ number_format($package->original_price, 0) }}</span>
                                    <span class="text-3xl font-black text-sky-600">{{ number_format($package->price, 0) }}</span>
                                    <span class="text-lg text-gray-500">ج.م</span>
                                </div>
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                    <i class="fas fa-tag"></i>
                                    وفر {{ number_format($package->original_price - $package->price, 0) }} ج.م
                                </span>
                                @else
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-black text-sky-600">{{ number_format($package->price, 0) }}</span>
                                    <span class="text-lg text-gray-500">ج.م</span>
                                </div>
                                @endif
                            </div>
                            <a href="{{ route('public.package.show', $package->slug) }}" class="w-full sm:w-auto bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-lg shadow-sky-500/30 hover:shadow-xl hover:shadow-sky-500/40 hover:-translate-y-1 text-center">
                                <i class="fas fa-shopping-cart ml-2"></i>
                                اشتر الآن
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Courses Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600">الكورسات الفردية</span>
                </h2>
                <p class="text-xl text-gray-600">استكشف مجموعة متنوعة من الكورسات البرمجية</p>
            </div>
            
            <!-- Courses Grid -->
            @if(isset($courses) && is_array($courses) && count($courses) > 0)
            <!-- Display courses directly from PHP as fallback -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">
                @foreach($courses as $index => $course)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden course-card-hover border border-gray-100 hover:border-sky-300 transition-all duration-300 group">
                    <!-- Course Header -->
                    <div class="h-52 sm:h-56 bg-gradient-to-br flex items-center justify-center relative overflow-hidden course-header
                        @if($index % 6 == 0) from-sky-400 via-sky-500 to-sky-600
                        @elseif($index % 6 == 1) from-blue-500 via-blue-600 to-blue-700
                        @elseif($index % 6 == 2) from-indigo-500 via-indigo-600 to-indigo-700
                        @elseif($index % 6 == 3) from-purple-500 via-purple-600 to-purple-700
                        @elseif($index % 6 == 4) from-pink-500 via-pink-600 to-pink-700
                        @else from-red-500 via-red-600 to-red-700
                        @endif">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors duration-300"></div>
                        <i class="fas fa-code text-white text-7xl sm:text-8xl pulse-animation relative z-10 group-hover:scale-110 transition-transform duration-300"></i>
                        
                        @if(isset($course['is_featured']) && $course['is_featured'])
                            <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-yellow-900 px-4 py-1.5 rounded-full text-xs font-bold shadow-lg bounce-animation z-20">
                                <i class="fas fa-star ml-1"></i>
                                مميز
                            </div>
                        @endif
                        @if(isset($course['level']))
                            <div class="absolute top-4 right-4 bg-white/25 backdrop-blur-md rounded-full px-4 py-1.5 border border-white/30 shadow-lg z-20">
                                <span class="text-white text-xs font-semibold">
                                    @if($course['level'] == 'beginner') 
                                        <i class="fas fa-seedling ml-1"></i> مبتدئ
                                    @elseif($course['level'] == 'intermediate') 
                                        <i class="fas fa-chart-line ml-1"></i> متوسط
                                    @else 
                                        <i class="fas fa-rocket ml-1"></i> متقدم
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Course Content -->
                    <div class="p-6 sm:p-7">
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-3 line-clamp-2 group-hover:text-sky-600 transition-colors">
                            {{ $course['title'] ?? 'بدون عنوان' }}
                        </h3>
                        <p class="text-gray-600 mb-5 text-sm sm:text-base line-clamp-2 leading-relaxed">
                            {{ Str::limit($course['description'] ?? 'كورس برمجي شامل ومتخصص', 100) }}
                        </p>
                        
                        <!-- Course Info -->
                        <div class="flex flex-wrap items-center gap-3 mb-5 text-xs sm:text-sm">
                            @if(isset($course['duration_hours']) && $course['duration_hours'] > 0)
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg text-gray-700">
                                <i class="fas fa-clock text-sky-500"></i>
                                <span class="font-medium">{{ $course['duration_hours'] }} ساعة</span>
                            </div>
                            @endif
                            @if(isset($course['lessons_count']) && $course['lessons_count'] > 0)
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg text-gray-700">
                                <i class="fas fa-play-circle text-blue-500"></i>
                                <span class="font-medium">{{ $course['lessons_count'] }} درس</span>
                            </div>
                            @endif
                            @if(isset($course['programming_language']))
                            <div class="flex items-center gap-2 px-3 py-1.5 bg-sky-50 rounded-lg text-sky-700">
                                <i class="fas fa-code text-sky-600"></i>
                                <span class="font-semibold">{{ $course['programming_language'] }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Subject Info -->
                        @if(isset($course['academic_subject']['name']))
                            <div class="mb-5">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-sky-50 to-blue-50 text-sky-700 rounded-xl text-xs font-bold border border-sky-100">
                                    <i class="fas fa-book text-sky-600"></i>
                                    <span>{{ $course['academic_subject']['name'] }}</span>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Price and CTA -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-5 border-t-2 border-gray-100">
                            <div>
                                @if(isset($course['price']) && $course['price'] > 0)
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-black text-sky-600">{{ number_format($course['price'], 0) }}</span>
                                        <span class="text-lg text-gray-500">ج.م</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-gift text-green-500 text-xl"></i>
                                        <span class="text-2xl font-black text-green-600">مجاني</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('public.course.show', $course['id']) }}" class="w-full sm:w-auto bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 shadow-lg shadow-sky-500/30 hover:shadow-xl hover:shadow-sky-500/40 hover:-translate-y-1 text-center">
                                <i class="fas fa-arrow-left ml-2"></i>
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Alpine.js Dynamic Filtering (يمكن استخدامه لاحقاً) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                 x-show="false"
                 style="display: none;">
                <template x-for="(course, index) in filteredCourses" :key="course.id">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden course-card-hover">
                        <!-- Course Header -->
                        <div class="h-48 bg-gradient-to-br flex items-center justify-center relative overflow-hidden course-header"
                             :class="{
                                 'from-sky-400 to-sky-600': index % 6 === 0,
                                 'from-blue-500 to-blue-700': index % 6 === 1,
                                 'from-indigo-500 to-indigo-700': index % 6 === 2,
                                 'from-purple-500 to-purple-700': index % 6 === 3,
                                 'from-pink-500 to-pink-700': index % 6 === 4,
                                 'from-red-500 to-red-700': index % 6 === 5
                             }">
                            <i class="fas fa-code text-white text-6xl pulse-animation"></i>
                            <template x-if="course.is_featured">
                                <div class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold bounce-animation">
                                    مميز
                                </div>
                            </template>
                            <template x-if="course.level">
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                                    <span class="text-white text-xs font-medium" 
                                          x-text="course.level === 'beginner' ? 'مبتدئ' : course.level === 'intermediate' ? 'متوسط' : 'متقدم'"></span>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Course Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="course.title"></h3>
                            <p class="text-gray-600 mb-4 text-sm" x-text="course.description ? (course.description.substring(0, 100) + '...') : 'كورس برمجي شامل ومتخصص'"></p>
                            
                            <!-- Course Info -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-500">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="course.duration_hours ? course.duration_hours + ' ساعة' : 'غير محدد'"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group"></i>
                                    <span x-text="(course.lessons_count || 0) + ' درس'"></span>
                                </div>
                            </div>
                            
                            <!-- Subject Info -->
                            <template x-if="course.academic_subject">
                                <div class="mb-4">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-semibold">
                                        <i class="fas fa-book"></i>
                                        <span x-text="course.academic_subject.name"></span>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Price and CTA -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div>
                                    <template x-if="course.price && course.price > 0">
                                        <span class="text-2xl font-black text-sky-600" x-text="course.price + ' ج.م'"></span>
                                    </template>
                                    <template x-if="!course.price || course.price == 0">
                                        <span class="text-2xl font-black text-green-600">مجاني</span>
                                    </template>
                                </div>
                                @auth
                                    <a :href="'{{ url('/') }}/courses/' + course.id" class="btn-primary text-sm px-6 py-2">
                                        <i class="fas fa-eye"></i>
                                        عرض التفاصيل
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="btn-primary text-sm px-6 py-2">
                                        <i class="fas fa-sign-in-alt"></i>
                                        سجل للوصول
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- No Courses Found -->
            <div x-show="!filteredCourses || filteredCourses.length === 0" class="text-center py-16" x-cloak>
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">لا توجد نتائج</h3>
                    <p class="text-gray-600 mb-6">جرب البحث بكلمات مختلفة أو تصفية مختلف</p>
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-code text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">قريباً...</h3>
                    <p class="text-gray-600 mb-6">نعمل على إضافة المزيد من الكورسات البرمجية لخدمتكم بشكل أفضل</p>
                    <a href="{{ route('register') }}" class="btn-primary">
                        <i class="fas fa-bell"></i>
                        اشترك للحصول على التحديثات
                    </a>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 hero-gradient">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                هل أنت مستعد لبدء رحلتك البرمجية؟
            </h2>
            <p class="text-xl text-gray-300 mb-10">
                انضم إلى آلاف الطلاب الذين حققوا التميز في البرمجة مع Tech Bridge
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg">
                    <i class="fas fa-user-plus"></i>
                    ابدأ مجاناً الآن
                </a>
                <a href="{{ route('login') }}" class="btn-outline text-lg text-white border-white hover:bg-white hover:text-gray-900">
                    <i class="fas fa-sign-in-alt"></i>
                    لدي حساب بالفعل
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-20 h-20 bg-transparent rounded-xl flex items-center justify-center p-1">
                            <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge Logo" class="w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-2xl\'></i>';">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Tech Bridge</h3>
                            <p class="text-gray-400 text-sm">أكاديمية البرمجة</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        منصة تعليمية متخصصة في البرمجة تهدف إلى تبسيط مفاهيم البرمجة وجعلها أكثر متعة وفهماً للطلاب في جميع المستويات من المبتدئين إلى المحترفين.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6">روابط سريعة</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ url('/') }}#about" class="text-gray-400 hover:text-white transition-colors">حولنا</a></li>
                        <li><a href="{{ route('public.courses') }}" class="text-gray-400 hover:text-white transition-colors">الكورسات</a></li>
                        <li><a href="{{ url('/') }}#features" class="text-gray-400 hover:text-white transition-colors">المميزات</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold mb-6">الدعم</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">مركز المساعدة</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">تواصل معنا</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2024 Tech Bridge - أكاديمية البرمجة. جميع الحقوق محفوظة.
                </p>
            </div>
        </div>
    </footer>

    <!-- Dynamic JavaScript - نفس من welcome.blade.php -->
    <script>
        // إضافة أرقام طائرة ديناميكية
        function createFloatingNumber() {
            const numbers = ['{}', '</>', '#', '()', '[]'];
            const container = document.querySelector('.floating-numbers');
            
            if (!container) return;
            
            const number = document.createElement('div');
            number.className = 'floating-number';
            number.textContent = numbers[Math.floor(Math.random() * numbers.length)];
            number.style.left = Math.random() * 100 + '%';
            number.style.animationDelay = Math.random() * 5 + 's';
            number.style.fontSize = (Math.random() * 1.5 + 1.5) + 'rem';
            number.style.color = `rgba(14, 165, 233, 0.3)`;
            
            container.appendChild(number);
            
            setTimeout(() => {
                if (number.parentNode) {
                    number.parentNode.removeChild(number);
                }
            }, 15000);
        }

        function createParticle() {
            const particlesContainer = document.querySelector('.particles');
            if (!particlesContainer) return;
            
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 2 + 's';
            particle.style.animationDuration = (Math.random() * 5 + 8) + 's';
            particle.style.background = 'rgba(255, 255, 255, 0.5)';
            
            particlesContainer.appendChild(particle);
            
            setTimeout(() => {
                if (particle.parentNode) {
                    particle.parentNode.removeChild(particle);
                }
            }, 10000);
        }

        setInterval(createFloatingNumber, 1500);
        setInterval(createParticle, 800);

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
    </div> <!-- End of Search and Filter Section -->
</body>
</html>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech Bridge - أكاديمية برمجة</title>

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

    <!-- Custom Styles -->
            <style>
        * {
            font-family: 'Cairo', system-ui, sans-serif;
            box-sizing: border-box;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

.no-scroll {
    overflow: hidden;
    height: 100vh;
}

        .hero-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 30%, #0369a1 50%, #475569 75%, #dc2626 95%, #991b1b 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            animation: patternMove 20s linear infinite;
        }

        @keyframes patternMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(60px) translateY(60px); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        /* Navbar Scrolled State - شفافية مع نص واضح */
        #mainNavbar.navbar-scrolled {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Text Shadow for readability when navbar is transparent */
        #mainNavbar.navbar-scrolled h1,
        #mainNavbar.navbar-scrolled p,
        #mainNavbar.navbar-scrolled a,
        #mainNavbar.navbar-scrolled .text-white {
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3),
                         0 1px 4px rgba(0, 0, 0, 0.2),
                         0 0 2px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced logo visibility when scrolled */
        #mainNavbar.navbar-scrolled .logo-animation {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2),
                        0 0 8px rgba(14, 165, 233, 0.3);
        }

        .glass-effect::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .glass-effect:hover::before {
            animation: shimmer 1.5s ease-in-out;
            opacity: 1;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s ease;
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .mobile-accordion {
            border-radius: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: rgba(248, 250, 252, 0.95);
            padding: 1rem 1.25rem;
        }

        .mobile-accordion button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 700;
            color: #0f172a;
        }

        .mobile-accordion-content {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px dashed rgba(148, 163, 184, 0.4);
        }

        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        .floating-shape:nth-child(1) { animation-delay: 0s; }
        .floating-shape:nth-child(2) { animation-delay: 2s; }
        .floating-shape:nth-child(3) { animation-delay: 4s; }
        .floating-shape:nth-child(4) { animation-delay: 6s; }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1); 
                opacity: 0.1;
            }
            25% { 
                transform: translateY(-30px) rotate(90deg) scale(1.1); 
                opacity: 0.2;
            }
            50% { 
                transform: translateY(-20px) rotate(180deg) scale(0.9); 
                opacity: 0.15;
            }
            75% { 
                transform: translateY(-40px) rotate(270deg) scale(1.05); 
                opacity: 0.25;
            }
        }

        /* Code Animation Background */
        .code-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .code-line {
            position: absolute;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: rgba(14, 165, 233, 0.15);
            white-space: nowrap;
            animation: codeFloat 20s linear infinite;
            opacity: 0;
        }

        .code-line:nth-child(1) { top: 10%; left: -100%; animation-delay: 0s; }
        .code-line:nth-child(2) { top: 20%; left: -100%; animation-delay: 2s; }
        .code-line:nth-child(3) { top: 30%; left: -100%; animation-delay: 4s; }
        .code-line:nth-child(4) { top: 40%; left: -100%; animation-delay: 6s; }
        .code-line:nth-child(5) { top: 50%; left: -100%; animation-delay: 8s; }
        .code-line:nth-child(6) { top: 60%; left: -100%; animation-delay: 10s; }
        .code-line:nth-child(7) { top: 70%; left: -100%; animation-delay: 12s; }
        .code-line:nth-child(8) { top: 80%; left: -100%; animation-delay: 14s; }

        @keyframes codeFloat {
            0% {
                left: -100%;
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                left: 100%;
                opacity: 0;
            }
        }

        .binary-rain {
            position: absolute;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            color: rgba(14, 165, 233, 0.2);
            animation: binaryFall 15s linear infinite;
        }

        @keyframes binaryFall {
            0% {
                transform: translateY(-100px);
                opacity: 0;
            }
            10% {
                opacity: 0.4;
            }
            90% {
                opacity: 0.4;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        .code-bracket {
            position: absolute;
            font-family: 'Courier New', monospace;
            font-size: 40px;
            color: rgba(14, 165, 233, 0.1);
            animation: bracketRotate 8s ease-in-out infinite;
        }

        @keyframes bracketRotate {
            0%, 100% {
                transform: rotate(0deg) scale(1);
                opacity: 0.1;
            }
            50% {
                transform: rotate(180deg) scale(1.2);
                opacity: 0.2;
            }
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
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0.5);
                opacity: 0;
            }
            10% {
                opacity: 1;
                transform: translateY(90vh) rotate(36deg) scale(0.7);
            }
            50% {
                opacity: 0.8;
                transform: translateY(50vh) rotate(180deg) scale(1);
            }
            90% {
                opacity: 0.3;
                transform: translateY(10vh) rotate(324deg) scale(0.8);
            }
            100% {
                transform: translateY(-10vh) rotate(360deg) scale(0.3);
                opacity: 0;
            }
        }

        .number-counter {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 40%, #0369a1 65%, #475569 85%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s ease;
            cursor: default;
        }

        .number-counter:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 5px 15px rgba(14, 165, 233, 0.7));
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

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.6);
        }

        .btn-primary:active {
            transform: translateY(-1px) scale(1.02);
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

        .btn-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 35%, #0369a1 60%, #475569 80%, #dc2626 100%);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .btn-outline:hover::before {
            left: 0;
        }

        .btn-outline:hover {
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.5);
        }

        .feature-icon-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .feature-icon-hover::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            border-radius: inherit;
            transform: translate(-50%, -50%) scale(0);
            transition: all 0.4s ease;
        }

        .feature-icon-hover:hover::before {
            transform: translate(-50%, -50%) scale(1.2);
        }

        .feature-icon-hover:hover {
            transform: rotateY(180deg) scale(1.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
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

        .course-card-hover .course-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .course-card-hover:hover .course-header::before {
            animation: courseShimmer 1s ease-in-out;
            opacity: 1;
        }

        @keyframes courseShimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .star-rating {
            transition: all 0.3s ease;
        }

        .star-rating:hover {
            transform: scale(1.1);
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

        /* Background particles */
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
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Interactive text effects */
        .text-glow:hover {
            text-shadow: 0 0 20px rgba(14, 165, 233, 0.8);
            transition: all 0.3s ease;
        }

        /* Logo animation */
        .logo-animation {
            transition: all 0.4s ease;
        }

        .logo-animation:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* إضافة padding للأقسام للتعامل مع navbar الثابت */
        section[id] {
            scroll-margin-top: 100px;
        }

        /* Loading animations */
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

        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* Dropdown Menu Styles */
        [x-cloak] {
            display: none !important;
        }

        .dropdown-menu {
            position: absolute !important;
            top: calc(100% + 0.75rem) !important;
            right: 0 !important;
            min-width: 300px;
            max-width: 350px;
            max-height: 75vh;
            overflow-y: auto;
            overflow-x: hidden;
            background: #ffffff !important;
            backdrop-filter: blur(30px);
            border: 1px solid rgba(14, 165, 233, 0.15);
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2),
                        0 15px 30px rgba(0, 0, 0, 0.15),
                        0 5px 15px rgba(0, 0, 0, 0.1),
                        0 0 0 1px rgba(255, 255, 255, 0.8);
            z-index: 10000 !important;
            transform-origin: top right;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }

        .dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }

        .dropdown-menu::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .dropdown-menu::-webkit-scrollbar-thumb {
            background: rgba(14, 165, 233, 0.3);
            border-radius: 10px;
        }

        .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 165, 233, 0.5);
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #1f2937;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            text-decoration: none;
            position: relative;
            margin: 0 0.5rem;
            border-radius: 0.75rem;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0.08) 100%);
            color: #0284c7;
            transform: translateX(-4px);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
        }

        .dropdown-menu a.bg-sky-50 {
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.1) 100%) !important;
            color: #0284c7 !important;
            font-weight: 700;
            border-right: 3px solid #0284c7;
        }

        .dropdown-menu a i {
            margin-left: 0.875rem;
            color: #0284c7;
            width: 20px;
            font-size: 1rem;
            transition: transform 0.25s ease;
        }

        .dropdown-menu a:hover i {
            transform: scale(1.15);
        }
            </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'arabic': ['Cairo', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    </head>

<body class="bg-gray-50 text-gray-900"
      x-data="{ mobileMenu: false }"
      :class="{ 'no-scroll': mobileMenu }">

    <!-- Navigation Header -->
    <nav id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-white/20 shadow-2xl transition-all duration-300" style="overflow: visible !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="overflow: visible !important; position: relative;">
            <div class="flex justify-between items-center h-24">
                <!-- Enhanced Logo -->
                <div class="flex items-center space-x-4 space-x-reverse">
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
                </div>

                <!-- Enhanced Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
                    <a href="{{ route('home') }}" class="relative text-white font-bold text-lg nav-link group">
                        <span class="relative z-10">الرئيسية</span>
                        <div class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                    </a>
                    <a href="{{ route('public.courses') }}" class="relative text-white/80 hover:text-white font-medium text-lg nav-link group transition-all duration-300">
                        <span class="relative z-10">الكورسات</span>
                        <div class="absolute inset-0 bg-white/5 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300"></div>
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
    <section id="home" class="hero-gradient min-h-screen flex items-center relative overflow-hidden pt-28 sm:pt-32" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.85) 25%, rgba(14, 165, 233, 0.7) 50%, rgba(14, 165, 233, 0.75) 75%, rgba(2, 132, 199, 0.8) 100%);">
        <!-- Code Animation Background -->
        <div class="code-background">
            <!-- Code Lines -->
            <div class="code-line">function learnProgramming() {</div>
            <div class="code-line">const skills = ['HTML', 'CSS', 'JavaScript', 'Python'];</div>
            <div class="code-line">return skills.map(skill => master(skill));</div>
            <div class="code-line">class Developer { constructor() { this.level = 'Expert'; } }</div>
            <div class="code-line">if (dedication && practice) { becomeProfessional(); }</div>
            <div class="code-line">const future = async () => await buildAmazingProjects();</div>
            <div class="code-line">export default { success: true, career: 'Amazing' };</div>
            <div class="code-line"># Tech Bridge - Start Your Journey Today</div>
            
            <!-- Binary Rain -->
            <div class="binary-rain" style="left: 5%; animation-delay: 0s;">10101010</div>
            <div class="binary-rain" style="left: 15%; animation-delay: 1s;">11001100</div>
            <div class="binary-rain" style="left: 25%; animation-delay: 2s;">11110000</div>
            <div class="binary-rain" style="left: 35%; animation-delay: 3s;">01010101</div>
            <div class="binary-rain" style="left: 45%; animation-delay: 4s;">00110011</div>
            <div class="binary-rain" style="left: 55%; animation-delay: 5s;">00001111</div>
            <div class="binary-rain" style="left: 65%; animation-delay: 6s;">11111111</div>
            <div class="binary-rain" style="left: 75%; animation-delay: 7s;">00000000</div>
            <div class="binary-rain" style="left: 85%; animation-delay: 8s;">10110110</div>
            <div class="binary-rain" style="left: 95%; animation-delay: 9s;">01001001</div>
            
            <!-- Rotating Brackets -->
            <div class="code-bracket" style="top: 15%; left: 10%; animation-delay: 0s;">{</div>
            <div class="code-bracket" style="top: 25%; left: 20%; animation-delay: 1s;">}</div>
            <div class="code-bracket" style="top: 35%; left: 30%; animation-delay: 2s;">[</div>
            <div class="code-bracket" style="top: 45%; left: 40%; animation-delay: 3s;">]</div>
            <div class="code-bracket" style="top: 55%; left: 50%; animation-delay: 4s;">&lt;</div>
            <div class="code-bracket" style="top: 65%; left: 60%; animation-delay: 5s;">&gt;</div>
            <div class="code-bracket" style="top: 75%; left: 70%; animation-delay: 6s;">(</div>
            <div class="code-bracket" style="top: 85%; left: 80%; animation-delay: 7s;">)</div>
            
            <!-- Code Symbols Floating -->
            <div class="binary-rain" style="left: 12%; font-size: 24px; animation-delay: 2.5s; animation-duration: 12s;">&lt;/&gt;</div>
            <div class="binary-rain" style="left: 22%; font-size: 24px; animation-delay: 3.5s; animation-duration: 12s;">{}</div>
            <div class="binary-rain" style="left: 32%; font-size: 24px; animation-delay: 4.5s; animation-duration: 12s;">[]</div>
            <div class="binary-rain" style="left: 42%; font-size: 24px; animation-delay: 5.5s; animation-duration: 12s;">()</div>
            <div class="binary-rain" style="left: 52%; font-size: 24px; animation-delay: 6.5s; animation-duration: 12s;">=&gt;</div>
            <div class="binary-rain" style="left: 62%; font-size: 24px; animation-delay: 7.5s; animation-duration: 12s;">var</div>
            <div class="binary-rain" style="left: 72%; font-size: 24px; animation-delay: 8.5s; animation-duration: 12s;">let</div>
            <div class="binary-rain" style="left: 82%; font-size: 24px; animation-delay: 9.5s; animation-duration: 12s;">const</div>
        </div>

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

        <!-- Floating Shapes -->
        <div class="floating-shape top-20 right-20 w-20 h-20">
            <svg viewBox="0 0 100 100" class="w-full h-full text-sky-400">
                <polygon points="50,10 90,80 10,80" fill="currentColor"/>
                                    </svg>
        </div>
        <div class="floating-shape top-40 left-10 w-16 h-16" style="animation-delay: 2s">
            <svg viewBox="0 0 100 100" class="w-full h-full text-sky-500">
                <circle cx="50" cy="50" r="40" fill="currentColor"/>
            </svg>
        </div>
        <div class="floating-shape bottom-20 right-40 w-12 h-12" style="animation-delay: 4s">
            <svg viewBox="0 0 100 100" class="w-full h-full text-sky-500">
                <rect x="25" y="25" width="50" height="50" fill="currentColor" transform="rotate(45 50 50)"/>
            </svg>
        </div>
        <div class="floating-shape top-60 left-1/3 w-14 h-14" style="animation-delay: 6s">
            <svg viewBox="0 0 100 100" class="w-full h-full text-sky-600">
                <path d="M50,10 L90,30 L90,70 L50,90 L10,70 L10,30 Z" fill="currentColor"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-white slide-in-left">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        <span class="text-white text-glow" style="text-shadow: 0 4px 16px rgba(0,0,0,0.8), 0 2px 8px rgba(0,0,0,0.6), 0 0 20px rgba(14, 165, 233, 0.5);">Tech Bridge</span>
                        <br>
                        <span class="text-3xl md:text-4xl lg:text-5xl text-white pulse-animation font-black" style="text-shadow: 0 4px 16px rgba(0,0,0,0.8), 0 2px 8px rgba(0,0,0,0.6), 0 0 12px rgba(14, 165, 233, 0.4);">أكاديمية برمجة</span>
                    </h1>
                    
                    <div class="mb-6">
                        <p class="text-2xl md:text-3xl font-bold text-white mb-4 bounce-animation" style="text-shadow: 0 4px 16px rgba(0,0,0,0.8), 0 2px 8px rgba(0,0,0,0.6), 0 0 10px rgba(14, 165, 233, 0.4);">
                            🚀 احترف البرمجة من الصفر إلى الاحتراف
                        </p>
                        <div class="w-20 h-1.5 bg-gradient-to-r from-sky-400 via-sky-500 to-sky-600 rounded-full pulse-animation shadow-lg shadow-sky-500/50"></div>
                    </div>

                    <p class="text-xl md:text-2xl text-white mb-10 leading-relaxed fade-in font-semibold" style="text-shadow: 0 3px 12px rgba(0,0,0,0.7), 0 1px 6px rgba(0,0,0,0.5), 0 0 8px rgba(14, 165, 233, 0.3);">
                        رحلتك لتصبح مبرمج محترف تبدأ من هنا! تعلم البرمجة من الصفر مع أفضل الخبراء في المجال، وأتقن لغات البرمجة الحديثة والأدوات المتطورة لبناء مستقبل مهني مشرق
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6 fade-in">
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold py-4 px-8 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 text-lg flex items-center justify-center gap-3 border-2 border-sky-400/50 hover:border-sky-300/70" style="text-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                            <i class="fas fa-rocket bounce-animation"></i>
                            ابدأ رحلتك الآن
                        </a>
                        <a href="#courses" class="bg-white/10 backdrop-blur-sm text-white border-2 border-sky-400/50 hover:border-sky-300/70 hover:bg-white/20 font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 text-lg flex items-center justify-center gap-3" style="text-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                            <i class="fas fa-play-circle pulse-animation"></i>
                            شاهد الكورسات
                        </a>
                    </div>
                </div>

                <!-- Learning Journey Preview -->
                <div class="relative">
                    <div class="bg-gradient-to-br from-slate-900/95 via-slate-800/95 to-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-sky-500/40 shadow-2xl relative overflow-hidden">
                        <!-- Header - Clear and Bold -->
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-sky-500/30">
                            <div>
                                <h3 class="text-2xl font-black text-white mb-1" style="text-shadow: 0 2px 8px rgba(0,0,0,0.5), 0 0 4px rgba(0,0,0,0.3);">مسار التعلم</h3>
                                <p class="text-sm text-sky-200 font-medium" style="text-shadow: 0 1px 4px rgba(0,0,0,0.4);">من المبتدئ إلى المحترف</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-xl border-2 border-sky-400/50">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                        </div>

                        <!-- Learning Path Steps - Clear and Readable -->
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <!-- Step 1: Beginner -->
                            <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-xl p-4 border-2 border-sky-500/50 hover:border-sky-400/70 hover:bg-gradient-to-br hover:from-sky-600/50 hover:to-sky-700/50 transition-all group text-center shadow-lg">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:scale-110 transition-transform border-2 border-white/20">
                                    <span class="text-white font-black text-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">1</span>
                                </div>
                                <h4 class="text-sm font-bold text-white mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.4);">المبتدئ</h4>
                                <p class="text-xs text-sky-100 font-medium leading-tight" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">أساسيات البرمجة</p>
                            </div>

                            <!-- Step 2: Intermediate -->
                            <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-xl p-4 border-2 border-sky-500/50 hover:border-sky-400/70 hover:bg-gradient-to-br hover:from-sky-600/50 hover:to-sky-700/50 transition-all group text-center shadow-lg">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:scale-110 transition-transform border-2 border-white/20">
                                    <span class="text-white font-black text-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">2</span>
                                </div>
                                <h4 class="text-sm font-bold text-white mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.4);">المتوسط</h4>
                                <p class="text-xs text-sky-100 font-medium leading-tight" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">بناء المشاريع</p>
                            </div>

                            <!-- Step 3: Advanced -->
                            <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-xl p-4 border-2 border-sky-500/50 hover:border-sky-400/70 hover:bg-gradient-to-br hover:from-sky-600/50 hover:to-sky-700/50 transition-all group text-center shadow-lg">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:scale-110 transition-transform border-2 border-white/20">
                                    <span class="text-white font-black text-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">3</span>
                                </div>
                                <h4 class="text-sm font-bold text-white mb-2" style="text-shadow: 0 2px 6px rgba(0,0,0,0.4);">المتقدم</h4>
                                <p class="text-xs text-sky-100 font-medium leading-tight" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">مشاريع احترافية</p>
                            </div>
                        </div>

                        <!-- Achievement Stats - Clear and Bold -->
                        <div class="bg-gradient-to-br from-sky-700/50 to-sky-800/50 rounded-xl p-5 border-2 border-sky-500/40 shadow-xl">
                            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-sky-500/30">
                                <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-sky-600 rounded-lg flex items-center justify-center shadow-lg border-2 border-white/20">
                                    <i class="fas fa-trophy text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-sky-200 font-medium" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">ما ستحققه</p>
                                    <p class="text-base font-bold text-white" style="text-shadow: 0 2px 6px rgba(0,0,0,0.4);">إنجازات رائعة</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3 text-center">
                                <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-lg p-3 border-2 border-sky-500/40 shadow-md">
                                    <p class="text-2xl font-black text-white mb-1" style="text-shadow: 0 2px 8px rgba(0,0,0,0.4);">50+</p>
                                    <p class="text-xs text-sky-100 font-medium" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">مشروع</p>
                                </div>
                                <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-lg p-3 border-2 border-sky-500/40 shadow-md">
                                    <p class="text-2xl font-black text-white mb-1" style="text-shadow: 0 2px 8px rgba(0,0,0,0.4);">100+</p>
                                    <p class="text-xs text-sky-100 font-medium" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">ساعة</p>
                                </div>
                                <div class="bg-gradient-to-br from-sky-600/40 to-sky-700/40 rounded-lg p-3 border-2 border-sky-500/40 shadow-md">
                                    <p class="text-2xl font-black text-white mb-1" style="text-shadow: 0 2px 8px rgba(0,0,0,0.4);">10+</p>
                                    <p class="text-xs text-sky-100 font-medium" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">شهادة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inspirational Quotes Section -->
    <section class="py-20 bg-gradient-to-r from-gray-100 via-sky-50/80 to-gray-100 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="math-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor"/>
                        <circle cx="18" cy="18" r="1" fill="currentColor"/>
                        <circle cx="10" cy="10" r="0.5" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#math-pattern)"/>
                                    </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-6 text-glow">
                    أقوال <span class="text-sky-600 pulse-animation">ملهمة</span>
                </h2>
                <p class="text-xl text-gray-700">رحلة التعلم تبدأ بخطوة واحدة، والبرمجة هي لغة المستقبل</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8" x-data="{ activeQuote: 0 }" x-init="setInterval(() => activeQuote = (activeQuote + 1) % 4, 5000)">
                <!-- Quote 1 -->
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-xl card-hover fade-in relative overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all"
                     :class="activeQuote === 0 ? 'ring-4 ring-sky-500 scale-105 border-sky-500 bg-white' : ''">
                    <div class="absolute top-4 right-6 text-6xl text-sky-100/50 font-serif">"</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-r from-sky-500 via-sky-600 to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-animation shadow-lg">
                            <i class="fas fa-code text-white text-2xl"></i>
                        </div>
                        <blockquote class="text-xl font-bold text-gray-800 mb-4 text-center leading-relaxed">
                            "البرمجة ليست مجرد كتابة أكواد، بل هي فن حل المشكلات وبناء المستقبل"
                        </blockquote>
                        <cite class="text-sky-600 font-semibold block text-center">- Tech Bridge</cite>
                    </div>
                </div>

                <!-- Quote 2 -->
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-xl card-hover fade-in relative overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all" style="animation-delay: 0.2s;"
                     :class="activeQuote === 1 ? 'ring-4 ring-sky-500 scale-105 border-sky-500 bg-white' : ''">
                    <div class="absolute top-4 right-6 text-6xl text-sky-100/50 font-serif">"</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-r from-sky-600 via-sky-700 to-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-6 bounce-animation shadow-lg">
                            <i class="fas fa-laptop-code text-white text-2xl"></i>
                        </div>
                        <blockquote class="text-xl font-bold text-gray-800 mb-4 text-center leading-relaxed">
                            "الكود الجيد ليس ما يعمل فقط، بل ما يمكن قراءته بسهولة وصيانته ببساطة أيضاً"
                        </blockquote>
                        <cite class="text-sky-600 font-semibold block text-center">- Tech Bridge</cite>
                    </div>
                </div>

                <!-- Quote 3 -->
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-xl card-hover fade-in relative overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all" style="animation-delay: 0.4s;"
                     :class="activeQuote === 2 ? 'ring-4 ring-sky-500 scale-105 border-sky-500 bg-white' : ''">
                    <div class="absolute top-4 right-6 text-6xl text-sky-100/50 font-serif">"</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-r from-sky-500 via-sky-600 to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-6 pulse-animation shadow-lg">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <blockquote class="text-xl font-bold text-gray-800 mb-4 text-center leading-relaxed">
                            "التعلم رحلة لا تنتهي، وكل خطأ في الكود هو درس يقربنا من الاحتراف"
                        </blockquote>
                        <cite class="text-sky-600 font-semibold block text-center">- Tech Bridge</cite>
                    </div>
                </div>

                <!-- Quote 4 -->
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-xl card-hover fade-in relative overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all" style="animation-delay: 0.6s;"
                     :class="activeQuote === 3 ? 'ring-4 ring-sky-500 scale-105 border-sky-500 bg-white' : ''">
                    <div class="absolute top-4 right-6 text-6xl text-sky-100/50 font-serif">"</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-r from-sky-600 via-sky-700 to-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-animation shadow-lg">
                            <i class="fas fa-rocket text-white text-2xl"></i>
                        </div>
                        <blockquote class="text-xl font-bold text-gray-800 mb-4 text-center leading-relaxed">
                            "الفهم الحقيقي يأتي من الممارسة والصبر والشغف بالبرمجة والتعلم المستمر"
                        </blockquote>
                        <cite class="text-sky-600 font-semibold block text-center">- Tech Bridge</cite>
                    </div>
                </div>
            </div>

            <!-- Interactive Progress Indicator -->
            <div class="flex justify-center mt-12 space-x-3 space-x-reverse">
                <template x-for="i in 4" :key="i">
                    <button @click="activeQuote = i - 1" 
                            class="w-4 h-4 rounded-full transition-all duration-300 hover:scale-125"
                            :class="activeQuote === i - 1 ? 'bg-sky-600 scale-125 shadow-lg' : 'bg-gray-300'">
                    </button>
                </template>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gradient-to-b from-gray-100 via-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="slide-in-left">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-6 text-glow">
                        رحلتك مع <span class="text-sky-600 pulse-animation">Tech Bridge</span>
                    </h2>
                    <p class="text-xl text-gray-700 mb-8 leading-relaxed fade-in">
                        أكاديمية متخصصة في تعليم البرمجة فقط، تجمع بين أفضل الأساليب التعليمية والتقنيات الحديثة لضمان وصولك إلى مستوى احترافي حقيقي في مجال البرمجة والتطوير.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 card-hover p-4 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg border border-gray-200/50 hover:bg-white hover:shadow-xl transition-all">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center flex-shrink-0 feature-icon-hover shadow-lg">
                                <i class="fas fa-user-graduate text-white text-xl pulse-animation"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 text-glow">تعليم شخصي ومتابعة فردية</h3>
                                <p class="text-gray-600">كل طالب له أسلوب تعلم مختلف، ولذلك نقدم متابعة شخصية لضمان فهم كل طالب للمادة البرمجية بطريقته الخاصة</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 card-hover p-4 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg border border-gray-200/50 hover:bg-white hover:shadow-xl transition-all">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center flex-shrink-0 feature-icon-hover shadow-lg">
                                <i class="fas fa-brain text-white text-xl bounce-animation"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 text-glow">فهم عميق وليس حفظ</h3>
                                <p class="text-gray-600">نركز على فهم المفاهيم البرمجية الأساسية والتفكير المنطقي، لا على الحفظ الأعمى، لتصبح البرمجة سهلة وممتعة</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 card-hover p-4 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg border border-gray-200/50 hover:bg-white hover:shadow-xl transition-all">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center flex-shrink-0 feature-icon-hover shadow-lg">
                                <i class="fas fa-heart text-white text-xl rotate-animation"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 text-glow">بيئة تعليمية محفزة</h3>
                                <p class="text-gray-600">نؤمن أن التعلم يجب أن يكون ممتعاً ومحفزاً، لذا نخلق بيئة إيجابية تشجع على طرح الأسئلة والاستكشاف البرمجي</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 card-hover p-4 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg border border-gray-200/50 hover:bg-white hover:shadow-xl transition-all">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center flex-shrink-0 feature-icon-hover shadow-lg">
                                <i class="fas fa-trophy text-white text-xl pulse-animation"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 text-glow">نتائج مثبتة ونجاح مستمر</h3>
                                <p class="text-gray-600">سجل حافل من النجاحات مع طلابنا، حيث تحسن مستواهم البرمجي بشكل ملحوظ وأصبحوا مبرمجين محترفين</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                        <div class="relative slide-in-right">
                    <div class="bg-gradient-to-br from-white/95 to-sky-50/90 backdrop-blur-sm rounded-3xl p-8 shadow-2xl card-hover border border-gray-200/50 hover:shadow-3xl transition-all">
                        <!-- الصورة والمعلومات الأساسية -->
                        <div class="text-center mb-8">
                            <div class="relative mx-auto mb-6">
                                <div class="w-24 h-24 bg-gradient-to-br from-sky-500 via-sky-600 via-sky-700 to-slate-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl feature-icon-hover">
                                    <i class="fas fa-code text-white text-3xl"></i>
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-sky-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-star text-white text-sm pulse-animation"></i>
                                </div>
                            </div>
                            <h3 class="text-3xl font-black text-gray-800 mb-2 text-glow">Tech Bridge</h3>
                            <p class="text-sky-600 font-bold text-lg mb-2">أكاديمية برمجة</p>
                            <p class="text-gray-600 text-sm">تعليم البرمجة من الصفر إلى الاحتراف</p>
                        </div>
                        
                        <!-- الإحصائيات والإنجازات -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-r from-sky-100 to-sky-200 rounded-2xl p-4 text-center card-hover shadow-md border border-sky-300">
                                    <div class="text-3xl font-black text-sky-600 number-counter pulse-animation">5+</div>
                                    <div class="text-sm text-gray-800 font-semibold">سنة خبرة</div>
                                </div>
                                <div class="bg-gradient-to-r from-sky-100 to-sky-200 rounded-2xl p-4 text-center card-hover shadow-md border border-sky-300">
                                    <div class="text-3xl font-black text-sky-700 number-counter bounce-animation">2500+</div>
                                    <div class="text-sm text-gray-800 font-semibold">طالب نشط</div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-r from-slate-100 to-slate-200 rounded-2xl p-4 text-center card-hover shadow-md border border-slate-300">
                                    <div class="text-3xl font-black text-slate-700 number-counter rotate-animation">95%</div>
                                    <div class="text-sm text-gray-800 font-semibold">نسبة النجاح</div>
                                </div>
                                <div class="bg-gradient-to-r from-sky-100 to-sky-200 rounded-2xl p-4 text-center card-hover shadow-md border border-sky-300">
                                    <div class="text-3xl font-black text-sky-600 number-counter pulse-animation">50+</div>
                                    <div class="text-sm text-gray-800 font-semibold">كورس متخصص</div>
                                </div>
                            </div>
                            
                            <!-- شهادات ومؤهلات -->
                            <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl p-4 border border-gray-300 shadow-md">
                                <h4 class="font-bold text-gray-900 mb-3 text-center">🏆 مميزاتنا</h4>
                                <div class="space-y-2 text-sm text-gray-700 text-center font-medium">
                                    <p><i class="fas fa-code text-sky-600 ml-2"></i>تعلم البرمجة من الصفر</p>
                                    <p><i class="fas fa-certificate text-sky-500 ml-2"></i>شهادات معتمدة في البرمجة</p>
                                    <p><i class="fas fa-trophy text-sky-600 ml-2"></i>مشاريع عملية حقيقية</p>
                                </div>
                            </div>
                            
                            <!-- رسالة شخصية -->
                            <div class="bg-gradient-to-r from-sky-500 via-sky-600 via-sky-700 to-slate-600 rounded-2xl p-6 text-white text-center relative overflow-hidden shadow-xl">
                                <div class="absolute top-2 right-4 text-4xl opacity-20">"</div>
                                <p class="text-sm leading-relaxed font-medium relative z-10">
                                    "رسالتنا هي تحويل البرمجة من مجال معقد إلى رحلة ممتعة من التعلم والإبداع. نؤمن أن كل طالب قادر على أن يصبح مبرمج محترف بالطريقة الصحيحة والدعم المناسب."
                                </p>
                                <p class="text-xs mt-3 opacity-90">- Tech Bridge</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    مميزات <span class="text-sky-600">منصتنا</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    نوفر مجموعة شاملة من الأدوات والميزات المتطورة لضمان تجربة تعليمية استثنائية في البرمجة
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-100">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-500 to-sky-700 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-play-circle text-white text-2xl pulse-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">فيديوهات تفاعلية</h3>
                    <p class="text-gray-700 font-medium">شروحات برمجية مرئية عالية الجودة مع إمكانية التفاعل والتحكم في سرعة التشغيل</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-100" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-600 to-sky-800 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-clipboard-list text-white text-2xl bounce-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">اختبارات ذكية</h3>
                    <p class="text-gray-700 font-medium">نظام تقييم برمجي متطور مع تصحيح فوري وتحليل دقيق لنقاط القوة والضعف</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-200" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-500 to-sky-700 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl rotate-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">تتبع التقدم</h3>
                    <p class="text-gray-700 font-medium">مراقبة مستمرة لأداء الطالب البرمجي مع تقارير مفصلة وتوصيات للتحسين</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-100" style="animation-delay: 0.6s;">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-500 to-sky-700 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-mobile-alt text-white text-2xl pulse-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">متوافق مع الجوال</h3>
                    <p class="text-gray-700 font-medium">تصميم متجاوب يعمل بسلاسة على جميع الأجهزة والشاشات</p>
                </div>

                <!-- Feature 5 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-100" style="animation-delay: 0.8s;">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-600 to-sky-800 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-comments text-white text-2xl bounce-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">دعم مباشر</h3>
                    <p class="text-gray-700 font-medium">تواصل فوري مع المعلم والحصول على إجابات سريعة لجميع الاستفسارات البرمجية</p>
                </div>

                <!-- Feature 6 -->
                <div class="text-center card-hover bg-white p-8 rounded-2xl shadow-xl fade-in border-2 border-sky-200" style="animation-delay: 1s;">
                    <div class="w-20 h-20 bg-gradient-to-r from-sky-500 to-sky-700 rounded-2xl flex items-center justify-center mx-auto mb-6 feature-icon-hover shadow-lg">
                        <i class="fas fa-certificate text-white text-2xl rotate-animation"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 text-glow">شهادات معتمدة</h3>
                    <p class="text-gray-700 font-medium">احصل على شهادات إتمام معتمدة في البرمجة عند إنهاء الكورسات بنجاح</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Years Section -->
    <section id="courses" class="py-20 bg-gradient-to-b from-gray-100 via-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-6 text-glow">
                    الكورسات <span class="text-sky-600 pulse-animation">البرمجية</span>
                </h2>
                <p class="text-xl text-gray-700 fade-in font-medium">اختر الكورس المناسب وابدأ رحلتك التعليمية في البرمجة</p>
                <div class="mt-6 inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-100/90 to-sky-200/90 backdrop-blur-sm rounded-full border-2 border-sky-300/70 shadow-md">
                    <i class="fas fa-code text-sky-600 ml-3"></i>
                    <span class="text-sky-800 font-semibold">منهج شامل ومتدرج لجميع مستويات البرمجة</span>
                </div>
            </div>

            @if($academicYears->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($academicYears as $index => $year)
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden course-card-hover border border-gray-200/50 hover:shadow-xl hover:bg-white transition-all">
                        <div class="h-48 bg-gradient-to-br 
                            @if($index % 6 == 0) from-sky-400 to-sky-600
                            @elseif($index % 6 == 1) from-sky-500 to-sky-700
                            @elseif($index % 6 == 2) from-sky-600 to-sky-800
                            @elseif($index % 6 == 3) from-sky-400 to-sky-600
                            @elseif($index % 6 == 4) from-sky-500 to-sky-700
                            @else from-sky-600 to-sky-800
                            @endif
                            flex items-center justify-center relative overflow-hidden course-header">
                            <i class="fas fa-
                                @if($index % 6 == 0) calculator
                                @elseif($index % 6 == 1) square-root-alt
                                @elseif($index % 6 == 2) infinity
                                @elseif($index % 6 == 3) chart-line
                                @elseif($index % 6 == 4) functions
                                @else pi
                                @endif
                                text-white text-6xl pulse-animation"></i>
                            @if($year->advanced_courses_count > 0)
                                <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 bounce-animation">
                                    <span class="text-white text-sm font-medium">{{ $year->advanced_courses_count }} كورس</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $year->name }}</h3>
                            <p class="text-gray-700 mb-4">
                                @if($year->description)
                                    {{ Str::limit($year->description, 80) }}
                                @else
                                    استكشف المواد والكورسات المتاحة لهذه السنة الدراسية
                                @endif
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-graduation-cap text-gray-400"></i>
                                    <span class="text-sm text-gray-600">{{ $year->advanced_courses_count }} كورس</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-gray-400"></i>
                                    <span class="text-sm text-gray-600">متعدد المستويات</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($year->is_active) bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                                        @if($year->is_active) متاح الآن @else قريباً @endif
                                    </span>
                                </div>
                                <a href="{{ route('public.courses') }}" class="btn-primary text-sm px-4 py-2">
                                    استكشف المسار
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
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

            <div class="text-center mt-12">
                <a href="{{ route('public.courses') }}" class="btn-primary text-lg">
                    <i class="fas fa-code"></i>
                    استكشف الكورسات
                </a>
            </div>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Logo & Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-20 h-20 bg-transparent rounded-xl flex items-center justify-center p-1">
                            <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge Logo" class="w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-2xl\'></i>';">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Tech Bridge</h3>
                            <p class="text-gray-400 text-sm">أكاديمية برمجة</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        منصة تعليمية متخصصة في البرمجة تهدف إلى تبسيط مفاهيم البرمجة وجعلها أكثر متعة وفهماً للطلاب في جميع المستويات من المبتدئين إلى المحترفين.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="https://www.facebook.com/share/184vKCiPnU/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors text-xl" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@tech.bridge.programming?_r=1&_t=ZS-93kQyEQSCBu" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors text-xl" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- معلومات -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-info-circle text-sky-400 ml-2"></i>
                        معلومات
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.about') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-graduation-cap ml-2 text-xs"></i>من نحن</a></li>
                        <li><a href="{{ route('public.team') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-users ml-2 text-xs"></i>الفريق</a></li>
                        <li><a href="{{ route('public.testimonials') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-star ml-2 text-xs"></i>آراء العملاء</a></li>
                        <li><a href="{{ route('public.partners') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-handshake ml-2 text-xs"></i>الشركاء</a></li>
                    </ul>
                </div>

                <!-- المحتوى والدعم -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-book-open text-sky-400 ml-2"></i>
                        المحتوى والدعم
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('public.courses') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-code ml-2 text-xs"></i>الكورسات</a></li>
                        <li><a href="{{ route('public.blog.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-newspaper ml-2 text-xs"></i>المدونة</a></li>
                        <li><a href="{{ route('public.events') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-calendar-alt ml-2 text-xs"></i>الفعاليات</a></li>
                        <li><a href="{{ route('public.media.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-images ml-2 text-xs"></i>معرض الصور</a></li>
                        <li><a href="{{ route('public.certificates') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-certificate ml-2 text-xs"></i>الشهادات</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-envelope ml-2 text-xs"></i>تواصل معنا</a></li>
                        <li><a href="{{ route('public.faq') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-question-circle ml-2 text-xs"></i>الأسئلة الشائعة</a></li>
                        <li><a href="{{ route('public.help') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-life-ring ml-2 text-xs"></i>مركز المساعدة</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-gray-400 hover:text-white transition-colors flex items-center"><i class="fas fa-envelope ml-2 text-xs"></i>تواصل معنا</a></li>
                    </ul>
                </div>

                <!-- معلومات التواصل -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt text-sky-400 ml-2"></i>
                        تواصل معنا
                    </h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt ml-3 text-sky-500 mt-1"></i>
                            <span>123 شارع الأكاديمية<br>مدينة المعرفة</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone ml-3 text-sky-500"></i>
                            <span>+20 100 123 4567</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope ml-3 text-sky-500"></i>
                            <span>info@techbridge.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="text-center mb-4">
                    <p class="text-gray-400 text-sm">
                        &copy; 2024 Tech Bridge - أكاديمية برمجة. جميع الحقوق محفوظة.
                    </p>
                </div>
                <div class="flex justify-center flex-wrap gap-4 text-sm">
                    <a href="{{ route('public.terms') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-file-contract ml-1 text-xs"></i>
                        الشروط والأحكام
                    </a>
                    <a href="{{ route('public.privacy') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-shield-alt ml-1 text-xs"></i>
                        سياسة الخصوصية
                    </a>
                    <a href="{{ route('public.refund') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                        <i class="fas fa-undo ml-1 text-xs"></i>
                        سياسة الاسترجاع
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Dynamic JavaScript -->
    <script>
        // إضافة أرقام طائرة ديناميكية
        function createFloatingNumber() {
            const numbers = ['π', '∞', '√', '∑', '∫', 'θ', 'Δ', 'α', 'β', 'γ', 'δ', 'ε', 'λ', 'μ', 'σ', 'φ', 'ψ', 'ω', '∴', '∵', '≈', '≡', '≠', '≤', '≥', '±', '∓', '×', '÷'];
            const container = document.querySelector('.floating-numbers');
            
            if (!container) return;
            
            const number = document.createElement('div');
            number.className = 'floating-number';
            number.textContent = numbers[Math.floor(Math.random() * numbers.length)];
            number.style.left = Math.random() * 100 + '%';
            number.style.animationDelay = Math.random() * 5 + 's';
            number.style.fontSize = (Math.random() * 1.5 + 1.5) + 'rem';
            number.style.color = `rgba(${Math.floor(Math.random() * 100) + 100}, ${Math.floor(Math.random() * 100) + 126}, ${Math.floor(Math.random() * 100) + 234}, 0.1)`;
            
            container.appendChild(number);
            
            // إزالة العنصر بعد انتهاء الأنيميشن
            setTimeout(() => {
                if (number.parentNode) {
                    number.parentNode.removeChild(number);
                }
            }, 15000);
        }

        // إضافة جسيمات ديناميكية
        function createParticle() {
            const particlesContainer = document.querySelector('.particles');
            if (!particlesContainer) return;
            
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 2 + 's';
            particle.style.animationDuration = (Math.random() * 5 + 8) + 's';
            
            const colors = ['rgba(255, 255, 255, 0.5)', 'rgba(102, 126, 234, 0.3)', 'rgba(118, 75, 162, 0.3)', 'rgba(240, 147, 251, 0.3)'];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            particlesContainer.appendChild(particle);
            
            setTimeout(() => {
                if (particle.parentNode) {
                    particle.parentNode.removeChild(particle);
                }
            }, 10000);
        }

        // تشغيل الوظائف على فترات
        setInterval(createFloatingNumber, 1500);
        setInterval(createParticle, 800);
        
        // تأثيرات hover متقدمة للبطاقات
        document.addEventListener('DOMContentLoaded', function() {
            // تأثيرات البطاقات ثلاثية الأبعاد
            const cards = document.querySelectorAll('.card-hover, .course-card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-15px) scale(1.02) rotateX(5deg)';
                    this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1) rotateX(0deg)';
                    this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
                });

                // تأثير الماوس ثلاثي الأبعاد
                card.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 10;
                    const rotateY = (centerX - x) / 10;
                    
                    this.style.transform = `translateY(-15px) scale(1.02) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });
            });

            // تأثيرات العداد المتحرك
            const counters = document.querySelectorAll('.number-counter');
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.textContent);
                    const increment = target / 100;
                    let current = 0;
                    
                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            counter.textContent = Math.floor(current) + (counter.textContent.includes('%') ? '%' : '');
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target + (counter.textContent.includes('%') ? '%' : '');
                        }
                    };
                    
                    // تشغيل العداد عند ظهور العنصر في الشاشة
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                updateCounter();
                                observer.unobserve(entry.target);
                            }
                        });
                    });
                    
                    observer.observe(counter);
                });
            };

            // تشغيل الأنيميشن عند التحميل
            setTimeout(animateCounters, 500);

            // تأثيرات النجوم المتحركة
            const stars = document.querySelectorAll('.star-rating i');
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    for (let i = 0; i <= index; i++) {
                        stars[i].style.transform = 'scale(1.2)';
                        stars[i].style.color = '#fbbf24';
                    }
                });
                
                star.addEventListener('mouseleave', function() {
                    stars.forEach(s => {
                        s.style.transform = 'scale(1)';
                        s.style.color = '#facc15';
                    });
                });
            });

            // تأثير التمرير السلس للروابط
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // تأثير ظهور العناصر عند التمرير
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // تأثير الناف بار عند السكرول - شفافية مع نص واضح
            const navbar = document.getElementById('mainNavbar');
            let lastScroll = 0;

            const updateNavbarState = () => {
                const currentScroll = window.pageYOffset || document.documentElement.scrollTop || 0;
                
                if (currentScroll > 100) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
                
                lastScroll = currentScroll;
            };

            window.addEventListener('scroll', updateNavbarState);
            window.addEventListener('load', updateNavbarState);
            updateNavbarState();

            // مراقبة العناصر للأنيميشن
            document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                fadeInObserver.observe(el);
            });

            // تأثير المؤشر المخصص
            document.addEventListener('mousemove', function(e) {
                // إضافة تأثير بريق يتبع المؤشر (اختياري)
                const glitter = document.createElement('div');
                glitter.style.position = 'fixed';
                glitter.style.left = e.clientX + 'px';
                glitter.style.top = e.clientY + 'px';
                glitter.style.width = '4px';
                glitter.style.height = '4px';
                glitter.style.background = 'rgba(102, 126, 234, 0.6)';
                glitter.style.borderRadius = '50%';
                glitter.style.pointerEvents = 'none';
                glitter.style.zIndex = '1000';
                glitter.style.animation = 'fadeOut 1s ease-out forwards';
                
                document.body.appendChild(glitter);
                
                setTimeout(() => {
                    if (glitter.parentNode) {
                        glitter.parentNode.removeChild(glitter);
                    }
                }, 1000);
            });
        });

        // إضافة keyframes للتأثيرات الجديدة
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeOut {
                0% { opacity: 1; transform: scale(1); }
                100% { opacity: 0; transform: scale(0); }
            }
            
            .star-rating i {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .parallax-bg {
                transform: translateZ(0);
                will-change: transform;
            }
            
            /* تأثيرات إضافية للأنيميشن */
            .enhanced-glow:hover {
                text-shadow: 0 0 30px rgba(102, 126, 234, 0.8);
                transform: scale(1.05);
                transition: all 0.3s ease;
            }
            
            .floating-icon {
                animation: floatingIcon 4s ease-in-out infinite;
            }
            
            @keyframes floatingIcon {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(5deg); }
            }
            
            .gradient-border {
                position: relative;
                background: linear-gradient(45deg, #667eea, #764ba2, #f093fb);
                background-size: 200% 200%;
                animation: gradientShift 3s ease infinite;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .typewriter {
                overflow: hidden;
                border-right: 2px solid #667eea;
                white-space: nowrap;
                animation: typewriter 4s steps(30) 1s 1 normal both, blinkCursor 1s steps(2) infinite;
            }
            
            @keyframes typewriter {
                from { width: 0; }
                to { width: 100%; }
            }
            
            @keyframes blinkCursor {
                from { border-right-color: #667eea; }
                to { border-right-color: transparent; }
            }
        `;
        document.head.appendChild(style);
    </script>

    </body>
</html>

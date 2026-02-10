<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $course->title ?? 'تفاصيل الكورس' }} - Tech Bridge - أكاديمية البرمجة</title>

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

        <!-- Custom Styles - استخدام نفس الستايلات العامة -->
        @include('layouts.public-styles')
        <style>
            * { font-family: 'Cairo', system-ui, sans-serif; }
            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
            }
            .card-hover {
                transition: all 0.3s ease;
                position: relative;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                z-index: 5;
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
            .slide-in-right {
                animation: slideInRight 0.8s ease-out;
            }
            @keyframes slideInRight {
                0% { opacity: 0; transform: translateX(50px); }
                100% { opacity: 1; transform: translateX(0); }
            }
            .feature-icon-hover {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                position: relative;
            }
            .feature-icon-hover:hover {
                transform: rotateY(180deg) scale(1.1);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            }
            .floating-numbers {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 0;
            }
            
            /* Fix for sticky sidebar */
            .sticky-sidebar {
                position: sticky;
                top: 100px;
                align-self: flex-start;
                z-index: 10;
                max-height: calc(100vh - 120px);
                overflow-y: auto;
            }
            
            /* Smooth scrollbar for sidebar */
            .sticky-sidebar::-webkit-scrollbar {
                width: 6px;
            }
            
            .sticky-sidebar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            
            .sticky-sidebar::-webkit-scrollbar-thumb {
                background: #0ea5e9;
                border-radius: 10px;
            }
            
            .sticky-sidebar::-webkit-scrollbar-thumb:hover {
                background: #0284c7;
            }
            
            /* Smooth scroll */
            html {
                scroll-behavior: smooth;
            }
            
            /* Prevent card overlap */
            .course-card {
                position: relative;
                z-index: 1;
                margin-bottom: 2rem;
                isolation: isolate;
            }
            
            .course-card:last-child {
                margin-bottom: 0;
            }
            
            /* Improve card hover without overlap */
            .card-hover {
                transition: all 0.3s ease;
                position: relative;
            }
            
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                z-index: 5;
            }
            
            /* Fix for sections spacing */
            section {
                position: relative;
                z-index: 1;
                isolation: isolate;
            }
            
            /* Ensure proper stacking context */
            body {
                position: relative;
                z-index: 0;
            }
            
            /* Navbar z-index fix */
            nav {
                position: relative;
                z-index: 50;
            }
            
            /* Hero section z-index */
            .hero-gradient {
                position: relative;
                z-index: 2;
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
        </style>
    </head>

<body class="bg-gray-50 text-gray-900"
      x-data="{ mobileMenu: false }"
      :class="{ 'overflow-hidden': mobileMenu }">

    @include('components.public-navbar')

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
    <section class="hero-gradient min-h-[70vh] flex items-center relative overflow-hidden pt-28 sm:pt-32 pb-16">
        <!-- Background Particles -->
        <div class="particles">
            <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
            <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
            <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
            <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
            <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
            <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-white/80 text-sm">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">الرئيسية</a>
                <span class="mx-2">/</span>
                <a href="{{ route('public.courses') }}" class="hover:text-white transition-colors">الكورسات</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $course->title ?? 'الكورس' }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Course Info -->
                <div class="text-white slide-in-left">
                    @if($course->is_featured ?? false)
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400/20 backdrop-blur-sm rounded-full border border-yellow-400/30 mb-4">
                            <i class="fas fa-star text-yellow-400 pulse-animation"></i>
                            <span class="text-yellow-300 font-bold text-sm">كورس مميز</span>
                        </div>
                    @endif
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-500 via-sky-600 to-slate-400 text-glow">{{ $course->title ?? 'اسم الكورس' }}</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed fade-in">
                        {{ $course->description ?? 'كورس برمجي شامل ومتخصص' }}
                    </p>

                    <!-- Course Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="glass-effect rounded-xl p-4 text-center border border-white/20">
                            <div class="text-2xl font-black text-sky-300 mb-1">{{ $course->lessons_count ?? 0 }}</div>
                            <div class="text-xs text-white/80">درس</div>
                        </div>
                        <div class="glass-effect rounded-xl p-4 text-center border border-white/20">
                            <div class="text-2xl font-black text-sky-400 mb-1">{{ $course->duration_hours ?? 0 }}</div>
                            <div class="text-xs text-white/80">ساعة</div>
                        </div>
                        <div class="glass-effect rounded-xl p-4 text-center border border-white/20">
                            <div class="text-2xl font-black text-slate-400 mb-1">
                                @if($course->level == 'beginner') مبتدئ
                                @elseif($course->level == 'intermediate') متوسط
                                @else متقدم
                                @endif
                            </div>
                            <div class="text-xs text-white/80">المستوى</div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('courses.show', $course->id) }}" class="btn-primary text-lg">
                                <i class="fas fa-play-circle bounce-animation"></i>
                                ابدأ التعلم الآن
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary text-lg">
                                <i class="fas fa-user-plus pulse-animation"></i>
                                سجل للوصول
                            </a>
                        @endauth
                        <a href="{{ route('public.courses') }}" class="btn-outline text-lg text-white border-white hover:bg-white hover:text-gray-900">
                            <i class="fas fa-arrow-right"></i>
                            جميع الكورسات
                        </a>
                    </div>
                </div>

                <!-- Course Preview Card -->
                <div class="relative slide-in-right">
                    <div class="glass-effect rounded-3xl p-8 backdrop-blur-xl border border-white/20">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-sky-500 via-sky-600 via-sky-700 to-slate-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl feature-icon-hover">
                                <i class="fas fa-code text-white text-4xl"></i>
                            </div>
                            
                            <!-- Price -->
                            <div class="mb-6">
                                @if(($course->price ?? 0) > 0)
                                    <div class="text-5xl font-black text-sky-300 mb-2">{{ number_format($course->price, 2) }} <span class="text-2xl">ج.م</span></div>
                                @else
                                    <div class="text-5xl font-black text-green-400 mb-2">مجاني</div>
                                @endif
                            </div>

                            <!-- Course Features -->
                            <div class="space-y-3 mb-6 text-right">
                                <div class="flex items-center gap-3 text-white/90">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span>وصول مدى الحياة</span>
                                </div>
                                <div class="flex items-center gap-3 text-white/90">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span>شهادة إتمام معتمدة</span>
                                </div>
                                <div class="flex items-center gap-3 text-white/90">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span>مشاريع عملية</span>
                                </div>
                                <div class="flex items-center gap-3 text-white/90">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <span>دعم مباشر</span>
                                </div>
                            </div>

                            @auth
                                <a href="{{ route('courses.show', $course->id) }}" class="btn-primary w-full justify-center">
                                    <i class="fas fa-play"></i>
                                    ابدأ الآن
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn-primary w-full justify-center">
                                    <i class="fas fa-sign-in-alt"></i>
                                    سجل للوصول
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Details Section -->
    <section class="py-20 bg-white relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- About Course -->
                    <div class="course-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-200">
                        <h2 class="text-3xl font-black text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-info-circle text-sky-600"></i>
                            عن الكورس
                        </h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            <p class="text-lg mb-4">{{ $course->description ?? 'كورس برمجي شامل ومتخصص' }}</p>
                            @if($course->objectives)
                                <div class="mt-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">أهداف الكورس:</h3>
                                    <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl p-6 border border-sky-100">
                                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $course->objectives }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- What You'll Learn -->
                    @if($course->what_you_learn)
                    <div class="course-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-200">
                        <h2 class="text-3xl font-black text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-graduation-cap text-sky-600"></i>
                            ما ستعلمه
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $learnPoints = explode("\n", $course->what_you_learn);
                            @endphp
                            @foreach($learnPoints as $point)
                                @if(trim($point))
                                    <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-sky-50 to-slate-50 rounded-xl border border-sky-100 hover:border-sky-300 transition-colors">
                                        <i class="fas fa-check-circle text-sky-600 mt-1 flex-shrink-0"></i>
                                        <span class="text-gray-700">{{ trim($point) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Requirements -->
                    @if($course->requirements)
                    <div class="course-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-200">
                        <h2 class="text-3xl font-black text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-list-check text-sky-600"></i>
                            المتطلبات
                        </h2>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $course->requirements }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-6 sticky-sidebar">
                        <!-- Course Info Card -->
                        <div class="bg-gradient-to-br from-sky-50 to-slate-50 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-sky-200">
                            <h3 class="text-xl font-black text-gray-900 mb-6 text-center">معلومات الكورس</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-200 hover:border-sky-300 transition-colors">
                                    <span class="text-gray-600 font-medium flex items-center gap-2">
                                        <i class="fas fa-clock text-sky-600"></i>
                                        المدة
                                    </span>
                                    <span class="font-bold text-gray-900">{{ $course->duration_hours ?? 0 }} ساعة</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-200 hover:border-sky-300 transition-colors">
                                    <span class="text-gray-600 font-medium flex items-center gap-2">
                                        <i class="fas fa-layer-group text-sky-600"></i>
                                        عدد الدروس
                                    </span>
                                    <span class="font-bold text-gray-900">{{ $course->lessons_count ?? 0 }} درس</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-200 hover:border-sky-300 transition-colors">
                                    <span class="text-gray-600 font-medium flex items-center gap-2">
                                        <i class="fas fa-signal text-sky-600"></i>
                                        المستوى
                                    </span>
                                    <span class="font-bold text-gray-900">
                                        @if($course->level == 'beginner') مبتدئ
                                        @elseif($course->level == 'intermediate') متوسط
                                        @else متقدم
                                        @endif
                                    </span>
                                </div>
                                
                                @if($course->academicSubject)
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-200 hover:border-sky-300 transition-colors">
                                    <span class="text-gray-600 font-medium flex items-center gap-2">
                                        <i class="fas fa-book text-sky-600"></i>
                                        المادة
                                    </span>
                                    <span class="font-bold text-gray-900">{{ $course->academicSubject->name }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-300">
                                @if(($course->price ?? 0) > 0)
                                    <div class="text-center mb-4">
                                        <div class="text-4xl font-black text-sky-600">{{ number_format($course->price, 2) }}</div>
                                        <div class="text-sm text-gray-600">جنيه مصري</div>
                                    </div>
                                @else
                                    <div class="text-center mb-4">
                                        <div class="text-4xl font-black text-green-600">مجاني</div>
                                    </div>
                                @endif
                                
                                @auth
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn-primary w-full justify-center">
                                        <i class="fas fa-play"></i>
                                        ابدأ التعلم
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="btn-primary w-full justify-center">
                                        <i class="fas fa-user-plus"></i>
                                        سجل الآن
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Related Courses -->
                        @if(isset($relatedCourses) && count($relatedCourses) > 0)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200">
                            <h3 class="text-xl font-black text-gray-900 mb-4">كورسات ذات صلة</h3>
                            <div class="space-y-3">
                                @foreach($relatedCourses->take(3) as $related)
                                <a href="{{ route('public.course.show', $related->id) }}" class="block p-4 bg-gray-50 rounded-xl hover:bg-sky-50 transition-all duration-300 border border-gray-200 hover:border-sky-300 hover:shadow-md">
                                    <h4 class="font-bold text-gray-900 mb-2">{{ $related->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ Str::limit($related->description ?? '', 60) }}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 hero-gradient">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                جاهز لبدء رحلتك البرمجية؟
            </h2>
            <p class="text-xl text-gray-300 mb-10">
                انضم إلى آلاف الطلاب الذين حققوا التميز في البرمجة مع Tech Bridge
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @auth
                    <a href="{{ route('courses.show', $course->id) }}" class="btn-primary text-lg">
                        <i class="fas fa-play"></i>
                        ابدأ التعلم الآن
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary text-lg">
                        <i class="fas fa-user-plus"></i>
                        سجل مجاناً الآن
                    </a>
                @endauth
                <a href="{{ route('public.courses') }}" class="btn-outline text-lg text-white border-white hover:bg-white hover:text-gray-900">
                    <i class="fas fa-arrow-right"></i>
                    استعرض جميع الكورسات
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

    <!-- Dynamic JavaScript -->
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
    </script>
</body>
</html>


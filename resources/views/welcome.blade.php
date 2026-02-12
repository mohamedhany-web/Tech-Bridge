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

        /* ألوان اللوجو للنصوص */
        .logo-text-gradient {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 45%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-gradient {
            background: linear-gradient(180deg, rgba(224, 242, 254, 0.7) 0%, rgba(255, 255, 255, 1) 50%);
            position: relative;
            overflow: hidden;
        }
        /* أزرار موحّدة للصفحة الرئيسية - شكل واحد في كل الأقسام */
        .btn-page-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #0284c7;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 14px;
            border: none;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        }
        .btn-page-primary:hover {
            background: #0369a1;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.4);
        }
        .btn-page-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #fff;
            color: #0284c7;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 28px;
            border-radius: 14px;
            border: 2px solid #0284c7;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-page-secondary:hover {
            background: #f0f9ff;
            color: #0369a1;
            border-color: #0369a1;
            transform: translateY(-2px);
        }
        /* أزرار الهيرو تستخدم نفس المظهر */
        .hero-btn-primary { background: #0284c7; color: white; }
        .hero-btn-primary:hover { background: #0369a1; color: white; transform: translateY(-2px); }
        .hero-btn-secondary { background: white; color: #0284c7; border: 2px solid #0284c7; }
        .hero-btn-secondary:hover { background: #f0f9ff; color: #0369a1; border-color: #0369a1; transform: translateY(-2px); }

        /* النافبار - لون أزرق صلب وتصميم أوضح */
        .navbar-bg {
            background: #0369a1 !important;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 40%, #0369a1 100%) !important;
        }
        .nav-logo-box {
            width: 52px; height: 52px; background: #fff; padding: 6px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12); border: 1px solid rgba(255,255,255,0.4);
            display: flex; align-items: center; justify-content: center; border-radius: 12px; overflow: hidden;
        }
        .nav-logo-img { object-fit: contain; max-width: 100%; max-height: 100%; }
        .nav-brand-text { color: #fff !important; font-size: 1.2rem; }
        .nav-brand-sub { color: rgba(255,255,255,0.9) !important; }
        .nav-link-item { text-decoration: none; }
        .nav-link-active { color: #fff !important; background: rgba(255,255,255,0.2); }
        .btn-nav-primary {
            background: #fff; color: #0369a1; padding: 10px 22px; border-radius: 12px; font-weight: 700; font-size: 0.95rem;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .btn-nav-primary:hover { background: #f0f9ff; color: #0284c7; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-nav-ghost {
            color: #fff; padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 0.95rem;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s ease;
            border: 1px solid rgba(255,255,255,0.4);
        }
        .btn-nav-ghost:hover { background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.6); }
        .nav-mobile-btn { background: rgba(255,255,255,0.1); color: #fff; }

        #mainNavbar.navbar-scrolled {
            box-shadow: 0 1px 3px rgba(14, 165, 233, 0.08);
        }

        .card-hover {
            transition: box-shadow 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }
        .card-hover:hover {
            box-shadow: 0 12px 28px rgba(14, 165, 233, 0.12);
            border-color: #bae6fd;
        }
        .page-card {
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .page-card:hover {
            box-shadow: 0 12px 28px rgba(14, 165, 233, 0.1);
            border-color: #bae6fd;
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

        /* عناوين الأقسام موحّدة */
        .section-title { font-size: 1.875rem; font-weight: 900; color: #0f172a; }
        @media (min-width: 768px) { .section-title { font-size: 2.25rem; } }
        .section-subtitle { color: #64748b; font-size: 1rem; }

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
            transition: box-shadow 0.25s ease;
        }
        .course-card-hover:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.1);
        }

        .star-rating {
            transition: all 0.3s ease;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* إضافة padding للأقسام للتعامل مع navbar الثابت */
        section[id] {
            scroll-margin-top: 100px;
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

<body class="bg-white text-slate-800"
      x-data="{ mobileMenu: false }"
      :class="{ 'no-scroll': mobileMenu }">

    @include('components.public-navbar')

    <!-- Hero Section - واجهة منصة كورسات بدون كارد -->
    <section id="home" class="hero-gradient py-20 sm:py-28 md:py-36 lg:py-40 relative overflow-hidden pt-28 min-h-[85vh] flex flex-col justify-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight">
                <span class="logo-text-gradient">Tech Bridge</span>
                <br>
                <span class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-slate-800 font-black mt-4 inline-block">أكاديمية برمجة</span>
            </h1>
            <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-sky-600 mb-6">
                احترف البرمجة من الصفر إلى الاحتراف
            </p>
            <div class="w-24 sm:w-32 h-1.5 bg-gradient-to-r from-sky-500 to-red-500 rounded-full shadow-md mx-auto mb-10"></div>
            <p class="text-xl sm:text-2xl text-slate-600 mb-12 leading-relaxed max-w-2xl mx-auto">
                رحلتك لتصبح مبرمج محترف تبدأ من هنا. اختر مسارك التعليمي وابدأ بأحدث الكورسات المتاحة.
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="#paths" class="hero-btn-primary btn-page-primary w-full sm:w-auto text-xl font-bold py-5 px-10 rounded-xl inline-flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-route text-white"></i>
                    المسارات التعليمية
                </a>
                <a href="{{ route('public.courses') }}" class="hero-btn-secondary btn-page-secondary w-full sm:w-auto text-xl font-bold py-5 px-10 rounded-xl inline-flex items-center justify-center gap-3 border-2 transition-all">
                    <i class="fas fa-book text-sky-600"></i>
                    تصفح الكورسات
                </a>
            </div>
        </div>
    </section>

    <!-- المسارات التعليمية -->
    <section id="paths" class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title mb-2">
                    المسارات <span class="logo-text-gradient">التعليمية</span>
                </h2>
                <p class="section-subtitle">اختر السنة أو المسار المناسب واطّلع على الكورسات المتاحة</p>
            </div>
            @if($academicYears->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($academicYears as $index => $year)
                    <a href="{{ route('public.courses') }}" class="block page-card card-hover rounded-2xl overflow-hidden relative">
                        <div class="h-32 bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center relative">
                            <i class="fas fa-graduation-cap text-white text-5xl"></i>
                            @if($year->advanced_courses_count > 0)
                                <span class="absolute top-3 right-3 bg-white/95 text-sky-700 text-sm font-bold px-3 py-1 rounded-full shadow-sm">{{ $year->advanced_courses_count }} كورس</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $year->name }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                @if($year->description)
                                    {{ Str::limit($year->description, 70) }}
                                @else
                                    استكشف الكورسات المتاحة لهذا المسار
                                @endif
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('public.courses') }}" class="btn-page-primary">
                        <i class="fas fa-th-large"></i>
                        عرض كل المسارات والكورسات
                    </a>
                </div>
            @else
                <div class="text-center py-14 bg-slate-50 rounded-2xl border border-slate-200">
                    <i class="fas fa-route text-sky-400 text-5xl mb-4"></i>
                    <p class="text-slate-600 mb-5">المسارات قيد الإعداد. تابعنا قريباً.</p>
                    <a href="{{ route('public.courses') }}" class="btn-page-primary">تصفح الكورسات</a>
                </div>
            @endif
        </div>
    </section>

    <!-- كورسات للبدء الآن -->
    <section id="featured-courses" class="py-16 sm:py-20 bg-slate-50/80 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title mb-2">
                    كورسات <span class="logo-text-gradient">للبدء الآن</span>
                </h2>
                <p class="section-subtitle">اختر من بين أحدث الكورسات النشطة على المنصة</p>
            </div>
            @if($featuredCourses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredCourses as $course)
                    <a href="{{ route('public.course.show', $course->id) }}" class="block page-card card-hover rounded-2xl overflow-hidden">
                        <div class="h-40 bg-slate-100 flex items-center justify-center relative overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-code text-sky-400 text-5xl"></i>
                            @endif
                            @if($course->is_featured)
                                <span class="absolute top-3 right-3 bg-amber-400 text-amber-900 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">مميز</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">{{ $course->title }}</h3>
                            @if($course->academicYear)
                                <p class="text-sky-600 text-sm font-medium mb-2">{{ $course->academicYear->name }}</p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-slate-500">
                                <span><i class="fas fa-play-circle ml-1 text-sky-500"></i> {{ $course->lessons_count ?? 0 }} درس</span>
                                @if($course->price && $course->price > 0)
                                    <span class="font-bold text-sky-600">{{ number_format($course->price, 0) }} ج.م</span>
                                @else
                                    <span class="font-bold text-emerald-600">مجاني</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('public.courses') }}" class="btn-page-primary">
                        <i class="fas fa-book-open"></i>
                        كل الكورسات
                    </a>
                </div>
            @else
                <div class="text-center py-14 bg-white rounded-2xl border border-slate-200">
                    <i class="fas fa-book text-sky-300 text-5xl mb-4"></i>
                    <p class="text-slate-600 mb-5">لا توجد كورسات معروضة حالياً. تصفح المسارات أعلاه.</p>
                    <a href="{{ route('public.courses') }}" class="btn-page-primary">صفحة الكورسات</a>
                </div>
            @endif
        </div>
    </section>

    <!-- من نحن -->
    <section id="about" class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="section-title mb-3">
                من نحن — <span class="logo-text-gradient">Tech Bridge</span>
            </h2>
            <p class="text-slate-600 leading-relaxed mb-8 text-lg">
                أكاديمية متخصصة في تعليم البرمجة. نقدّم مسارات تعليمية وكورسات عملية من المبتدئ إلى المتقدم، مع متابعة ودعم مستمر لضمان وصولك لمستوى احترافي.
            </p>
            <a href="{{ route('public.about') }}" class="btn-page-secondary">
                اعرف المزيد عن المنصة
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </section>

    <!-- مميزات المنصة -->
    <section id="features" class="py-16 sm:py-20 bg-slate-50/80 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title mb-2">
                    مميزات <span class="logo-text-gradient">منصتنا</span>
                </h2>
                <p class="section-subtitle max-w-2xl mx-auto">
                    نوفر مجموعة شاملة من الأدوات والميزات لضمان تجربة تعليمية استثنائية في البرمجة
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-play-circle text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">فيديوهات تفاعلية</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">شروحات برمجية عالية الجودة مع التحكم في سرعة التشغيل</p>
                </div>
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">اختبارات ذكية</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">تقييم متطور مع تصحيح فوري وتحليل نقاط القوة والضعف</p>
                </div>
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">تتبع التقدم</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">مراقبة الأداء مع تقارير مفصلة وتوصيات للتحسين</p>
                </div>
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-mobile-alt text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">متوافق مع الجوال</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">تصميم متجاوب يعمل على جميع الأجهزة</p>
                </div>
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-comments text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">دعم مباشر</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">تواصل فوري مع المعلم وإجابات سريعة للاستفسارات</p>
                </div>
                <div class="page-card card-hover text-center p-6 rounded-2xl">
                    <div class="w-16 h-16 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <i class="fas fa-certificate text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-3">شهادات معتمدة</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">شهادات إتمام معتمدة عند إنهاء الكورسات بنجاح</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA - ابدأ رحلتك -->
    <section class="py-16 sm:py-24 bg-white border-t border-slate-200/80">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="section-title text-2xl md:text-3xl mb-3">
                هل أنت مستعد لبدء رحلتك البرمجية؟
            </h2>
            <p class="text-slate-600 mb-10 text-lg">
                انضم إلى آلاف الطلاب الذين حققوا التميز في البرمجة مع <span class="logo-text-gradient font-bold">Tech Bridge</span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="btn-page-primary w-full sm:w-auto text-lg py-4 px-8">
                    <i class="fas fa-user-plus"></i>
                    ابدأ مجاناً الآن
                </a>
                <a href="{{ route('login') }}" class="btn-page-secondary w-full sm:w-auto text-lg py-4 px-8">
                    <i class="fas fa-sign-in-alt"></i>
                    لدي حساب بالفعل
                </a>
            </div>
        </div>
    </section>

    @include('components.public-footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.getElementById('mainNavbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    navbar.classList.toggle('navbar-scrolled', window.pageYOffset > 80);
                });
                navbar.classList.toggle('navbar-scrolled', window.pageYOffset > 80);
            }
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    var href = this.getAttribute('href');
                    if (href && href.length > 1) {
                        var target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
            });
        });
    </script>

    </body>
</html>

@extends('layouts.public')

@section('title', 'من نحن - Tech Bridge')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="section-title text-3xl md:text-4xl mb-3">
            من <span class="logo-text-gradient">نحن</span>
        </h1>
        <p class="section-subtitle text-lg">
            نحن نؤمن بقوة التعليم في تحويل المستقبل
        </p>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <div class="page-card card-hover p-8 rounded-2xl">
                <div class="w-14 h-14 bg-sky-500 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800 mb-4">رؤيتنا</h2>
                <p class="text-slate-600 leading-relaxed mb-3">
                    نطمح لأن نكون الرائدين في مجال التعليم البرمجي في المنطقة، حيث نقدم تعليماً عالي الجودة يجمع بين النظرية والتطبيق العملي.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    نسعى لتخريج جيل من المبرمجين المحترفين القادرين على المنافسة في السوق العالمي.
                </p>
            </div>
            <div class="page-card card-hover p-8 rounded-2xl">
                <div class="w-14 h-14 bg-sky-500 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800 mb-4">مهمتنا</h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    تقديم أفضل تجربة تعليمية في البرمجة مع التركيز على:
                </p>
                <ul class="space-y-3">
                    @foreach(['تعليم عملي يواكب أحدث التقنيات', 'دعم مستمر ومتابعة شخصية', 'بيئة تعليمية محفزة ومبتكرة', 'شهادات معتمدة ومعترف بها'] as $item)
                    <li class="flex items-center gap-3 text-slate-600">
                        <span class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-sky-600 text-sm"></i>
                        </span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Stats -->
        <div class="text-center mb-12">
            <h2 class="section-title mb-2">
                <span class="logo-text-gradient">إحصائياتنا</span>
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'fa-book', 'value' => ($stats['courses'] ?? 50) . '+', 'label' => 'كورس متاح'],
                ['icon' => 'fa-users', 'value' => ($stats['students'] ?? 1000) . '+', 'label' => 'طالب نشط'],
                ['icon' => 'fa-chalkboard-teacher', 'value' => ($stats['instructors'] ?? 20) . '+', 'label' => 'مدرس محترف'],
                ['icon' => 'fa-star', 'value' => '100%', 'label' => 'رضا العملاء'],
            ] as $stat)
            <div class="page-card card-hover p-6 rounded-2xl text-center">
                <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas {{ $stat['icon'] }} text-white"></i>
                </div>
                <div class="text-2xl md:text-3xl font-black text-sky-600 mb-1">{{ $stat['value'] }}</div>
                <div class="text-slate-600 font-medium text-sm">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Values -->
        <div class="text-center mt-16 mb-12">
            <h2 class="section-title mb-2">
                قيمنا <span class="logo-text-gradient">الأساسية</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'fa-lightbulb', 'title' => 'الابتكار', 'color' => 'sky', 'text' => 'نواكب أحدث التقنيات والمناهج التعليمية العالمية'],
                ['icon' => 'fa-award', 'title' => 'الجودة', 'color' => 'sky', 'text' => 'نلتزم بأعلى معايير الجودة في التعليم لتخريج مبرمجين محترفين'],
                ['icon' => 'fa-heart', 'title' => 'الشغف', 'color' => 'sky', 'text' => 'نحب ما نفعله ونؤمن بقوة التعليم في تحويل حياة الطلاب'],
            ] as $v)
            <div class="page-card card-hover p-6 rounded-2xl text-center">
                <div class="w-14 h-14 bg-sky-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas {{ $v['icon'] }} text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $v['title'] }}</h3>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $v['text'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Why Us -->
        <div class="text-center mt-16 mb-12">
            <h2 class="section-title mb-2">
                لماذا <span class="logo-text-gradient">نحن؟</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['icon' => 'fa-code', 'title' => 'محتوى حديث ومتطور', 'text' => 'محتوى تعليمي محدث باستمرار ليتوافق مع أحدث التقنيات وسوق العمل'],
                ['icon' => 'fa-user-tie', 'title' => 'مدربون محترفون', 'text' => 'فريق من المدربين المحترفين ذوي الخبرة الواسعة في المجال البرمجي'],
                ['icon' => 'fa-headset', 'title' => 'دعم فني مستمر', 'text' => 'دعم فني وتعليمي مستمر لمساعدتك في رحلتك التعليمية'],
                ['icon' => 'fa-certificate', 'title' => 'شهادات معتمدة', 'text' => 'شهادات معتمدة ومعترف بها عند إتمام الكورسات بنجاح'],
            ] as $w)
            <div class="page-card card-hover p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $w['icon'] }} text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $w['title'] }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $w['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 sm:py-20 bg-slate-50/80 border-t border-slate-200/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title text-2xl md:text-3xl mb-3">ابدأ رحلتك معنا اليوم</h2>
        <p class="text-slate-600 mb-8">انضم إلى آلاف الطلاب الذين يغيرون مستقبلهم معنا</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn-page-primary">
                <i class="fas fa-user-plus"></i>
                سجل الآن مجاناً
            </a>
            <a href="{{ route('public.courses') }}" class="btn-page-secondary">
                <i class="fas fa-book"></i>
                استعرض الكورسات
            </a>
        </div>
    </div>
</section>
@endsection

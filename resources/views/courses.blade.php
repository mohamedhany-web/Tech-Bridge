@extends('layouts.public')

@section('title', 'الكورسات - Tech Bridge')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="section-title text-3xl md:text-4xl mb-3">
            الكورسات <span class="logo-text-gradient">البرمجية</span>
        </h1>
        <p class="section-subtitle text-lg">
            اكتشف مجموعة شاملة من الكورسات المصممة لجميع المستويات
        </p>
    </div>
</section>

@if(isset($packages) && $packages->count() > 0)
<!-- Packages -->
<section class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title mb-2">باقات <span class="logo-text-gradient">الكورسات</span></h2>
            <p class="section-subtitle">اختر الباقة المناسبة واحصل على أفضل قيمة</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $package)
            <div class="page-card card-hover rounded-2xl overflow-hidden {{ $package->is_popular ? 'ring-2 ring-sky-500' : '' }}">
                @if($package->is_popular)
                <div class="bg-amber-400 text-amber-900 text-center py-2 text-sm font-bold">
                    <i class="fas fa-crown ml-1"></i> الأكثر شعبية
                </div>
                @endif
                <div class="h-40 bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center relative">
                    @if($package->thumbnail)
                    <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                    @else
                    <i class="fas fa-box text-white text-6xl"></i>
                    @endif
                    @if($package->is_featured)
                    <span class="absolute top-3 right-3 bg-amber-400 text-amber-900 text-xs font-bold px-2.5 py-1 rounded-lg">مميز</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $package->name }}</h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ Str::limit($package->description ?? 'باقة شاملة من الكورسات', 80) }}</p>
                    <div class="flex items-center justify-between mb-4 text-sm text-slate-600">
                        <span><i class="fas fa-graduation-cap ml-1 text-sky-500"></i> {{ $package->courses_count ?? 0 }} كورس</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        @if($package->original_price && $package->original_price > $package->price)
                        <span class="text-slate-400 text-sm line-through">{{ number_format($package->original_price, 0) }}</span>
                        @endif
                        <span class="text-xl font-black text-sky-600">{{ number_format($package->price ?? 0, 0) }} ج.م</span>
                        <a href="{{ route('public.package.show', $package->slug) }}" class="btn-page-primary text-sm py-2 px-4">
                            <i class="fas fa-shopping-cart"></i>
                            اشتر
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Courses -->
<section class="py-16 sm:py-20 {{ (isset($packages) && $packages->count() > 0) ? 'bg-slate-50/80' : 'bg-white' }} border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="section-title mb-2">الكورسات <span class="logo-text-gradient">الفردية</span></h2>
            <p class="section-subtitle">استكشف مجموعة متنوعة من الكورسات البرمجية</p>
        </div>

        @if(isset($courses) && is_array($courses) && count($courses) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $index => $course)
            <div class="page-card card-hover rounded-2xl overflow-hidden">
                <div class="h-40 bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center relative">
                    <i class="fas fa-code text-white text-5xl"></i>
                    @if(isset($course['is_featured']) && $course['is_featured'])
                    <span class="absolute top-3 right-3 bg-amber-400 text-amber-900 text-xs font-bold px-2.5 py-1 rounded-lg">مميز</span>
                    @endif
                    @if(isset($course['level']))
                    <span class="absolute top-3 left-3 bg-white/90 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded-lg">
                        @if($course['level'] == 'beginner') مبتدئ
                        @elseif($course['level'] == 'intermediate') متوسط
                        @else متقدم
                        @endif
                    </span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">{{ $course['title'] ?? 'بدون عنوان' }}</h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ Str::limit($course['description'] ?? 'كورس برمجي شامل', 90) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4 text-xs text-slate-500">
                        @if(isset($course['duration_hours']) && $course['duration_hours'] > 0)
                        <span><i class="fas fa-clock ml-1 text-sky-500"></i> {{ $course['duration_hours'] }} ساعة</span>
                        @endif
                        @if(isset($course['lessons_count']) && $course['lessons_count'] > 0)
                        <span><i class="fas fa-play-circle ml-1 text-sky-500"></i> {{ $course['lessons_count'] }} درس</span>
                        @endif
                        @if(isset($course['academic_subject']['name']))
                        <span class="px-2 py-0.5 bg-sky-50 text-sky-600 rounded">{{ $course['academic_subject']['name'] }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        @if(isset($course['price']) && $course['price'] > 0)
                        <span class="text-lg font-bold text-sky-600">{{ number_format($course['price'], 0) }} ج.م</span>
                        @else
                        <span class="text-lg font-bold text-emerald-600">مجاني</span>
                        @endif
                        <a href="{{ route('public.course.show', $course['id']) }}" class="btn-page-primary text-sm py-2 px-4">
                            <i class="fas fa-arrow-left"></i>
                            التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-code text-slate-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">قريباً...</h3>
            <p class="text-slate-600 mb-6">نعمل على إضافة المزيد من الكورسات</p>
            <a href="{{ route('register') }}" class="btn-page-primary">
                <i class="fas fa-bell"></i>
                اشترك للتحديثات
            </a>
        </div>
        @endif
    </div>
</section>

<!-- CTA -->
<section class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title text-2xl md:text-3xl mb-3">هل أنت مستعد لبدء رحلتك البرمجية؟</h2>
        <p class="text-slate-600 mb-8">انضم إلى آلاف الطلاب مع <span class="logo-text-gradient font-bold">Tech Bridge</span></p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn-page-primary">
                <i class="fas fa-user-plus"></i>
                ابدأ مجاناً الآن
            </a>
            <a href="{{ route('login') }}" class="btn-page-secondary">
                <i class="fas fa-sign-in-alt"></i>
                لدي حساب بالفعل
            </a>
        </div>
    </div>
</section>

@endsection

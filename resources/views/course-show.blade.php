@extends('layouts.public')

@section('title', ($course->title ?? 'تفاصيل الكورس') . ' - Tech Bridge')

@section('content')
<!-- Hero -->
<section class="page-hero py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-6 text-slate-600 text-sm">
            <a href="{{ url('/') }}" class="hover:text-sky-600 transition-colors">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.courses') }}" class="hover:text-sky-600 transition-colors">الكورسات</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 font-medium">{{ $course->title ?? 'الكورس' }}</span>
        </nav>
        <div class="flex flex-wrap items-center gap-3 mb-4">
            @if($course->is_featured ?? false)
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-100 text-amber-800 rounded-lg text-sm font-bold">
                <i class="fas fa-star"></i> مميز
            </span>
            @endif
            @if($course->academicSubject)
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-sky-100 text-sky-700 rounded-lg text-sm font-medium">
                <i class="fas fa-book"></i> {{ $course->academicSubject->name }}
            </span>
            @endif
        </div>
        <h1 class="section-title text-2xl md:text-3xl lg:text-4xl mb-3">
            {{ $course->title ?? 'اسم الكورس' }}
        </h1>
        <p class="text-slate-600 text-lg max-w-3xl">
            {{ Str::limit($course->description ?? 'كورس برمجي شامل ومتخصص', 160) }}
        </p>
        <div class="flex flex-wrap gap-4 mt-6">
            <span class="inline-flex items-center gap-2 text-slate-600">
                <i class="fas fa-play-circle text-sky-500"></i>
                <span>{{ $course->lessons_count ?? 0 }} درس</span>
            </span>
            <span class="inline-flex items-center gap-2 text-slate-600">
                <i class="fas fa-clock text-sky-500"></i>
                <span>{{ $course->duration_hours ?? 0 }} ساعة</span>
            </span>
            <span class="inline-flex items-center gap-2 text-slate-600">
                <i class="fas fa-signal text-sky-500"></i>
                <span>
                    @if($course->level == 'beginner') مبتدئ
                    @elseif($course->level == 'intermediate') متوسط
                    @else متقدم
                    @endif
                </span>
            </span>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            @auth
            <a href="{{ route('courses.show', $course->id) }}" class="btn-page-primary">
                <i class="fas fa-play-circle"></i>
                ابدأ التعلم الآن
            </a>
            @else
            <a href="{{ route('public.course.order.form', $course->id) }}" class="btn-page-primary">
                <i class="fas fa-shopping-cart"></i>
                شراء الكورس الآن
            </a>
            @endauth
            <a href="{{ route('public.courses') }}" class="btn-page-secondary">
                <i class="fas fa-arrow-right"></i>
                جميع الكورسات
            </a>
        </div>
    </div>
</section>

<!-- Content + Sidebar -->
<section class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About -->
                <div class="page-card card-hover p-8 rounded-2xl">
                    <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sky-500"></i>
                        عن الكورس
                    </h2>
                    <p class="text-slate-600 leading-relaxed mb-4">{{ $course->description ?? 'كورس برمجي شامل ومتخصص' }}</p>
                    @if($course->objectives)
                    <div class="mt-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-3">أهداف الكورس</h3>
                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                            <p class="text-slate-600 whitespace-pre-line leading-relaxed">{{ $course->objectives }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                @if($course->what_you_learn)
                <div class="page-card card-hover p-8 rounded-2xl">
                    <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-sky-500"></i>
                        ما ستعلمه
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach(array_filter(explode("\n", $course->what_you_learn)) as $point)
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <i class="fas fa-check-circle text-sky-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-slate-600 text-sm">{{ trim($point) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($course->requirements)
                <div class="page-card card-hover p-8 rounded-2xl">
                    <h2 class="text-xl font-black text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-list-check text-sky-500"></i>
                        المتطلبات
                    </h2>
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                        <p class="text-slate-600 whitespace-pre-line leading-relaxed">{{ $course->requirements }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky-sidebar space-y-6">
                    <div class="page-card card-hover p-6 rounded-2xl">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 text-center">معلومات الكورس</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <span class="text-slate-600 text-sm flex items-center gap-2"><i class="fas fa-clock text-sky-500"></i> المدة</span>
                                <span class="font-bold text-slate-800">{{ $course->duration_hours ?? 0 }} ساعة</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <span class="text-slate-600 text-sm flex items-center gap-2"><i class="fas fa-layer-group text-sky-500"></i> الدروس</span>
                                <span class="font-bold text-slate-800">{{ $course->lessons_count ?? 0 }} درس</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <span class="text-slate-600 text-sm flex items-center gap-2"><i class="fas fa-signal text-sky-500"></i> المستوى</span>
                                <span class="font-bold text-slate-800">
                                    @if($course->level == 'beginner') مبتدئ
                                    @elseif($course->level == 'intermediate') متوسط
                                    @else متقدم
                                    @endif
                                </span>
                            </div>
                            @if($course->academicSubject)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-slate-600 text-sm flex items-center gap-2"><i class="fas fa-book text-sky-500"></i> المادة</span>
                                <span class="font-bold text-slate-800">{{ $course->academicSubject->name }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="pt-4 border-t border-slate-200">
                            @if(($course->price ?? 0) > 0)
                            <div class="text-center mb-4">
                                <span class="text-2xl font-black text-sky-600">{{ number_format($course->price, 0) }}</span>
                                <span class="text-slate-600 text-sm"> ج.م</span>
                            </div>
                            @else
                            <div class="text-center mb-4">
                                <span class="text-2xl font-black text-emerald-600">مجاني</span>
                            </div>
                            @endif
                            @auth
                            <a href="{{ route('courses.show', $course->id) }}" class="btn-page-primary w-full justify-center">
                                <i class="fas fa-play"></i>
                                ابدأ التعلم
                            </a>
                            @else
                            <a href="{{ route('public.course.order.form', $course->id) }}" class="btn-page-primary w-full justify-center">
                                <i class="fas fa-shopping-cart"></i>
                                شراء الكورس الآن
                            </a>
                            @endauth
                        </div>
                    </div>

                    @if(isset($relatedCourses) && $relatedCourses->count() > 0)
                    <div class="page-card card-hover p-6 rounded-2xl">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">كورسات ذات صلة</h3>
                        <div class="space-y-3">
                            @foreach($relatedCourses->take(3) as $related)
                            <a href="{{ route('public.course.show', $related->id) }}" class="block p-4 rounded-xl border border-slate-100 hover:border-sky-200 hover:bg-sky-50/50 transition-all">
                                <h4 class="font-bold text-slate-800 mb-1 text-sm">{{ $related->title }}</h4>
                                <p class="text-slate-500 text-xs line-clamp-2">{{ Str::limit($related->description ?? '', 60) }}</p>
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

<!-- CTA -->
<section class="py-16 sm:py-20 bg-slate-50/80 border-t border-slate-200/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="section-title text-2xl md:text-3xl mb-3">جاهز لبدء رحلتك البرمجية؟</h2>
        <p class="text-slate-600 mb-8">انضم إلى آلاف الطلاب مع <span class="logo-text-gradient font-bold">Tech Bridge</span></p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
            <a href="{{ route('courses.show', $course->id) }}" class="btn-page-primary">
                <i class="fas fa-play"></i>
                ابدأ التعلم الآن
            </a>
            @else
            <a href="{{ route('public.course.order.form', $course->id) }}" class="btn-page-primary">
                <i class="fas fa-shopping-cart"></i>
                شراء الكورس الآن
            </a>
            @endauth
            <a href="{{ route('public.courses') }}" class="btn-page-secondary">
                <i class="fas fa-arrow-right"></i>
                استعرض الكورسات
            </a>
        </div>
    </div>
</section>

@endsection

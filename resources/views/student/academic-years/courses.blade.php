@extends('layouts.app')

@section('title', $academicYear->name . ' - كورسات المسار')
@section('header', 'كورسات المسار')

@section('content')
<div class="space-y-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <div class="px-6 py-8 sm:px-10 sm:py-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300 text-sm font-semibold">
                        <i class="fas fa-route"></i>
                        مسار {{ $academicYear->name }}
                    </span>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white">
                        كورسات المسار التعليمي
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        اختر الكورس المناسب لمستواك وتخصصك. الكورسات تعتمد على مشاريع عملية وأدوات حديثة.
                    </p>
                </div>
                <a href="{{ route('academic-years') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 transition-colors">
                    <i class="fas fa-arrow-right"></i>
                    العودة للمسارات
                </a>
            </div>
            <div class="mt-8 p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700">
                <p class="text-sm text-slate-500 dark:text-slate-400">عدد الكورسات</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $courses->count() }}</p>
            </div>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="relative h-48 bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center">
                        @if(!empty($course->thumbnail))
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="absolute inset-0 w-full h-full object-cover opacity-90">
                        @else
                            <i class="fas fa-play-circle text-white text-6xl"></i>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/90 text-slate-900">
                                {{ $course->level ? __($course->level) : 'مبتدئ' }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4 space-y-2 text-right">
                            @if(!empty($course->price) && !$course->is_free)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-500 text-white text-sm font-bold shadow-lg">
                                    {{ number_format($course->price, 0) }} ج.م
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white/90 text-emerald-600 text-sm font-bold shadow-lg">
                                    مجاني
                                </span>
                            @endif
                            @if(!empty($course->rating))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-black/30 text-white text-xs font-medium">
                                    <i class="fas fa-star text-amber-400 ml-1"></i>{{ number_format($course->rating, 1) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col p-6 space-y-4">
                        <div class="space-y-2">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white leading-tight">{{ $course->title }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ Str::limit($course->description, 130) }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs text-gray-500 dark:text-gray-400">
                            @if($course->programming_language)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-code text-sky-500"></i>
                                    <span>{{ $course->programming_language }}</span>
                                </div>
                            @endif
                            @if($course->framework)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cubes text-indigo-500"></i>
                                    <span>{{ $course->framework }}</span>
                                </div>
                            @endif
                            @if($course->lessons_count)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-video text-emerald-500"></i>
                                    <span>{{ $course->lessons_count }} درس</span>
                                </div>
                            @endif
                            @if(!empty($course->duration_label))
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-amber-500"></i>
                                    <span>{{ $course->duration_label }}</span>
                                </div>
                            @endif
                        </div>

                        @if($course->tech_stack && $course->tech_stack->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->tech_stack as $skill)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 mt-auto border-t border-slate-100 dark:border-slate-800">
                            <div class="text-xs text-gray-400">
                                <span>آخر تحديث</span>
                                <span class="font-semibold text-gray-500 dark:text-gray-300 ml-1">
                                    {{ optional($course->created_at)->diffForHumans() }}
                                </span>
                            </div>
                            <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors text-sm font-semibold">
                                تفاصيل الكورس
                                <i class="fas fa-arrow-left text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl p-12 text-center space-y-4">
            <div class="flex items-center justify-center">
                <span class="w-16 h-16 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 flex items-center justify-center text-2xl">
                    <i class="fas fa-graduation-cap"></i>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">لا توجد كورسات في هذا المسار حالياً</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                لم يتم ربط هذا المسار بكورسات حتى الآن. عد لاحقاً أو تصفح المسارات الأخرى.
            </p>
            <a href="{{ route('academic-years') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors">
                <i class="fas fa-arrow-right"></i>
                العودة للمسارات
            </a>
        </div>
    @endif
</div>
@endsection

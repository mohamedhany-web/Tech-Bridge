@extends('layouts.app')

@section('content')
@php
    $primaryCards = [
        [
            'label' => 'إجمالي المستخدمين',
            'value' => number_format($totalUsers),
            'icon' => 'fas fa-users',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
            'footer' => "+$newUsersThisMonth مستخدم جديد هذا الشهر",
        ],
        [
            'label' => 'الطلاب النشطون',
            'value' => number_format($totalStudents),
            'icon' => 'fas fa-user-graduate',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
            'footer' => round(($totalStudents / max($totalUsers, 1)) * 100, 1) . '% من إجمالي المستخدمين',
        ],
        [
            'label' => 'المدربون',
            'value' => number_format($totalTeachers),
            'icon' => 'fas fa-chalkboard-teacher',
            'color' => 'text-amber-500 bg-amber-100/70 dark:text-amber-300 dark:bg-amber-500/10',
            'footer' => round(($totalTeachers / max($totalUsers, 1)) * 100, 1) . '% من إجمالي المستخدمين',
        ],
        [
            'label' => 'الكورسات النشطة',
            'value' => number_format($totalCourses),
            'icon' => 'fas fa-code',
            'color' => 'text-purple-500 bg-purple-100/70 dark:text-purple-300 dark:bg-purple-500/10',
            'footer' => number_format($totalEnrollments) . ' تسجيل إجمالي',
        ],
    ];

    $secondaryCards = [
        [
            'label' => 'مسارات التعلم',
            'value' => number_format($totalAcademicYears),
            'icon' => 'fas fa-route',
            'color' => 'text-indigo-500 bg-indigo-100/70 dark:text-indigo-300 dark:bg-indigo-500/10',
        ],
        [
            'label' => 'مجموعات المهارات',
            'value' => number_format($totalSubjects),
            'icon' => 'fas fa-layer-group',
            'color' => 'text-rose-500 bg-rose-100/70 dark:text-rose-300 dark:bg-rose-500/10',
        ],
        [
            'label' => 'تسجيلات هذا الشهر',
            'value' => number_format($newEnrollmentsThisMonth),
            'icon' => 'fas fa-user-plus',
            'color' => 'text-teal-500 bg-teal-100/70 dark:text-teal-300 dark:bg-teal-500/10',
        ],
    ];

    $activityLogRoute = \Illuminate\Support\Facades\Route::has('admin.activity-log')
        ? route('admin.activity-log')
        : null;
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">لوحة المؤشرات الرئيسية</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">عرض سريع لحالة المنصة ونموها عبر المستخدمين والمحتوى والتسجيلات.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.statistics.users') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                    <i class="fas fa-users"></i>
                    إحصائيات المستخدمين
                </a>
                <a href="{{ route('admin.statistics.courses') }}" class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                    <i class="fas fa-code"></i>
                    إحصائيات الكورسات
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            @foreach ($primaryCards as $card)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
                        </div>
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $card['color'] }}">
                            <i class="{{ $card['icon'] }} text-xl"></i>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-300">{{ $card['footer'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">تفاصيل إضافية</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">توزيع المسارات التعليمية وشدة النشاط خلال الشهر الحالي.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 sm:p-8">
            @foreach ($secondaryCards as $card)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                        <p class="mt-3 text-xl font-bold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $card['color'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">أكثر الكورسات تسجيلاً</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">أكثر المسارات جذباً للطلاب خلال الفترة الحالية.</p>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Top Courses</span>
            </div>
            <div class="p-5 sm:p-8">
                @if ($popularCourses->count() > 0)
                    <div class="space-y-4">
                        @foreach ($popularCourses as $course)
                            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 flex flex-col gap-2 hover:border-sky-300 hover:shadow transition dark:border-slate-800 dark:bg-slate-900/70">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $course->title }}</h4>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-500/15 dark:text-sky-200">
                                        <i class="fas fa-user-friends"></i>
                                        {{ $course->enrollments_count }} طالب
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-300">{{ $course->academicYear->name ?? 'غير محدد' }}@if($course->academicSubject) • {{ $course->academicSubject->name }}@endif</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-200 bg-white/70 p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300">
                        لا توجد بيانات متاحة حالياً.
                    </div>
                @endif
            </div>
        </div>
        <div class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">آخر النشاطات</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">تحركات الفريق خلال الساعات القليلة الماضية.</p>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">Activity</span>
            </div>
            <div class="p-5 sm:p-8">
                @if ($recentActivities->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentActivities as $activity)
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white/70 p-4 dark:border-slate-800 dark:bg-slate-900/70">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div class="flex-1">
                                    <p class="text-sm text-slate-900 dark:text-white"><span class="font-semibold">{{ $activity->user->name ?? 'مستخدم مجهول' }}</span> {{ $activity->description }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-300 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        @if ($activityLogRoute)
                            <a href="{{ $activityLogRoute }}" class="inline-flex items-center gap-2 text-sm font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-300 dark:hover:text-sky-200">
                                استعرض كامل السجل
                                <i class="fas fa-arrow-left text-xs"></i>
                            </a>
                        @endif
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-200 bg-white/70 p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300">
                        لا توجد نشاطات حديثة.
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection


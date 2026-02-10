@extends('layouts.app')

@section('title', 'لوحة الإدارة - Tech Bridge')
@section('header', 'لوحة الإدارة')

@section('content')
<div class="p-6 space-y-6">
    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- إجمالي المستخدمين -->
        @php $usersMetric = $metrics['users'] ?? null; $usersTrend = $usersMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-slate-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إجمالي المستخدمين</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">{{ number_format($usersMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">مستخدمون جدد هذا الشهر: {{ number_format($usersMetric['new_this_month'] ?? 0) }}</p>
                @if($usersTrend)
                    @php
                        $diff = (int) round($usersTrend['difference']);
                        $percent = $usersTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($usersTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                </div>
                @else
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">لا توجد بيانات مقارنة للشهر السابق.</p>
                @endif
            </div>
        </div>

        <!-- الطلاب -->
        @php $studentsMetric = $metrics['students'] ?? null; $studentsTrend = $studentsMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-green-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">الطلاب</p>
                        <p class="text-4xl font-black text-green-600 dark:text-green-400">{{ number_format($studentsMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">طلاب جدد هذا الشهر: {{ number_format($studentsMetric['new_this_month'] ?? 0) }}</p>
                @if($studentsTrend)
                    @php
                        $diff = (int) round($studentsTrend['difference']);
                        $percent = $studentsTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($studentsTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                </div>
                @endif
            </div>
        </div>

        <!-- المدربين -->
        @php $instructorsMetric = $metrics['instructors'] ?? null; $instructorsTrend = $instructorsMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-indigo-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">المدربين</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-indigo-600 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-indigo-400 dark:to-slate-400">{{ number_format($instructorsMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-tie text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">مدربون جدد هذا الشهر: {{ number_format($instructorsMetric['new_this_month'] ?? 0) }}</p>
                @if($instructorsTrend)
                    @php
                        $diff = (int) round($instructorsTrend['difference']);
                        $percent = $instructorsTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($instructorsTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- الكورسات -->
        @php $coursesMetric = $metrics['courses'] ?? null; $coursesTrend = $coursesMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-amber-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">الكورسات</p>
                        <p class="text-4xl font-black text-amber-600 dark:text-amber-400">{{ number_format($coursesMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">كورسات جديدة هذا الشهر: {{ number_format($coursesMetric['new_this_month'] ?? 0) }}</p>
                @if($coursesTrend)
                    @php
                        $diff = (int) round($coursesTrend['difference']);
                        $percent = $coursesTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($coursesTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                    </div>
                @endif
                </div>
            </div>
        </div>

    <!-- إحصائيات مالية -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- إجمالي الإيرادات -->
        @php $revenueMetric = $metrics['monthly_revenue'] ?? null; $revenueTrend = $revenueMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-emerald-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-100/50 to-green-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إجمالي الإيرادات</p>
                        <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($stats['total_revenue'] ?? 0, 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

        <!-- إيرادات الشهر -->
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-blue-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-cyan-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إيرادات الشهر</p>
                        <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ number_format($revenueMetric['current'] ?? 0, 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
                @if($revenueTrend)
                    @php
                        $diff = $revenueTrend['difference'];
                        $percent = $revenueTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff, 2) }} ج.م
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($revenueTrend['previous'], 2) }} ج.م)</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- الفواتير المعلقة -->
        @php $pendingMetric = $metrics['pending_invoices'] ?? null; $pendingTrend = $pendingMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-yellow-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">فواتير معلقة</p>
                        <p class="text-3xl font-black text-yellow-600 dark:text-yellow-400">{{ number_format($pendingMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-invoice text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">فواتير جديدة هذا الشهر: {{ number_format($pendingMetric['new_this_month'] ?? 0) }}</p>
                @if($pendingTrend)
                    @php
                        $diff = (int) round($pendingTrend['difference']);
                        $percent = $pendingTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-yellow-600 dark:text-yellow-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($pendingTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- التسجيلات النشطة -->
        @php $enrollmentsMetric = $metrics['enrollments'] ?? null; $enrollmentsTrend = $enrollmentsMetric['trend'] ?? null; @endphp
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-purple-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-pink-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">التسجيلات النشطة</p>
                        <p class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ number_format($enrollmentsMetric['total'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">تسجيلات جديدة هذا الشهر: {{ number_format($enrollmentsMetric['new_this_month'] ?? 0) }}</p>
                @if($enrollmentsTrend)
                    @php
                        $diff = (int) round($enrollmentsTrend['difference']);
                        $percent = $enrollmentsTrend['percent'];
                        $positive = $diff >= 0;
                    @endphp
                    <div class="mt-3 flex items-center gap-2 text-sm">
                        <span class="font-bold {{ $positive ? 'text-green-600 dark:text-green-400' : 'text-rose-500 dark:text-rose-400' }}">
                            {{ $positive ? '+' : '' }}{{ number_format($diff) }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400">عن الشهر الماضي ({{ number_format($enrollmentsTrend['previous']) }})</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $positive ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                            {{ $percent >= 0 ? '+' : '' }}{{ number_format($percent, 1) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- الأنشطة الأخيرة -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- سجل النشاطات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">
                    <i class="fas fa-history text-sky-600 dark:text-sky-400 ml-2"></i>
                    آخر النشاطات
                </h3>
            </div>
            <div class="p-6">
                @if(isset($stats['recent_activities']) && $stats['recent_activities']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['recent_activities']->take(5) as $activity)
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                        <i class="fas fa-history text-gray-600 dark:text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 dark:text-white">
                                        {{ $activity->user->name ?? 'مستخدم محذوف' }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->action }} - {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.activity-log') }}" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-300 text-sm font-medium">
                            عرض جميع النشاطات
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد أنشطة بعد</p>
                @endif
            </div>
        </div>

        <!-- آخر محاولات الامتحانات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">
                    <i class="fas fa-clipboard-check text-sky-600 dark:text-sky-400 ml-2"></i>
                    آخر محاولات الامتحانات
                </h3>
            </div>
            <div class="p-6">
                @if(isset($stats['recent_exam_attempts']) && $stats['recent_exam_attempts']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['recent_exam_attempts']->take(5) as $attempt)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $attempt->student->name ?? 'طالب محذوف' }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $attempt->exam->title ?? 'امتحان محذوف' }}</p>
                                </div>
                                <div class="text-left">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $attempt->score >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($attempt->score >= 60 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                        {{ $attempt->score }}%
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد محاولات امتحانات بعد</p>
                @endif
            </div>
        </div>
    </div>

    <!-- آخر المستخدمين والكورسات -->
    @if(isset($recent_users) || isset($recent_courses))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- آخر المستخدمين -->
        @if(isset($recent_users))
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-users text-sky-600 dark:text-sky-400 ml-2"></i>
                        آخر المستخدمين
                    </h3>
                    <a href="{{ route('admin.users') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($recent_users as $user)
                    <div class="flex items-center gap-4 p-3 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-sky-100 dark:border-gray-600">
                        <div class="w-12 h-12 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->phone ?? $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role === 'student') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($user->role === 'instructor') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300
                                @elseif($user->role === 'super_admin') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                @if($user->role === 'student') طالب
                                @elseif($user->role === 'instructor') مدرب
                                @elseif($user->role === 'super_admin') مدير عام
                                @else غير محدد @endif
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- آخر الكورسات -->
        @if(isset($recent_courses))
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-book text-sky-600 dark:text-sky-400 ml-2"></i>
                        آخر الكورسات
                    </h3>
                    <a href="{{ route('admin.advanced-courses.index') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recent_courses as $course)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-sky-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-book text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $course->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ optional($course->academicSubject)->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($course->is_active) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                @if($course->is_active) نشط
                                @else غير نشط @endif
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $course->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-book text-3xl mb-2"></i>
                        <p>لا توجد كورسات بعد</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- الفواتير والمدفوعات -->
    @if((isset($pending_invoices) && $pending_invoices->count() > 0) || (isset($recent_payments) && $recent_payments->count() > 0))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- الفواتير المعلقة -->
        @if(isset($pending_invoices) && $pending_invoices->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-file-invoice text-yellow-600 dark:text-yellow-400 ml-2"></i>
                        الفواتير المعلقة
                    </h3>
                    <a href="{{ route('admin.invoices.index') }}" class="text-sm font-semibold text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($pending_invoices as $invoice)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-yellow-100 hover:to-orange-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-yellow-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 via-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-invoice text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $invoice->invoice_number ?? 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->user->name ?? 'غير محدد' }}</p>
                            <p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">{{ number_format($invoice->total_amount ?? 0, 2) }} ج.م</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                معلق
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $invoice->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- المدفوعات الأخيرة -->
        @if(isset($recent_payments) && $recent_payments->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-money-bill-wave text-emerald-600 dark:text-emerald-400 ml-2"></i>
                        المدفوعات الأخيرة
                    </h3>
                    <a href="{{ route('admin.payments.index') }}" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($recent_payments as $payment)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-emerald-100 hover:to-green-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-emerald-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 via-green-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-money-bill-wave text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $payment->payment_number ?? 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->user->name ?? 'غير محدد' }}</p>
                            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($payment->amount ?? 0, 2) }} ج.م</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                مكتمل
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $payment->paid_at ? $payment->paid_at->diffForHumans() : $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- أزرار سريعة -->
    <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 card-hover-effect">
        <div class="pb-4 mb-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-xl font-black text-gray-900 dark:text-white">
                <i class="fas fa-bolt text-sky-600 dark:text-sky-400 ml-2"></i>
                إجراءات سريعة
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">روابط مباشرة للمهام اليومية بناءً على بيانات النظام الحالية</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            @foreach(($quickActions ?? []) as $action)
                <a href="{{ $action['route'] }}"
                   class="flex flex-col items-center gap-4 p-5 bg-gradient-to-br {{ $action['background'] }} dark:from-gray-700 dark:to-gray-800 rounded-2xl border border-white/50 dark:border-gray-600 shadow-md hover:shadow-xl transition-all duration-300 card-hover-effect group">
                    <div class="w-14 h-14 bg-gradient-to-br {{ $action['icon_background'] }} rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $action['icon'] }} text-white text-xl"></i>
                    </div>
                    <div class="text-center space-y-2">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $action['title'] }}</p>
                        <p class="text-3xl font-black {{ $action['count_class'] ?? 'text-sky-700 dark:text-sky-300' }}">
                            {{ number_format($action['count']) }}
                        </p>
                        @if(!empty($action['meta']))
                            <p class="text-xs {{ $action['meta_class'] ?? 'text-gray-500 dark:text-gray-300' }}">{{ $action['meta'] }}</p>
                        @endif
                        <span class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-sky-600 dark:text-sky-300 group-hover:text-sky-700 dark:group-hover:text-sky-200">
                            {{ $action['cta'] }}
                            <i class="fas fa-arrow-left text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @endforeach
            @if(empty($quickActions))
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400 text-sm py-4">
                    لا توجد مهام عاجلة حالياً.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

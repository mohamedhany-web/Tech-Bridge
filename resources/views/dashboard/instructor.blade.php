@extends('layouts.app')

@section('title', 'لوحة تحكم المدرب')
@section('header', 'لوحة تحكم المدرب')

@section('content')
<div class="space-y-6">
    <!-- ترحيب شخصي -->
    <div class="bg-gradient-to-r from-sky-500 via-indigo-600 to-slate-600 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden card-hover-effect">
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black mb-2">مرحباً، {{ auth()->user()->name }}</h2>
                    <p class="text-sky-100 text-lg font-medium">إليك نظرة عامة على نشاطك التعليمي اليوم</p>
                </div>
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border border-white/30">
                    <i class="fas fa-user-tie text-white text-4xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- كورساتي -->
        <div class="bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-indigo-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">كورساتي</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-indigo-600 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-indigo-400 dark:to-slate-400">{{ number_format($stats['my_courses']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('instructor.courses.index') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        إدارة الكورسات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- طلابي -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-green-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إجمالي الطلاب</p>
                        <p class="text-4xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['total_students']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('instructor.courses.index') }}" class="text-sm font-semibold text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors inline-flex items-center gap-2">
                        عرض الطلاب
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- المحاضرات -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-purple-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-pink-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">المحاضرات</p>
                        <p class="text-4xl font-black text-purple-600 dark:text-purple-400">{{ number_format($stats['total_lectures']) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['upcoming_lectures'] }} قادمة</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('instructor.lectures.index') }}" class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors inline-flex items-center gap-2">
                        إدارة المحاضرات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- الواجبات -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-amber-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">الواجبات</p>
                        <p class="text-4xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['total_assignments']) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['pending_submissions'] }} تحتاج تقييم</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('instructor.assignments.index') }}" class="text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors inline-flex items-center gap-2">
                        إدارة الواجبات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- آخر الكورسات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-book text-sky-600 dark:text-sky-400 ml-2"></i>
                        كورساتي الحديثة
                    </h3>
                    <a href="{{ route('instructor.courses.index') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($my_courses as $course)
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-sky-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 via-indigo-600 to-slate-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-play text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1">{{ $course->title }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <i class="fas fa-book text-sky-500 ml-1"></i>
                                {{ optional($course->academicSubject)->name ?? 'غير محدد' }}
                                @if($course->academicYear)
                                    - {{ $course->academicYear->name }}
                                @endif
                            </p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-600 dark:text-gray-400 font-semibold">
                                    <i class="fas fa-users text-sky-500 ml-1"></i>
                                    {{ $course->active_students_count ?? 0 }} طالب
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-calendar text-slate-500 ml-1"></i>
                                    {{ $course->created_at->format('Y/m/d') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('instructor.courses.show', $course) }}" 
                               class="p-3 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl text-white hover:from-sky-600 hover:to-sky-700 transition-all duration-300 shadow-md hover:shadow-lg"
                               title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-book text-3xl mb-2"></i>
                        <p>لم تقم بإنشاء أي كورسات بعد</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- المحاضرات القادمة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-calendar-alt text-purple-600 dark:text-purple-400 ml-2"></i>
                        المحاضرات القادمة
                    </h3>
                    <a href="{{ route('instructor.lectures.index') }}" class="text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($upcoming_lectures as $lecture)
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-purple-100 hover:to-pink-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-purple-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1">{{ $lecture->title }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <i class="fas fa-book text-purple-500 ml-1"></i>
                                {{ $lecture->course->title ?? 'غير محدد' }}
                                @if($lecture->lesson)
                                    - {{ $lecture->lesson->title }}
                                @endif
                            </p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-600 dark:text-gray-400 font-semibold">
                                    <i class="fas fa-calendar text-purple-500 ml-1"></i>
                                    {{ $lecture->scheduled_at->format('Y/m/d') }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-clock text-pink-500 ml-1"></i>
                                    {{ $lecture->scheduled_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('instructor.lectures.show', $lecture) }}" 
                               class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl text-white hover:from-purple-600 hover:to-pink-700 transition-all duration-300 shadow-md hover:shadow-lg"
                               title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar-alt text-3xl mb-2"></i>
                        <p>لا توجد محاضرات قادمة</p>
                        <a href="{{ route('instructor.lectures.create') }}" class="inline-flex items-center mt-3 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                            <i class="fas fa-plus ml-2"></i>
                            إضافة محاضرة جديدة
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- الواجبات المعلقة والاختبارات -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- الواجبات المعلقة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-tasks text-amber-600 dark:text-amber-400 ml-2"></i>
                        واجبات تحتاج تقييم ({{ $stats['pending_submissions'] }})
                    </h3>
                    <a href="{{ route('instructor.assignments.index') }}" class="text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($pending_assignments as $submission)
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-amber-100 hover:to-orange-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-amber-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-alt text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1">{{ $submission->assignment->title ?? 'واجب' }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <i class="fas fa-user text-amber-500 ml-1"></i>
                                {{ $submission->student->name ?? 'طالب' }}
                            </p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-600 dark:text-gray-400 font-semibold">
                                    <i class="fas fa-calendar text-amber-500 ml-1"></i>
                                    {{ $submission->created_at->format('Y/m/d') }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-clock text-orange-500 ml-1"></i>
                                    {{ $submission->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('instructor.assignments.submissions', $submission->assignment) }}" 
                               class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl text-white hover:from-amber-600 hover:to-orange-700 transition-all duration-300 shadow-md hover:shadow-lg"
                               title="تقييم الواجب">
                                <i class="fas fa-check"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-check-circle text-3xl mb-2 text-green-500"></i>
                        <p>جميع الواجبات تم تقييمها</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- المجموعات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-users text-emerald-600 dark:text-emerald-400 ml-2"></i>
                        مجموعاتي ({{ $stats['total_groups'] }})
                    </h3>
                    <a href="{{ route('instructor.groups.index') }}" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($my_groups as $group)
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-emerald-100 hover:to-teal-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-emerald-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1">{{ $group->name }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                <i class="fas fa-book text-emerald-500 ml-1"></i>
                                {{ $group->course->title ?? 'غير محدد' }}
                            </p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-600 dark:text-gray-400 font-semibold">
                                    <i class="fas fa-users text-emerald-500 ml-1"></i>
                                    {{ $group->members->count() ?? 0 }} عضو
                                </span>
                                @if($group->max_members)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        / {{ $group->max_members }} حد أقصى
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('instructor.groups.show', $group) }}" 
                               class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl text-white hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 shadow-md hover:shadow-lg"
                               title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-users text-3xl mb-2"></i>
                        <p>لا توجد مجموعات</p>
                        <a href="{{ route('instructor.groups.create') }}" class="inline-flex items-center mt-3 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                            <i class="fas fa-plus ml-2"></i>
                            إنشاء مجموعة جديدة
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- إجراءات سريعة -->
    <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 card-hover-effect">
        <div class="pb-4 mb-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-black text-gray-900 dark:text-white">
                <i class="fas fa-bolt text-sky-600 dark:text-sky-400 ml-2"></i>
                إجراءات سريعة
            </h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('instructor.lectures.create') }}" class="flex flex-col items-center p-6 bg-gradient-to-br from-sky-100 to-sky-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:from-sky-200 hover:to-sky-100 dark:hover:from-gray-600 dark:hover:to-gray-700 transition-all duration-300 card-hover-effect border border-sky-200 dark:border-gray-600 shadow-md hover:shadow-xl group">
                <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-video text-white text-2xl"></i>
                </div>
                <span class="text-sm font-bold text-sky-700 dark:text-sky-300">إضافة محاضرة</span>
            </a>
            
            <a href="{{ route('instructor.assignments.create') }}" class="flex flex-col items-center p-6 bg-gradient-to-br from-green-100 to-green-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:from-green-200 hover:to-green-100 dark:hover:from-gray-600 dark:hover:to-gray-700 transition-all duration-300 card-hover-effect border border-green-200 dark:border-gray-600 shadow-md hover:shadow-xl group">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-tasks text-white text-2xl"></i>
                </div>
                <span class="text-sm font-bold text-green-700 dark:text-green-300">إضافة واجب</span>
            </a>
            
            <a href="{{ route('instructor.exams.index') }}" class="flex flex-col items-center p-6 bg-gradient-to-br from-indigo-100 to-purple-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:from-indigo-200 hover:to-purple-100 dark:hover:from-gray-600 dark:hover:to-gray-700 transition-all duration-300 card-hover-effect border border-indigo-200 dark:border-gray-600 shadow-md hover:shadow-xl group">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clipboard-check text-white text-2xl"></i>
                </div>
                <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">إدارة الاختبارات</span>
            </a>
            
            <a href="{{ route('instructor.attendance.index') }}" class="flex flex-col items-center p-6 bg-gradient-to-br from-amber-100 to-orange-50 dark:from-gray-700 dark:to-gray-800 rounded-xl hover:from-amber-200 hover:to-orange-100 dark:hover:from-gray-600 dark:hover:to-gray-700 transition-all duration-300 card-hover-effect border border-amber-200 dark:border-gray-600 shadow-md hover:shadow-xl group">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clipboard-list text-white text-2xl"></i>
                </div>
                <span class="text-sm font-bold text-amber-700 dark:text-amber-300">الحضور والغياب</span>
            </a>
        </div>
    </div>
</div>
@endsection

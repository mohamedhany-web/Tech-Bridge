@extends('layouts.app')

@section('title', 'الحضور والغياب - Tech Bridge')
@section('header', 'الحضور والغياب')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">الحضور والغياب</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">عرض وإدارة سجلات الحضور والغياب للمحاضرات</p>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-6">
            <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي المحاضرات</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_lectures'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-emerald-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">سجلات الحضور</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['total_attendance_records'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-blue-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">حاضر</div>
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['present_count'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-rose-50 to-red-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-rose-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">غائب</div>
                <div class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $stats['absent_count'] ?? 0 }}</div>
            </div>
        </div>

        <!-- الفلاتر -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكورس</label>
                    <select name="course_id" id="course_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">جميع الكورسات</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">حالة المحاضرة</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">جميع الحالات</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>مجدولة</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                    </select>
                </div>

                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">من تاريخ</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">إلى تاريخ</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['course_id', 'status', 'date_from', 'date_to']))
                        <a href="{{ route('instructor.attendance.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة المحاضرات -->
    @if($lectures->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($lectures as $lecture)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $lecture->title }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($lecture->status == 'scheduled') bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200
                                    @elseif($lecture->status == 'in_progress') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                    @elseif($lecture->status == 'completed') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                    @endif">
                                    @if($lecture->status == 'scheduled') مجدولة
                                    @elseif($lecture->status == 'in_progress') قيد التنفيذ
                                    @elseif($lecture->status == 'completed') مكتملة
                                    @else ملغاة
                                    @endif
                                </span>
                            </div>
                            
                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-book text-sky-500"></i>
                                    <span class="font-medium">الكورس:</span>
                                    <span>{{ $lecture->course->title ?? 'غير محدد' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-sky-500"></i>
                                    <span class="font-medium">التاريخ والوقت:</span>
                                    <span>{{ $lecture->scheduled_at->format('Y/m/d H:i') }}</span>
                                </div>
                                @if($lecture->attendance_records_count > 0)
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-users text-sky-500"></i>
                                    <span class="font-medium">سجلات الحضور:</span>
                                    <span>{{ $lecture->attendance_records_count }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('instructor.attendance.lecture', $lecture) }}" 
                               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                                <i class="fas fa-eye ml-2"></i>
                                عرض الحضور
                            </a>
                            <a href="{{ route('instructor.lectures.show', $lecture) }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $lectures->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد محاضرات</p>
                <p class="text-sm">لم يتم إنشاء أي محاضرات بعد</p>
            </div>
        </div>
    @endif
</div>
@endsection


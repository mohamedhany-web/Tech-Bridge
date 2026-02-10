@extends('layouts.app')

@section('title', 'الواجبات - Tech Bridge')
@section('header', 'الواجبات')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">الواجبات</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة الواجبات والتسليمات</p>
            </div>
            <a href="{{ route('instructor.assignments.create') }}" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus ml-2"></i>
                إنشاء واجب جديد
            </a>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-6">
            <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي الواجبات</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-emerald-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">منشورة</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['published'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-amber-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">مسودة</div>
                <div class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['draft'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-purple-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي التسليمات</div>
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_submissions'] ?? 0 }}</div>
            </div>
        </div>

        <!-- الفلاتر -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">جميع الحالات</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منشورة</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>مؤرشفة</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البحث</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="البحث في الواجبات..."
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['course_id', 'status', 'search']))
                        <a href="{{ route('instructor.assignments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة الواجبات -->
    @if($assignments->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($assignments as $assignment)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($assignment->status == 'published') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @elseif($assignment->status == 'draft') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                    @else bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-200
                                    @endif">
                                    @if($assignment->status == 'published') منشور
                                    @elseif($assignment->status == 'draft') مسودة
                                    @else مؤرشف
                                    @endif
                                </span>
                            </div>
                            
                            @if($assignment->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $assignment->description }}</p>
                            @endif
                            
                            <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                <div class="flex items-center">
                                    <i class="fas fa-book text-sky-500 ml-2"></i>
                                    <span>الكورس: {{ $assignment->course->title ?? 'غير محدد' }}</span>
                                </div>
                                @if($assignment->lesson)
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-purple-500 ml-2"></i>
                                    <span>الدرس: {{ $assignment->lesson->title ?? 'غير محدد' }}</span>
                                </div>
                                @endif
                                @if($assignment->due_date)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-red-500 ml-2"></i>
                                    <span>تاريخ الاستحقاق: {{ $assignment->due_date->format('Y/m/d H:i') }}</span>
                                    @if($assignment->due_date->isPast() && !$assignment->allow_late_submission)
                                    <span class="mr-2 text-red-500">(منتهي)</span>
                                    @endif
                                </div>
                                @endif
                                <div class="flex items-center">
                                    <i class="fas fa-file-upload text-indigo-500 ml-2"></i>
                                    <span>التسليمات: {{ $assignment->submissions_count }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-500 ml-2"></i>
                                    <span>الدرجة الكلية: {{ $assignment->max_score }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('instructor.assignments.show', $assignment) }}" 
                               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                                <i class="fas fa-eye ml-2"></i>
                                عرض التفاصيل
                            </a>
                            <a href="{{ route('instructor.assignments.submissions', $assignment) }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-list ml-2"></i>
                                التسليمات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $assignments->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-tasks text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد واجبات</p>
                <p class="text-sm">لم يتم إنشاء أي واجبات بعد</p>
                <a href="{{ route('instructor.assignments.create') }}" class="mt-4 inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إنشاء واجب جديد
                </a>
            </div>
        </div>
    @endif
</div>
@endsection


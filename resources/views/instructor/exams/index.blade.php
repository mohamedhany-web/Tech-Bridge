@extends('layouts.app')

@section('title', 'الاختبارات - Tech Bridge')
@section('header', 'الاختبارات')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">الاختبارات</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة الاختبارات والمحاولات</p>
            </div>
            <a href="{{ route('instructor.exams.create') }}" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus ml-2"></i>
                إنشاء اختبار جديد
            </a>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-6">
            <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي الاختبارات</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-emerald-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">نشطة</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['active'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-purple-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي المحاولات</div>
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_attempts'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-blue-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">مكتملة</div>
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['completed_attempts'] ?? 0 }}</div>
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
                    <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                    <select name="is_active" id="is_active" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>نشطة</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>معطلة</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البحث</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="البحث في الاختبارات..."
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['course_id', 'is_active', 'search']))
                        <a href="{{ route('instructor.exams.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة الاختبارات -->
    @if($exams->count() > 0)
        <div class="grid grid-cols-1 gap-6">
            @foreach($exams as $exam)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $exam->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200' }}">
                                    {{ $exam->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                            
                            @if($exam->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $exam->description }}</p>
                            @endif
                            
                            <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                <div class="flex items-center">
                                    <i class="fas fa-book text-sky-500 ml-2"></i>
                                    <span>الكورس: {{ $exam->advancedCourse->title ?? 'غير محدد' }}</span>
                                </div>
                                @if($exam->lesson)
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-purple-500 ml-2"></i>
                                    <span>الدرس: {{ $exam->lesson->title ?? 'غير محدد' }}</span>
                                </div>
                                @endif
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-clock text-indigo-500 ml-2"></i>
                                        المدة: {{ $exam->duration_minutes }} دقيقة
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-star text-yellow-500 ml-2"></i>
                                        الدرجة الكلية: {{ $exam->total_marks }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 ml-2"></i>
                                        درجة النجاح: {{ $exam->passing_marks }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-question-circle text-blue-500 ml-2"></i>
                                        الأسئلة: {{ $exam->questions_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-users text-purple-500 ml-2"></i>
                                        المحاولات: {{ $exam->attempts_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-redo text-orange-500 ml-2"></i>
                                        المحاولات المسموحة: {{ $exam->attempts_allowed == 0 ? 'غير محدود' : $exam->attempts_allowed }}
                                    </span>
                                </div>
                                @if($exam->start_time || $exam->end_time)
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-red-500 ml-2"></i>
                                    <span>
                                        @if($exam->start_time && $exam->end_time)
                                            من {{ $exam->start_time->format('Y/m/d H:i') }} إلى {{ $exam->end_time->format('Y/m/d H:i') }}
                                        @elseif($exam->start_time)
                                            يبدأ في: {{ $exam->start_time->format('Y/m/d H:i') }}
                                        @elseif($exam->end_time)
                                            ينتهي في: {{ $exam->end_time->format('Y/m/d H:i') }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('instructor.exams.show', $exam) }}" 
                               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                                <i class="fas fa-eye ml-2"></i>
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $exams->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد اختبارات</p>
                <p class="text-sm">لم يتم إنشاء أي اختبارات بعد</p>
                <a href="{{ route('instructor.exams.create') }}" class="mt-4 inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إنشاء اختبار جديد
                </a>
            </div>
        </div>
    @endif
</div>
@endsection


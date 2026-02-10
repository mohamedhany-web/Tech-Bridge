@extends('layouts.app')

@section('title', 'كورساتي - Tech Bridge')
@section('header', 'كورساتي')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">كورساتي</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">الكورسات التي تم تعيينها لك</p>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-6">
            <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي الكورسات</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-emerald-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">نشطة</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['active'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-amber-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">معطلة</div>
                <div class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['inactive'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-purple-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي الطلاب</div>
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_students'] ?? 0 }}</div>
            </div>
        </div>

        <!-- الفلاتر -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البحث</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="البحث في عناوين الكورسات..."
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                        <i class="fas fa-search ml-2"></i>
                        بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة الكورسات -->
    @if($courses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-200 dark:border-gray-700">
                <!-- هيدر البطاقة -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $course->title }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $course->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200' }}">
                            {{ $course->is_active ? 'نشط' : 'معطل' }}
                        </span>
                    </div>
                </div>

                <!-- محتوى البطاقة -->
                <div class="px-6 py-4">
                    @if($course->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                    @endif

                    <div class="space-y-2 mb-4">
                        @if($course->academicYear)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-graduation-cap text-sky-500 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">السنة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $course->academicYear->name }}</span>
                        </div>
                        @endif

                        @if($course->academicSubject)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-book text-sky-500 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">المادة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $course->academicSubject->name }}</span>
                        </div>
                        @endif

                        @if($course->programming_language)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-code text-sky-500 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">اللغة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $course->programming_language }}</span>
                        </div>
                        @endif

                        @if($course->level)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-signal text-sky-500 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">المستوى:</span>
                            <span class="text-gray-900 dark:text-white mr-2">
                                @if($course->level == 'beginner') مبتدئ
                                @elseif($course->level == 'intermediate') متوسط
                                @else متقدم
                                @endif
                            </span>
                        </div>
                        @endif

                        @if($course->price && $course->price > 0)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-money-bill-wave text-sky-500 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">السعر:</span>
                            <span class="text-gray-900 dark:text-white mr-2 font-bold">{{ number_format($course->price, 2) }} ج.م</span>
                        </div>
                        @else
                        <div class="flex items-center text-sm">
                            <i class="fas fa-gift text-emerald-500 w-4 ml-2"></i>
                            <span class="text-emerald-600 dark:text-emerald-400 font-medium">مجاني</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- إحصائيات سريعة -->
                <div class="px-6 py-3 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->lessons_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">درس</div>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->enrollments_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">طالب</div>
                        </div>
                    </div>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                    <a href="{{ route('instructor.courses.show', $course) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                        <i class="fas fa-eye"></i>
                        عرض التفاصيل
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- الصفحات -->
        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book-open text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد كورسات</p>
                <p class="text-sm">لم يتم تعيين أي كورسات لك بعد</p>
            </div>
        </div>
    @endif
</div>
@endsection


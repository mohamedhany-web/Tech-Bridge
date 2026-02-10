@extends('layouts.app')

@section('title', 'تفاصيل الكورس - ' . $course->title)
@section('header', 'تفاصيل الكورس')

@section('content')
<div class="space-y-6">
    <!-- الهيدر والعودة -->
    <div class="flex items-center justify-between">
        <div>
            <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('instructor.courses.index') }}" class="hover:text-sky-600">كورساتي</a>
                <span class="mx-2">/</span>
                <span>{{ $course->title }}</span>
            </nav>
        </div>
        <a href="{{ route('instructor.courses.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة
        </a>
    </div>

    <!-- معلومات أساسية وإحصائيات -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- معلومات الكورس -->
        <div class="xl:col-span-3">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات الكورس</h3>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $course->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $course->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                        @if($course->is_featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-star ml-1"></i>
                                مميز
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($course->thumbnail)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" 
                                 class="w-full h-64 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">العنوان</label>
                                <div class="font-semibold text-gray-900 dark:text-white text-lg">{{ $course->title }}</div>
                            </div>
                            @if($course->academicYear)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المسار التعليمي</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->academicYear->name }}</div>
                            </div>
                            @endif
                            @if($course->academicSubject)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">مجموعة المهارات</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->academicSubject->name }}</div>
                            </div>
                            @endif
                            @if($course->instructor)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المدرب</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->instructor->name }}</div>
                            </div>
                            @endif
                        </div>
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المستوى</label>
                                <div class="text-gray-900 dark:text-white">
                                    @if($course->level == 'beginner') مبتدئ
                                    @elseif($course->level == 'intermediate') متوسط
                                    @elseif($course->level == 'advanced') متقدم
                                    @else غير محدد
                                    @endif
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">السعر</label>
                                <div class="text-gray-900 dark:text-white font-bold text-lg">
                                    @if($course->price && $course->price > 0)
                                        {{ number_format($course->price, 2) }} ج.م
                                    @else
                                        <span class="text-emerald-600 dark:text-emerald-400">مجاني</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">مدة الكورس</label>
                                <div class="text-gray-900 dark:text-white">
                                    {{ $course->duration_hours ?? 0 }} ساعة
                                    @if($course->duration_minutes && $course->duration_minutes > 0)
                                        و {{ $course->duration_minutes }} دقيقة
                                    @endif
                                </div>
                            </div>
                            @if($course->programming_language)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">لغة البرمجة</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->programming_language }}</div>
                            </div>
                            @endif
                            @if($course->framework)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الإطار / التقنية</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->framework }}</div>
                            </div>
                            @endif
                            @if($course->category)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">التصنيف</label>
                                <div class="text-gray-900 dark:text-white">{{ $course->category }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($course->description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">الوصف</label>
                            <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                {{ $course->description }}
                            </div>
                        </div>
                    @endif

                    @if($course->objectives)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">الأهداف</label>
                            <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                {{ $course->objectives }}
                            </div>
                        </div>
                    @endif

                    @if($course->what_you_learn)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">ما ستعلمه</label>
                            <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                {{ $course->what_you_learn }}
                            </div>
                        </div>
                    @endif

                    @if($course->prerequisites)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">المتطلبات المسبقة</label>
                            <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                {{ $course->prerequisites }}
                            </div>
                        </div>
                    @endif

                    @if($course->requirements)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">المتطلبات</label>
                            <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                {{ $course->requirements }}
                            </div>
                        </div>
                    @endif

                    @if($course->skills && is_array($course->skills) && count($course->skills) > 0)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">المهارات</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($course->skills as $skill)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- الدروس -->
            @if($course->lessons && $course->lessons->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 mt-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الدروس ({{ $course->lessons_count ?? $course->lessons->count() }})</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($course->lessons as $lesson)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-play-circle text-sky-500 text-xl"></i>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $lesson->title ?? 'درس بدون عنوان' }}</div>
                                    @if($lesson->description)
                                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($lesson->description, 60) }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($lesson->duration)
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-clock ml-1"></i>
                                        {{ $lesson->duration }} دقيقة
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- الإحصائيات -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الإحصائيات</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $course->lessons_count ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">درس</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-emerald-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $course->enrollments_count ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">طالب مسجل</div>
                    </div>
                    @if($course->starts_at)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">تاريخ البداية</div>
                        <div class="text-gray-900 dark:text-white">{{ $course->starts_at->format('Y/m/d') }}</div>
                    </div>
                    @endif
                    @if($course->ends_at)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">تاريخ النهاية</div>
                        <div class="text-gray-900 dark:text-white">{{ $course->ends_at->format('Y/m/d') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- الطلاب المسجلين -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الطلاب المسجلين ({{ $enrollments->total() }})</h3>
        </div>
        <div class="p-6">
            @if($enrollments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الاسم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">البريد الإلكتروني</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الهاتف</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ التسجيل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($enrollments as $enrollment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $enrollment->user->name ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $enrollment->user->email ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $enrollment->user->phone ?? 'غير محدد' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $enrollment->created_at->format('Y/m/d') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $enrollment->status ?? 'نشط' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $enrollments->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-500 dark:text-gray-400">
                        <i class="fas fa-user-graduate text-5xl mb-4"></i>
                        <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">لا يوجد طلاب مسجلين</p>
                        <p class="text-sm">لم يتم تسجيل أي طلاب في هذا الكورس بعد</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


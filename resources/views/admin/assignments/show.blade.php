@extends('layouts.app')

@section('title', 'تفاصيل الواجب')
@section('header', 'الواجبات والمشاريع')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assignment->title }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $assignment->course->title ?? $assignment->lesson->title ?? '-' }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.assignments.edit', $assignment) }}"
                       class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors shadow-md">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل
                    </a>
                    <a href="{{ route('admin.assignments.submissions', $assignment) }}"
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-medium transition-colors shadow-md">
                        <i class="fas fa-list ml-2"></i>
                        التسليمات
                    </a>
                    <a href="{{ route('admin.assignments.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-right ml-2"></i>
                        رجوع
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الاستحقاق</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $assignment->due_date ? $assignment->due_date->format('Y-m-d H:i') : 'غير محدد' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">الدرجة الكلية</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $assignment->max_score }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">التسليمات</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $assignment->submissions->count() }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">الحالة</p>
                    <p class="mt-1">
                        @if($assignment->status == 'published')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">منشور</span>
                        @elseif($assignment->status == 'draft')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">مسودة</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">مؤرشف</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($assignment->description)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">الوصف</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $assignment->description }}</p>
            </div>
            @endif

            @if($assignment->instructions)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">التعليمات</h3>
                <div class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $assignment->instructions }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- إحصائيات التسليمات -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">التسليمات</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="p-4 rounded-xl bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800">
                    <p class="text-sm text-sky-700 dark:text-sky-300">الإجمالي</p>
                    <p class="text-2xl font-bold text-sky-900 dark:text-sky-100">{{ $submissionStats['total'] }}</p>
                </div>
                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                    <p class="text-sm text-amber-700 dark:text-amber-300">قيد المراجعة</p>
                    <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $submissionStats['submitted'] }}</p>
                </div>
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                    <p class="text-sm text-emerald-700 dark:text-emerald-300">تم التقييم</p>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ $submissionStats['graded'] }}</p>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm text-gray-700 dark:text-gray-300">تم الإرجاع</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $submissionStats['returned'] }}</p>
                </div>
            </div>

            @if($submissions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الطالب</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ التسليم</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الدرجة</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($submissions as $sub)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $sub->student->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $sub->submitted_at ? $sub->submitted_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $sub->score !== null ? $sub->score . ' / ' . $assignment->max_score : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sub->status == 'submitted')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">قيد المراجعة</span>
                                @elseif($sub->status == 'graded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">تم التقييم</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">تم الإرجاع</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.assignments.submissions', $assignment) }}?submission={{ $sub->id }}" class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-300" title="عرض/تقييم">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
            @else
            <p class="text-center text-gray-500 dark:text-gray-400 py-8">لا توجد تسليمات حتى الآن</p>
            @endif
        </div>
    </div>
</div>
@endsection

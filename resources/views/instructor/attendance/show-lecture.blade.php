@extends('layouts.app')

@section('title', 'حضور المحاضرة - ' . $lecture->title)
@section('header', 'حضور المحاضرة')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('instructor.attendance.index') }}" class="hover:text-sky-600">الحضور والغياب</a>
                    <span class="mx-2">/</span>
                    <span>{{ $lecture->title }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lecture->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $lecture->course->title ?? 'غير محدد' }} - {{ $lecture->scheduled_at->format('Y/m/d H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('instructor.lectures.show', $lecture) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة للمحاضرة
                </a>
                <a href="{{ route('instructor.attendance.index') }}" 
                   class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-list ml-2"></i>
                    قائمة الحضور
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- جدول الحضور -->
        <div class="xl:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">سجلات الحضور</h3>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        إجمالي الطلاب: {{ $attendanceStats['total_students'] }}
                    </div>
                </div>
                <div class="p-6">
                    @if($enrollments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الاسم</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">البريد الإلكتروني</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الحالة</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">دقائق الحضور</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">النسبة</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($enrollments as $enrollment)
                                    @php
                                        $record = $attendanceRecords->get($enrollment->user_id);
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $enrollment->user->name ?? 'غير محدد' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $enrollment->user->email ?? 'غير محدد' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($record)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($record->status == 'present') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                                    @elseif($record->status == 'late') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                                    @elseif($record->status == 'partial') bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200
                                                    @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                                    @endif">
                                                    @if($record->status == 'present') حاضر
                                                    @elseif($record->status == 'late') متأخر
                                                    @elseif($record->status == 'partial') جزئي
                                                    @else غائب
                                                    @endif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-200">
                                                    غير محدد
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $record && isset($record->attendance_minutes) ? $record->attendance_minutes : 0 }} / {{ $lecture->duration_minutes }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($record && $record->attendance_percentage)
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ number_format($record->attendance_percentage, 1) }}%
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-500 dark:text-gray-400">0%</div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-users text-4xl mb-3"></i>
                            <p>لا يوجد طلاب مسجلين في هذا الكورس</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إحصائيات الحضور</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-emerald-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $attendanceStats['present'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">حاضر</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-amber-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $attendanceStats['late'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">متأخر</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-blue-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $attendanceStats['partial'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">جزئي</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-rose-50 to-red-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-rose-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-rose-600 dark:text-rose-400">{{ $attendanceStats['absent'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">غائب</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                        <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $attendanceStats['total_students'] ?? 0 }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">إجمالي الطلاب</div>
                    </div>
                </div>
            </div>

            <!-- معلومات المحاضرة -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات المحاضرة</h3>
                </div>
                <div class="p-6 space-y-3 text-sm">
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">التاريخ والوقت</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $lecture->scheduled_at->format('Y/m/d H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">المدة</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $lecture->duration_minutes }} دقيقة</div>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">الحالة</div>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


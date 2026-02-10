@extends('layouts.app')

@section('title', 'تفاصيل المحاضرة - ' . $lecture->title)
@section('header', 'تفاصيل المحاضرة')

@push('scripts')
<script>
function updateAttendance(studentId, status) {
    const formData = {
        student_id: studentId,
        status: status,
        _token: '{{ csrf_token() }}'
    };
    
    fetch('{{ route("instructor.lectures.update-attendance", $lecture) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'حدث خطأ أثناء تحديث الحضور');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الحضور');
    });
}

function updateStatus(status) {
    fetch('{{ route("instructor.lectures.update-status", $lecture) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'حدث خطأ أثناء تحديث الحالة');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الحالة');
    });
}
</script>
@endpush

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('instructor.lectures.index') }}" class="hover:text-sky-600">المحاضرات</a>
                    <span class="mx-2">/</span>
                    <span>{{ $lecture->title }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lecture->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $lecture->course->title ?? 'غير محدد' }}
                    @if($lecture->lesson)
                        <span class="mr-2">-</span>
                        <span class="text-sky-600 dark:text-sky-400">{{ $lecture->lesson->title }}</span>
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('instructor.lectures.edit', $lecture) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="{{ route('instructor.lectures.index') }}" 
                   class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- معلومات المحاضرة -->
        <div class="xl:col-span-2 space-y-6">
            <!-- معلومات أساسية -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات المحاضرة</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الحالة</label>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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
                                @if($lecture->status != 'completed' && $lecture->status != 'cancelled')
                                <select onchange="updateStatus(this.value)" 
                                        class="text-xs border border-gray-300 dark:border-gray-600 rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
                                    <option value="scheduled" {{ $lecture->status == 'scheduled' ? 'selected' : '' }}>مجدولة</option>
                                    <option value="in_progress" {{ $lecture->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                    <option value="completed" {{ $lecture->status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                    <option value="cancelled" {{ $lecture->status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                                </select>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">التاريخ والوقت</label>
                            <div class="text-gray-900 dark:text-white font-medium">{{ $lecture->scheduled_at->format('Y/m/d H:i') }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">المدة</label>
                            <div class="text-gray-900 dark:text-white">{{ $lecture->duration_minutes }} دقيقة</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الكورس</label>
                            <div class="text-gray-900 dark:text-white">{{ $lecture->course->title ?? 'غير محدد' }}</div>
                        </div>
                        @if($lecture->lesson)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الدرس</label>
                            <div class="text-gray-900 dark:text-white">{{ $lecture->lesson->title }}</div>
                        </div>
                        @endif
                    </div>

                    @if($lecture->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الوصف</label>
                        <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">{{ $lecture->description }}</div>
                    </div>
                    @endif

                    @if($lecture->notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">الملاحظات</label>
                        <div class="text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">{{ $lecture->notes }}</div>
                    </div>
                    @endif

                    <!-- الروابط -->
                    @if($lecture->teams_registration_link || $lecture->teams_meeting_link || $lecture->recording_url)
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">الروابط</label>
                        <div class="space-y-2">
                            @if($lecture->teams_registration_link)
                            <a href="{{ $lecture->teams_registration_link }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-700 dark:text-sky-400">
                                <i class="fas fa-link"></i>
                                رابط تسجيل Teams
                            </a>
                            @endif
                            @if($lecture->teams_meeting_link)
                            <a href="{{ $lecture->teams_meeting_link }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-700 dark:text-sky-400 block">
                                <i class="fas fa-video"></i>
                                رابط اجتماع Teams
                            </a>
                            @endif
                            @if($lecture->recording_url)
                            <a href="{{ $lecture->recording_url }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-sky-600 hover:text-sky-700 dark:text-sky-400 block">
                                <i class="fas fa-play-circle"></i>
                                رابط تسجيل المحاضرة
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- إدارة الحضور -->
            @if($lecture->has_attendance_tracking)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إدارة الحضور والغياب</h3>
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
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الحالة</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">دقائق الحضور</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الإجراءات</th>
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
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $enrollment->user->email ?? '' }}
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
                                            @if($record && isset($record->attendance_percentage) && $record->attendance_percentage)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ number_format($record->attendance_percentage, 1) }}%
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <select onchange="updateAttendance({{ $enrollment->user_id }}, this.value)" 
                                                    class="text-xs border border-gray-300 dark:border-gray-600 rounded px-2 py-1 dark:bg-gray-700 dark:text-white">
                                                <option value="present" {{ $record && $record->status == 'present' ? 'selected' : '' }}>حاضر</option>
                                                <option value="late" {{ $record && $record->status == 'late' ? 'selected' : '' }}>متأخر</option>
                                                <option value="partial" {{ $record && $record->status == 'partial' ? 'selected' : '' }}>جزئي</option>
                                                <option value="absent" {{ !$record || $record->status == 'absent' ? 'selected' : '' }}>غائب</option>
                                            </select>
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
            @endif
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

            <!-- الخيارات -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الخيارات</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 dark:text-gray-300">تتبع الحضور</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lecture->has_attendance_tracking ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $lecture->has_attendance_tracking ? 'مفعل' : 'معطل' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 dark:text-gray-300">يوجد واجب</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lecture->has_assignment ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $lecture->has_assignment ? 'نعم' : 'لا' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 dark:text-gray-300">يوجد تقييم</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lecture->has_evaluation ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $lecture->has_evaluation ? 'نعم' : 'لا' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


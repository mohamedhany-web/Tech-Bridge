@extends('layouts.app')

@section('title', 'تسليمات الواجب')
@section('header', 'الواجبات والمشاريع')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">تسليمات: {{ $assignment->title }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">عرض وتقييم تسليمات الطلاب</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.assignments.show', $assignment) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-right ml-2"></i>
                        رجوع للواجب
                    </a>
                    <a href="{{ route('admin.assignments.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors">
                        <i class="fas fa-list ml-2"></i>
                        كل الواجبات
                    </a>
                </div>
            </div>
        </div>

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
                    @forelse($submissions as $sub)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                        data-sub-id="{{ $sub->id }}"
                        data-score="{{ $sub->score ?? '' }}"
                        data-status="{{ $sub->status }}"
                        data-feedback="{{ e($sub->feedback ?? '') }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $sub->student->name ?? '-' }}</div>
                            @if($sub->student && $sub->student->email)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $sub->student->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $sub->submitted_at ? $sub->submitted_at->format('Y-m-d H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            @if($sub->score !== null)
                                {{ $sub->score }} / {{ $assignment->max_score }}
                            @else
                                -
                            @endif
                        </td>
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
                            <button type="button" onclick="openGradeModal(this.closest('tr'))"
                                    class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-300" title="تقييم">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            لا توجد تسليمات حتى الآن
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($submissions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal التقييم -->
<div id="gradeModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(0,0,0,0.5);">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-w-md w-full overflow-hidden" @click.stop>
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">تقييم التسليم</h3>
        </div>
        <form id="gradeForm" method="POST" action="" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="modal_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الدرجة (0 - {{ $assignment->max_score }})</label>
                    <input type="number" name="score" id="modal_score" min="0" max="{{ $assignment->max_score }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="modal_feedback" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">التعليق</label>
                    <textarea name="feedback" id="modal_feedback" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white"></textarea>
                </div>
                <div>
                    <label for="modal_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الحالة</label>
                    <select name="status" id="modal_status" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="submitted">قيد المراجعة</option>
                        <option value="graded">تم التقييم</option>
                        <option value="returned">تم الإرجاع</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeGradeModal()"
                        class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    إلغاء
                </button>
                <button type="submit"
                        class="px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors">
                    حفظ التقييم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openGradeModal(row) {
    var subId = row.getAttribute('data-sub-id');
    var score = row.getAttribute('data-score') || '';
    var feedback = row.getAttribute('data-feedback') || '';
    var status = row.getAttribute('data-status') || 'submitted';
    document.getElementById('modal_score').value = score;
    document.getElementById('modal_feedback').value = feedback;
    document.getElementById('modal_status').value = status;
    document.getElementById('gradeForm').action = '{{ route("admin.assignments.grade", [$assignment, "__ID__"]) }}'.replace('__ID__', subId);
    document.getElementById('gradeModal').classList.remove('hidden');
    document.getElementById('gradeModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeGradeModal() {
    document.getElementById('gradeModal').classList.add('hidden');
    document.getElementById('gradeModal').classList.remove('flex');
    document.body.style.overflow = '';
}
document.getElementById('gradeModal').addEventListener('click', function(e) {
    if (e.target === this) closeGradeModal();
});
</script>
@endpush

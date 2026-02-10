@extends('layouts.app')

@section('title', 'تفاصيل المجموعة')
@section('header', 'المجموعات')

@section('content')
<div class="space-y-6">
    <!-- معلومات المجموعة -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $group->name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $group->course->title ?? '' }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.groups.edit', $group) }}"
                       class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors shadow-md">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل
                    </a>
                    <a href="{{ route('admin.groups.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-right ml-2"></i>
                        رجوع
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">قائد المجموعة</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $group->leader->name ?? 'غير محدد' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">عدد الأعضاء</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">{{ $group->members->count() }} / {{ $group->max_members }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">الحالة</p>
                    <p class="mt-1">
                        @if($group->status == 'active')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">نشط</span>
                        @elseif($group->status == 'inactive')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">غير نشط</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">مؤرشف</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($group->description)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">الوصف</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $group->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- أعضاء المجموعة -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">أعضاء المجموعة ({{ $group->members->count() }})</h2>
                @if($group->members->count() < $group->max_members)
                <button type="button" onclick="openAddMemberModal()"
                        class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors shadow-md">
                    <i class="fas fa-user-plus ml-2"></i>
                    إضافة عضو
                </button>
                @endif
            </div>
        </div>

        <div class="p-6">
            @if($group->members->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الاسم</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">البريد</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الدور</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ الانضمام</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($group->members as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $member->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $member->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->role == 'leader')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">قائد</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">عضو</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $member->joined_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($member->role != 'leader')
                                <form action="{{ route('admin.groups.remove-member', [$group, $member]) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من إزالة هذا العضو؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="إزالة العضو">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 dark:text-gray-400 font-medium">لا يوجد أعضاء في هذه المجموعة</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">استخدم زر "إضافة عضو" لإضافة طلاب</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal لإضافة عضو -->
<div id="addMemberModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(0,0,0,0.5);">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-w-md w-full overflow-hidden" @click.stop>
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">إضافة عضو جديد</h3>
        </div>
        <form action="{{ route('admin.groups.add-member', $group) }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الطالب</label>
                <select name="user_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">اختر الطالب</option>
                    @foreach($availableStudents as $student)
                        @if(!$group->members->pluck('user_id')->contains($student->id))
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeAddMemberModal()"
                        class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    إلغاء
                </button>
                <button type="submit"
                        class="px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors">
                    إضافة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddMemberModal() {
    var modal = document.getElementById('addMemberModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeAddMemberModal() {
    var modal = document.getElementById('addMemberModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}
document.getElementById('addMemberModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddMemberModal();
});
</script>
@endsection

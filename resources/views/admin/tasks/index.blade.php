@extends('layouts.app')

@section('title', 'المهام')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">المهام</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة المهام الشخصية والمرتبطة بالكورسات</p>
        </div>
        <a href="{{ route('admin.tasks.create') }}" class="btn-primary">
            <i class="fas fa-plus ml-2"></i>
            إضافة مهمة جديدة
        </a>
    </div>

    <!-- الفلاتر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">البحث</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث في المهام..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الحالة</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الأولوية</label>
                <select name="priority" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">جميع الأولويات</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>عاجلة</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full btn-primary">
                    <i class="fas fa-search ml-2"></i>
                    بحث
                </button>
            </div>
        </form>
    </div>

    <!-- قائمة المهام -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">المهمة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">المستخدم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الأولوية</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاريخ الاستحقاق</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</div>
                            @if($task->description)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $task->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($task->priority == 'urgent')
                                <span class="badge badge-danger">عاجلة</span>
                            @elseif($task->priority == 'high')
                                <span class="badge badge-warning">عالية</span>
                            @elseif($task->priority == 'medium')
                                <span class="badge badge-primary">متوسطة</span>
                            @else
                                <span class="badge badge-secondary">منخفضة</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($task->status == 'completed')
                                <span class="badge badge-success">مكتملة</span>
                            @elseif($task->status == 'in_progress')
                                <span class="badge badge-primary">قيد التنفيذ</span>
                            @elseif($task->status == 'cancelled')
                                <span class="badge badge-danger">ملغاة</span>
                            @else
                                <span class="badge badge-warning">في الانتظار</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            @if($task->due_date)
                                {{ $task->due_date->format('Y-m-d') }}
                                @if($task->due_date->isPast() && $task->status != 'completed')
                                    <span class="text-red-600 dark:text-red-400 text-xs block">متأخرة</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.tasks.show', $task) }}" class="text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 mr-4">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-4">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">لا توجد مهام</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $tasks->links() }}
        </div>
        @endif
    </div>
</div>
@endsection


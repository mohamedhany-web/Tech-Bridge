@extends('layouts.app')

@section('title', 'المجموعات - Tech Bridge')
@section('header', 'المجموعات')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">المجموعات</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة مجموعات الطلاب في الكورسات</p>
            </div>
            <a href="{{ route('instructor.groups.create') }}" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus ml-2"></i>
                إنشاء مجموعة جديدة
            </a>
        </div>

        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-6">
            <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي المجموعات</div>
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
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">إجمالي الأعضاء</div>
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_members'] ?? 0 }}</div>
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
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشطة</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>معطلة</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>مؤرشفة</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البحث</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="البحث في المجموعات..."
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['course_id', 'status', 'search']))
                        <a href="{{ route('instructor.groups.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة المجموعات -->
    @if($groups->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($groups as $group)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $group->name }}</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($group->status == 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                            @elseif($group->status == 'inactive') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                            @else bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-200
                            @endif">
                            @if($group->status == 'active') نشطة
                            @elseif($group->status == 'inactive') معطلة
                            @else مؤرشفة
                            @endif
                        </span>
                    </div>
                    
                    @if($group->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $group->description }}</p>
                    @endif
                    
                    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-book text-sky-500 ml-2"></i>
                            <span>الكورس: {{ $group->course->title ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users text-purple-500 ml-2"></i>
                            <span>الأعضاء: {{ $group->members_count }} / {{ $group->max_members }}</span>
                        </div>
                        @if($group->leader)
                        <div class="flex items-center">
                            <i class="fas fa-crown text-yellow-500 ml-2"></i>
                            <span>القائد: {{ $group->leader->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3 bg-gray-50 dark:bg-gray-700">
                    <a href="{{ route('instructor.groups.show', $group) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-eye ml-2"></i>
                        عرض التفاصيل
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $groups->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد مجموعات</p>
                <p class="text-sm">لم يتم إنشاء أي مجموعات بعد</p>
                <a href="{{ route('instructor.groups.create') }}" class="mt-4 inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus ml-2"></i>
                    إنشاء مجموعة جديدة
                </a>
            </div>
        </div>
    @endif
</div>
@endsection


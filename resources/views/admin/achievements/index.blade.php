@extends('layouts.app')

@section('title', 'الإنجازات')
@section('header', 'الإنجازات')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">الإنجازات</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة إنجازات الطلاب</p>
            </div>
            <a href="{{ route('admin.achievements.create') }}" 
               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus mr-2"></i>
                إضافة إنجاز جديد
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي الإنجازات</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">النشطة</div>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['active'] ?? 0 }}</div>
        </div>
    </div>
    @endif

    <!-- قائمة الإنجازات -->
    @if(isset($achievements) && $achievements->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($achievements as $achievement)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    @if($achievement->icon)
                    <i class="{{ $achievement->icon }} text-3xl text-sky-600"></i>
                    @else
                    <i class="fas fa-medal text-3xl text-sky-600"></i>
                    @endif
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $achievement->name }}</h3>
                        <span class="text-xs text-gray-600 dark:text-gray-400">{{ $achievement->category ?? $achievement->type ?? '-' }}</span>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $achievement->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ $achievement->is_active ? 'نشط' : 'معطل' }}
                </span>
            </div>
            @if($achievement->description)
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($achievement->description, 100) }}</p>
            @endif
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <span class="text-gray-600 dark:text-gray-400">عدد الحاصلين:</span>
                    <span class="font-medium text-gray-900 dark:text-white mr-1">{{ $achievement->users_count ?? 0 }}</span>
                </div>
                @if($achievement->points_reward ?? $achievement->points)
                <div class="text-sm font-medium text-sky-600">
                    <i class="fas fa-star mr-1"></i>{{ $achievement->points_reward ?? $achievement->points }} نقاط
                </div>
                @endif
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.achievements.show', $achievement) }}" class="flex-1 text-center text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 text-sm font-medium py-2 px-4 bg-sky-50 dark:bg-sky-900/20 rounded-lg">عرض</a>
                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="flex-1 text-center text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 text-sm font-medium py-2 px-4 bg-gray-50 dark:bg-gray-700 rounded-lg">تعديل</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $achievements->links() }}
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
        <i class="fas fa-medal text-gray-400 text-6xl mb-4"></i>
        <p class="text-gray-600 dark:text-gray-400 text-lg">لا توجد إنجازات</p>
    </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'الشارات')
@section('header', 'الشارات')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">الشارات</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة شارات الطلاب</p>
            </div>
            <a href="{{ route('admin.badges.create') }}" 
               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus mr-2"></i>
                إضافة شارة جديدة
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي الشارات</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">النشطة</div>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['active'] ?? 0 }}</div>
        </div>
    </div>
    @endif

    <!-- قائمة الشارات -->
    @if(isset($badges) && $badges->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($badges as $badge)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow text-center">
            <div class="mb-4">
                @if($badge->icon)
                <i class="{{ $badge->icon }} text-5xl text-sky-600" style="color: {{ $badge->color ?? '#0ea5e9' }}"></i>
                @else
                <i class="fas fa-award text-5xl text-sky-600"></i>
                @endif
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $badge->name }}</h3>
            @if($badge->description)
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($badge->description, 60) }}</p>
            @endif
            <div class="space-y-2">
                <div class="text-sm">
                    <span class="text-gray-600 dark:text-gray-400">عدد الحاصلين:</span>
                    <span class="font-medium text-gray-900 dark:text-white mr-1">{{ $badge->users_count ?? 0 }}</span>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $badge->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ $badge->is_active ? 'نشط' : 'معطل' }}
                </span>
            </div>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.badges.show', $badge) }}" class="flex-1 text-center text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 text-sm font-medium py-2 px-4 bg-sky-50 dark:bg-sky-900/20 rounded-lg">عرض</a>
                <a href="{{ route('admin.badges.edit', $badge) }}" class="flex-1 text-center text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 text-sm font-medium py-2 px-4 bg-gray-50 dark:bg-gray-700 rounded-lg">تعديل</a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $badges->links() }}
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
        <i class="fas fa-award text-gray-400 text-6xl mb-4"></i>
        <p class="text-gray-600 dark:text-gray-400 text-lg">لا توجد شارات</p>
    </div>
    @endif
</div>
@endsection

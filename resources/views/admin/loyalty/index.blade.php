@extends('layouts.app')

@section('title', 'برامج الولاء')
@section('header', 'برامج الولاء')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">برامج الولاء</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">إدارة برامج نقاط الولاء</p>
            </div>
            <button onclick="document.getElementById('createProgramModal').classList.remove('hidden')" 
               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus mr-2"></i>
                إضافة برنامج جديد
            </button>
        </div>
    </div>

    <!-- الإحصائيات -->
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي البرامج</div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $stats['total'] ?? 0 }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">النشطة</div>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats['active'] ?? 0 }}</div>
        </div>
    </div>
    @endif

    <!-- قائمة البرامج -->
    @if(isset($programs) && $programs->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($programs as $program)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $program->name }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $program->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {{ $program->is_active ? 'نشط' : 'معطل' }}
                </span>
            </div>
            @if($program->description)
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($program->description, 100) }}</p>
            @endif
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">نقاط لكل شراء:</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $program->points_per_purchase ?? 0 }}</span>
                </div>
                @if($program->points_per_referral)
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">نقاط لكل إحالة:</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $program->points_per_referral }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">عدد المستخدمين:</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $program->users_count ?? 0 }}</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.loyalty.show', $program) }}" class="text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 text-sm font-medium">عرض التفاصيل</a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
        <i class="fas fa-star text-gray-400 text-6xl mb-4"></i>
        <p class="text-gray-600 dark:text-gray-400 text-lg">لا توجد برامج ولاء</p>
    </div>
    @endif
</div>
@endsection

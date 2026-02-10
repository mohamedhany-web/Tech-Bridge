@extends('layouts.app')

@section('title', 'تفاصيل الإنجاز')
@section('header', 'تفاصيل الإنجاز')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <a href="{{ route('student.achievements.index') }}" class="text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 mb-4 inline-block">
                <i class="fas fa-arrow-right mr-2"></i>رجوع إلى الإنجازات
            </a>
            <div class="flex items-center gap-4">
                @if($achievement->achievement && $achievement->achievement->icon)
                <i class="{{ $achievement->achievement->icon }} text-6xl text-yellow-600"></i>
                @else
                <i class="fas fa-trophy text-6xl text-yellow-600"></i>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $achievement->achievement->name ?? 'إنجاز' }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $achievement->achievement->category ?? $achievement->achievement->type ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if($achievement->achievement && $achievement->achievement->description)
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">الوصف</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ $achievement->achievement->description }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-6 border border-yellow-200 dark:border-yellow-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">تاريخ الحصول</div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $achievement->earned_at ? $achievement->earned_at->format('Y-m-d') : '-' }}</div>
            </div>
            @if($achievement->points_earned)
            <div class="bg-gradient-to-br from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 rounded-xl p-6 border border-sky-200 dark:border-sky-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">النقاط المكتسبة</div>
                <div class="text-xl font-bold text-sky-600 dark:text-sky-400">
                    <i class="fas fa-star mr-1"></i>{{ $achievement->points_earned }} نقاط
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


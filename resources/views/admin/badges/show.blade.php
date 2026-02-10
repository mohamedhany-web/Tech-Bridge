@extends('layouts.app')

@section('title', 'تفاصيل الشارة')
@section('header', 'تفاصيل الشارة')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-start mb-6">
            <div class="text-center flex-1">
                @if($badge->icon)
                <i class="{{ $badge->icon }} text-8xl mb-4" style="color: {{ $badge->color ?? '#0ea5e9' }}"></i>
                @else
                <i class="fas fa-award text-8xl text-sky-600 mb-4"></i>
                @endif
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $badge->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $badge->category ?? $badge->type ?? '-' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.badges.edit', $badge) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg font-medium transition-colors mr-2">
                    تعديل
                </a>
                <a href="{{ route('admin.badges.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    رجوع
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                @if($badge->description)
                <div class="mb-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">الوصف:</span>
                    <p class="font-medium text-gray-900 dark:text-white mt-1">{{ $badge->description }}</p>
                </div>
                @endif
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">الفئة:</span>
                        <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $badge->category ?? $badge->type ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">اللون:</span>
                        <span class="inline-flex items-center gap-2 mr-2">
                            <span class="w-6 h-6 rounded-full border border-gray-300" style="background-color: {{ $badge->color ?? '#0ea5e9' }}"></span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $badge->color ?? '#0ea5e9' }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">الإحصائيات</h3>
                <div class="space-y-3">
                    <div class="bg-gradient-to-br from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 rounded-xl p-4 border border-sky-200 dark:border-sky-800">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">عدد الحاصلين</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $badge->users_count ?? $badge->users->count() ?? 0 }}</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">الحالة</div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $badge->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $badge->is_active ? 'نشط' : 'معطل' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($badge->users && $badge->users->count() > 0)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">المستخدمون الحاصلون على هذه الشارة</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($badge->users->take(12) as $user)
                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-sky-100 dark:bg-sky-900 flex items-center justify-center">
                        <i class="fas fa-user text-sky-600 dark:text-sky-400"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ $user->pivot->earned_at->format('Y-m-d') ?? '-' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($badge->users->count() > 12)
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4">و {{ $badge->users->count() - 12 }} مستخدم آخر</p>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection


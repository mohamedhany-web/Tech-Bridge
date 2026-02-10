@extends('layouts.app')

@section('title', 'إدارة الصلاحيات')
@section('header', 'إدارة الصلاحيات')

@section('content')
@php
    $translations = [
        'إدارة المحاسبة' => 'إدارة المحاسبة (فواتير، مدفوعات، تقسيط، محافظ)',
        'إدارة النظام' => 'إدارة النظام (مستخدمون، إعدادات، نشاطات)',
    ];
@endphp
<div class="space-y-6">
    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الصلاحيات</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $permissions->flatten()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-key text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">المجموعات</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $permissions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">الأدوار المرتبطة</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $permissions->flatten()->sum('roles_count') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tag text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الصلاحيات -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الصلاحيات</h3>
                <a href="{{ route('admin.permissions.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
            إضافة صلاحية جديدة
        </a>
    </div>
            </div>
        <div class="p-6">
            @if($permissions->count() > 0)
                <div class="space-y-6">
                    @foreach($permissions as $group => $groupPermissions)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <i class="fas fa-folder text-blue-600 dark:text-blue-400 mr-2"></i>
                                {{ $translations[$group] ?? ($group ?? 'عام') }}
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    ({{ $groupPermissions->count() }} صلاحية)
                                </span>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($groupPermissions as $permission)
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                                                    {{ $permission->display_name }}
                                                </h5>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                                    {{ $permission->name }}
                                                </p>
                                                @if($permission->description)
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                                        {{ $permission->description }}
                                                    </p>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                    {{ $permission->roles_count }} دور
                                                </span>
        </div>
                                            <div class="flex items-center gap-2 mr-3">
                                                <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" 
                                                   title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الصلاحية؟');">
                                @csrf
                                @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">لا توجد صلاحيات</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">ابدأ بإضافة الصلاحيات</p>
                    <a href="{{ route('admin.permissions.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        إضافة صلاحية جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

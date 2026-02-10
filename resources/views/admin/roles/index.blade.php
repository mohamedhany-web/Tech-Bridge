@extends('layouts.app')

@section('title', 'إدارة الأدوار - Tech Bridge')
@section('header', 'إدارة الأدوار')

@section('content')
@php
    $stats = [
        [
            'label' => 'إجمالي الأدوار',
            'value' => $roles->count(),
            'icon' => 'fas fa-user-tag',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
        ],
        [
            'label' => 'أدوار النظام',
            'value' => $roles->where('is_system', true)->count(),
            'icon' => 'fas fa-shield-alt',
            'color' => 'text-amber-500 bg-amber-100/70 dark:text-amber-300 dark:bg-amber-500/10',
        ],
        [
            'label' => 'إجمالي الصلاحيات',
            'value' => $roles->sum(fn($r) => $r->permissions->count()),
            'icon' => 'fas fa-key',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
        ],
        [
            'label' => 'مستخدمون مرتبطون',
            'value' => $roles->sum(fn($r) => $r->users->count()),
            'icon' => 'fas fa-users',
            'color' => 'text-purple-500 bg-purple-100/70 dark:text-purple-300 dark:bg-purple-500/10',
        ],
    ];
@endphp

<div class="space-y-8">
    {{-- الهيدر والزر --}}
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">مركز إدارة الأدوار</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">إدارة أدوار المستخدمين والصلاحيات المرتبطة بكل دور.</p>
            </div>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-sky-600 rounded-xl shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                <i class="fas fa-plus"></i>
                إضافة دور جديد
            </a>
        </div>

        {{-- إحصائيات سريعة --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                        <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stat['value']) }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $stat['color'] }}">
                        <i class="{{ $stat['icon'] }} text-xl"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- جدول الأدوار --}}
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-4 sm:px-8 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">قائمة الأدوار</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">عرض وتعديل الأدوار والصلاحيات</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                <thead class="bg-slate-50 dark:bg-slate-900/70">
                    <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                        <th class="px-6 py-4">الاسم</th>
                        <th class="px-6 py-4">الاسم المعروض</th>
                        <th class="px-6 py-4">الوصف</th>
                        <th class="px-6 py-4">الصلاحيات</th>
                        <th class="px-6 py-4">المستخدمون</th>
                        <th class="px-6 py-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900/50">
                    @forelse($roles as $role)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $role->name }}</span>
                                @if($role->is_system)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-200 border border-sky-200 dark:border-sky-700">نظام</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $role->display_name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 max-w-xs truncate" title="{{ $role->description }}">{{ $role->description ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-semibold bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-200 border border-sky-200 dark:border-sky-700">
                                <i class="fas fa-key text-[10px]"></i>
                                {{ $role->permissions->count() }} صلاحية
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                <i class="fas fa-users text-[10px]"></i>
                                {{ $role->users->count() }} مستخدم
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-sky-100 hover:text-sky-600 dark:hover:bg-sky-500/20 dark:hover:text-sky-300 transition-colors" title="عرض">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-emerald-100 hover:text-emerald-600 dark:hover:bg-emerald-500/20 dark:hover:text-emerald-300 transition-colors" title="تعديل">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @if(!$role->is_system)
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-500/20 dark:hover:text-red-300 transition-colors" title="حذف">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800">
                                    <i class="fas fa-user-tag text-3xl text-slate-400"></i>
                                </div>
                                <div>
                                    <p class="text-slate-600 dark:text-slate-300 font-medium">لا توجد أدوار</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">قم بتشغيل السيدرز أو أضف دوراً جديداً</p>
                                </div>
                                <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-sky-600 rounded-xl hover:bg-sky-700">
                                    <i class="fas fa-plus"></i>
                                    إضافة دور
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

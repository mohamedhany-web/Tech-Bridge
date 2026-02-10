@extends('layouts.app')

@section('title', 'إحصائيات المستخدمين')
@section('header', 'إحصائيات المستخدمين')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إحصائيات المستخدمين</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحليل تفصيلي لنمو المستخدمين</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.statistics.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-arrow-right mr-2"></i>
                        العودة
                    </a>
                    <a href="{{ route('admin.statistics.courses') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <i class="fas fa-book mr-2"></i>
                        إحصائيات الكورسات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- توزيع المستخدمين حسب الدور -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">توزيع المستخدمين حسب الدور</h3>
        </div>
        <div class="p-6">
            @if($usersByRole->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($usersByRole as $role)
                        <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        @if($role->role === 'student')
                                            الطلاب
                                        @elseif($role->role === 'instructor' || $role->role === 'teacher')
                                            المدربين
                                        @elseif($role->role === 'admin' || $role->role === 'super_admin')
                                            الإدارة
                                        @else
                                            {{ $role->role }}
                                        @endif
                                    </h4>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($role->count) }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    @if($role->role === 'student') bg-green-100 dark:bg-green-900
                                    @elseif($role->role === 'instructor' || $role->role === 'teacher') bg-blue-100 dark:bg-blue-900
                                    @elseif($role->role === 'admin' || $role->role === 'super_admin') bg-purple-100 dark:bg-purple-900
                                    @else bg-gray-100 dark:bg-gray-700
                                    @endif">
                                    <i class="fas 
                                        @if($role->role === 'student') fa-user-graduate text-green-600 dark:text-green-400
                                        @elseif($role->role === 'instructor' || $role->role === 'teacher') fa-chalkboard-teacher text-blue-600 dark:text-blue-400
                                        @elseif($role->role === 'admin' || $role->role === 'super_admin') fa-user-shield text-purple-600 dark:text-purple-400
                                        @else fa-user text-gray-600 dark:text-gray-400
                                        @endif text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">لا توجد بيانات</p>
            @endif
        </div>
    </div>

    <!-- نمو المستخدمين حسب الشهر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">نمو المستخدمين حسب الشهر (آخر 12 شهر)</h3>
        </div>
        <div class="p-6">
            @if($usersPerMonth->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الشهر</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">السنة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عدد المستخدمين</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($usersPerMonth as $stat)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::create($stat->year, $stat->month, 1)->locale('ar')->format('F') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $stat->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($stat->count) }}</span>
                                        <div class="mr-4 w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($stat->count / max($usersPerMonth->max('count'), 1)) * 100, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">لا توجد بيانات</h3>
                    <p class="text-gray-500 dark:text-gray-400">لا توجد إحصائيات للمستخدمين متاحة</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection



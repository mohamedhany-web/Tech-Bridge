@extends('layouts.app')

@section('title', 'لوحة التحكم الإدارية')
@section('header', 'لوحة التحكم الإدارية')

@section('content')
<div class="space-y-6">
    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- إجمالي المستخدمين -->
        <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-slate-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إجمالي المستخدمين</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">{{ number_format($stats['total_users']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 dark:text-green-400 font-bold">+12%</span>
                    <span class="text-gray-600 dark:text-gray-400 mr-2 font-medium">من الشهر الماضي</span>
                </div>
            </div>
        </div>

        <!-- الطلاب -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-green-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">الطلاب</p>
                        <p class="text-4xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['total_students']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 dark:text-green-400 font-bold">+8%</span>
                    <span class="text-gray-600 dark:text-gray-400 mr-2 font-medium">من الشهر الماضي</span>
                </div>
            </div>
        </div>

        <!-- المدربين -->
        <div class="bg-gradient-to-br from-sky-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-indigo-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">المدربين</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-indigo-600 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-indigo-400 dark:to-slate-400">{{ number_format($stats['total_instructors'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-tie text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 dark:text-green-400 font-bold">+5%</span>
                    <span class="text-gray-600 dark:text-gray-400 mr-2 font-medium">من الشهر الماضي</span>
                </div>
            </div>
        </div>

        <!-- الكورسات -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-amber-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">الكورسات</p>
                        <p class="text-4xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['total_courses']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 dark:text-green-400 font-bold">+15%</span>
                    <span class="text-gray-600 dark:text-gray-400 mr-2 font-medium">من الشهر الماضي</span>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات مالية -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <!-- إجمالي الإيرادات -->
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-emerald-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-100/50 to-green-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إجمالي الإيرادات</p>
                        <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($stats['total_revenue'] ?? 0, 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- إيرادات الشهر -->
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-blue-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-cyan-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">إيرادات الشهر</p>
                        <p class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ number_format($stats['monthly_revenue'] ?? 0, 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- الفواتير المعلقة -->
        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-yellow-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">فواتير معلقة</p>
                        <p class="text-3xl font-black text-yellow-600 dark:text-yellow-400">{{ number_format($stats['pending_invoices'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-invoice text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- التسجيلات النشطة -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-purple-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-pink-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">التسجيلات النشطة</p>
                        <p class="text-3xl font-black text-purple-600 dark:text-purple-400">{{ number_format($stats['total_enrollments'] ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- رصيد المحافظ -->
    @if(isset($stats['wallets']) && $stats['wallets']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700 mt-6">
        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-wallet text-sky-600 dark:text-sky-400"></i>
            رصيد المحافظ الإلكترونية
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stats['wallets'] as $wallet)
            <div class="bg-gradient-to-br from-sky-50 to-blue-50 dark:from-gray-700 dark:to-gray-900 rounded-xl p-4 border border-sky-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $wallet->name ?? 'محفظة ' . $wallet->type_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $wallet->type_name }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-wallet text-white text-sm"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">الرصيد:</span>
                    <span class="text-2xl font-black text-sky-600 dark:text-sky-400">{{ number_format($wallet->balance, 2) }} ج.م</span>
                </div>
                @if($wallet->account_number)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">رقم الحساب: {{ $wallet->account_number }}</p>
                @endif
            </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">إجمالي رصيد المحافظ:</span>
                <span class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($stats['total_wallet_balance'] ?? 0, 2) }} ج.م</span>
            </div>
        </div>
    </div>
    @endif

    <!-- الرسوم البيانية والتحليلات -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- نشاط المستخدمين -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700 card-hover-effect" x-data="{ view: 'weekly' }">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 -m-6 p-6 rounded-t-2xl">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">
                    <i class="fas fa-chart-line text-sky-600 dark:text-sky-400 ml-2"></i>
                    نشاط المستخدمين
                </h3>
                <div class="flex items-center gap-2">
                    <button @click="view = 'weekly'" 
                            :class="view === 'weekly' ? 'bg-gradient-to-r from-sky-500 to-sky-600 text-white shadow-md hover:shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:bg-gradient-to-r hover:from-sky-50 hover:to-slate-50 dark:hover:from-gray-700 dark:hover:to-gray-700'"
                            class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300">أسبوعي</button>
                    <button @click="view = 'monthly'" 
                            :class="view === 'monthly' ? 'bg-gradient-to-r from-sky-500 to-sky-600 text-white shadow-md hover:shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:bg-gradient-to-r hover:from-sky-50 hover:to-slate-50 dark:hover:from-gray-700 dark:hover:to-gray-700'"
                            class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300">شهري</button>
                </div>
            </div>
            
            <!-- عرض الأسبوعي -->
            <div x-show="view === 'weekly'" x-transition class="space-y-4">
                @if(isset($weeklyActivity) && $weeklyActivity->count() > 0)
                    <!-- إحصائيات سريعة -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gradient-to-br from-sky-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-sky-200 dark:border-gray-600">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">إجمالي النشاطات</div>
                            <div class="text-2xl font-bold text-sky-600 dark:text-sky-400">{{ number_format($weeklyActivity->sum('count')) }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-emerald-200 dark:border-gray-600">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">متوسط يومي</div>
                            <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($weeklyActivity->avg('count'), 1) }}</div>
                        </div>
                    </div>
                    
                    <!-- جدول البيانات -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">التاريخ</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">عدد النشاطات</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">النسبة</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $maxCount = $weeklyActivity->max('count') ?: 1;
                                @endphp
                                @foreach($weeklyActivity->reverse() as $activity)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($activity->count) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-sky-500 to-sky-600 h-2 rounded-full" style="width: {{ ($activity->count / $maxCount) * 100 }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 w-12 text-left">{{ number_format(($activity->count / $maxCount) * 100, 0) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-chart-line text-4xl mb-2"></i>
                            <p>لا توجد بيانات للنشاط الأسبوعي</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- عرض الشهري -->
            <div x-show="view === 'monthly'" x-transition class="space-y-4">
                @if(isset($monthlyActivity) && $monthlyActivity->count() > 0)
                    <!-- إحصائيات سريعة -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-purple-200 dark:border-gray-600">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">إجمالي النشاطات</div>
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($monthlyActivity->sum('count')) }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-pink-50 to-rose-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-pink-200 dark:border-gray-600">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">متوسط شهري</div>
                            <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ number_format($monthlyActivity->avg('count'), 1) }}</div>
                        </div>
                    </div>
                    
                    <!-- جدول البيانات -->
                    <div class="overflow-x-auto max-h-64 overflow-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">الشهر</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">السنة</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">عدد النشاطات</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">النسبة</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $maxMonthlyCount = $monthlyActivity->max('count') ?: 1;
                                @endphp
                                @foreach($monthlyActivity->reverse() as $activity)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::create($activity->year, $activity->month, 1)->locale('ar')->format('F') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                            {{ $activity->year }}
                                        </td>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($activity->count) }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-2 rounded-full" style="width: {{ ($activity->count / $maxMonthlyCount) * 100 }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 w-12 text-left">{{ number_format(($activity->count / $maxMonthlyCount) * 100, 0) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="h-64 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <div class="text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-chart-line text-4xl mb-2"></i>
                            <p>لا توجد بيانات للنشاط الشهري</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- توزيع المستخدمين -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="pb-4 mb-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 -m-6 p-6 rounded-t-2xl">
                <h3 class="text-xl font-black text-gray-900 dark:text-white">
                    <i class="fas fa-pie-chart text-sky-600 dark:text-sky-400 ml-2"></i>
                    توزيع المستخدمين
                </h3>
            </div>
            
            <div class="space-y-4">
                <!-- الطلاب -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700 dark:text-gray-300">الطلاب</span>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_students']) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ round(($stats['total_students'] / $stats['total_users']) * 100) }}%</p>
                    </div>
                </div>

                <!-- المدربين -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 bg-indigo-500 rounded-full"></div>
                        <span class="text-gray-700 dark:text-gray-300">المدربين</span>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_instructors'] ?? 0) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ round((($stats['total_instructors'] ?? 0) / max($stats['total_users'], 1)) * 100) }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- آخر المستخدمين والكورسات -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- آخر المستخدمين -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-users text-sky-600 dark:text-sky-400 ml-2"></i>
                        آخر المستخدمين
                    </h3>
                    <a href="#" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($recent_users as $user)
                    <div class="flex items-center gap-4 p-3 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-sky-100 dark:border-gray-600">
                        <div class="w-12 h-12 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg group-hover:scale-110 transition-transform duration-300">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->phone }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role === 'student') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($user->role === 'instructor') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300
                                @elseif($user->role === 'super_admin') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                @if($user->role === 'student') طالب
                                @elseif($user->role === 'instructor') مدرب
                                @elseif($user->role === 'super_admin') مدير عام
                                @else غير محدد @endif
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- آخر الكورسات -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-book text-sky-600 dark:text-sky-400 ml-2"></i>
                        آخر الكورسات
                    </h3>
                    <a href="#" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recent_courses as $course)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-sky-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-book text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $course->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ optional($course->academicSubject)->name ?? 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">بواسطة: {{ $course->teacher->name ?? 'غير محدد' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($course->status === 'published') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($course->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                @if($course->status === 'published') منشور
                                @elseif($course->status === 'draft') مسودة
                                @else مؤرشف @endif
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $course->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-book text-3xl mb-2"></i>
                        <p>لا توجد كورسات بعد</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- الفواتير والمدفوعات -->
    @if(isset($pending_invoices) || isset($recent_payments))
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- الفواتير المعلقة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-file-invoice text-yellow-600 dark:text-yellow-400 ml-2"></i>
                        الفواتير المعلقة
                    </h3>
                    <a href="#" class="text-sm font-semibold text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($pending_invoices ?? [] as $invoice)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-yellow-100 hover:to-orange-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-yellow-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 via-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-invoice text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $invoice->invoice_number }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->user->name ?? 'غير محدد' }}</p>
                            <p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400">{{ number_format($invoice->total_amount, 2) }} ج.م</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                معلق
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $invoice->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-file-invoice text-4xl mb-2"></i>
                        <p>لا توجد فواتير معلقة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- المدفوعات الأخيرة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-money-bill-wave text-emerald-600 dark:text-emerald-400 ml-2"></i>
                        المدفوعات الأخيرة
                    </h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recent_payments ?? [] as $payment)
                    <div class="flex items-start gap-4 p-3 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-emerald-100 hover:to-green-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 card-hover-effect group border border-emerald-100 dark:border-gray-600">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 via-green-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-money-bill-wave text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $payment->payment_number }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->user->name ?? 'غير محدد' }}</p>
                            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($payment->amount, 2) }} ج.م</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                مكتمل
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $payment->paid_at ? $payment->paid_at->diffForHumans() : $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-money-bill-wave text-4xl mb-2"></i>
                        <p>لا توجد مدفوعات</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- روابط سريعة -->
    <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 card-hover-effect mt-6">
        <div class="pb-4 mb-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-black text-gray-900 dark:text-white">
                <i class="fas fa-bolt text-sky-600 dark:text-sky-400 ml-2"></i>
                إجراءات سريعة
            </h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse(($quickActions ?? []) as $action)
                <a href="{{ $action['route'] }}"
                   class="flex flex-col items-center p-6 bg-gradient-to-br {{ $action['background'] }} dark:from-gray-700 dark:to-gray-800 rounded-xl hover:shadow-xl transition-all duration-300 card-hover-effect border border-white/50 dark:border-gray-600 shadow-md group">
                    <div class="w-16 h-16 bg-gradient-to-br {{ $action['icon_background'] }} rounded-xl flex items-center justify-center shadow-lg mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $action['icon'] }} text-white text-2xl"></i>
                    </div>
                    <div class="text-center space-y-2">
                        <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $action['title'] }}</span>
                        <span class="text-2xl font-black text-gray-900 dark:text-gray-100">{{ number_format($action['count']) }}</span>
                        <span class="block text-xs text-gray-600 dark:text-gray-300">{{ $action['meta'] }}</span>
                        <span class="inline-flex items-center justify-center gap-2 text-xs font-semibold text-sky-600 dark:text-sky-300 group-hover:text-sky-700 dark:group-hover:text-sky-200">
                            {{ $action['cta'] }}
                            <i class="fas fa-arrow-left text-[10px]"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400 text-sm py-4">
                    لا توجد بيانات للعرض حالياً.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

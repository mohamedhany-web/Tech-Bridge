@extends('layouts.app')

@section('title', 'التقارير المحاسبية - Tech Bridge')
@section('header', 'التقارير المحاسبية')

@section('content')
<div class="space-y-10">
    <!-- فلترة الفترة الزمنية -->
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white">التقارير المحاسبية</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">تقارير شاملة عن جميع العمليات المالية</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'all'])) }}" 
                       class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:focus:ring-offset-slate-900">
                        <i class="fas fa-file-excel"></i>
                        تصدير شامل
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-download"></i>
                            تصدير محدد
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute left-0 mt-2 w-56 rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 z-50">
                            <div class="p-2 space-y-1">
                                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'summary'])) }}" 
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                    <i class="fas fa-chart-pie w-4"></i>
                                    الملخص المالي
                                </a>
                                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'invoices'])) }}" 
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                    <i class="fas fa-file-invoice w-4"></i>
                                    الفواتير
                                </a>
                                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'payments'])) }}" 
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                    <i class="fas fa-money-bill-wave w-4"></i>
                                    المدفوعات
                                </a>
                                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'transactions'])) }}" 
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                    <i class="fas fa-exchange-alt w-4"></i>
                                    المعاملات
                                </a>
                                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'expenses'])) }}" 
                                   class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg">
                                    <i class="fas fa-receipt w-4"></i>
                                    المصروفات
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.accounting.reports') }}" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الفترة الزمنية</label>
                        <select name="period" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400" onchange="this.form.submit()">
                            <option value="day" {{ $period == 'day' ? 'selected' : '' }}>اليوم</option>
                            <option value="week" {{ $period == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                            <option value="month" {{ $period == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                            <option value="year" {{ $period == 'year' ? 'selected' : '' }}>هذه السنة</option>
                            <option value="all" {{ $period == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>مخصص</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">من تاريخ</label>
                        <input type="date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">إلى تاريخ</label>
                        <input type="date" name="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400" />
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-filter"></i>
                            تطبيق الفلترة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- الإحصائيات الرئيسية -->
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">ملخص مالي شامل</h2>
            <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">من {{ $startDate->format('Y-m-d') }} إلى {{ $endDate->format('Y-m-d') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            <!-- إجمالي الإيرادات -->
            <div class="rounded-2xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">إجمالي الإيرادات</p>
                        <p class="mt-3 text-3xl font-black text-emerald-700 dark:text-emerald-300">{{ number_format($stats['total_revenue'], 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-arrow-down text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- إجمالي المصروفات -->
            <div class="rounded-2xl border border-rose-200 dark:border-rose-800 bg-gradient-to-br from-rose-50 to-red-50 dark:from-rose-900/20 dark:to-red-900/20 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-rose-600 dark:text-rose-400">إجمالي المصروفات</p>
                        <p class="mt-3 text-3xl font-black text-rose-700 dark:text-rose-300">{{ number_format($stats['total_expenses'], 2) }} ج.م</p>
                    </div>
                    <div class="w-14 h-14 bg-rose-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-arrow-up text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- الربح الصافي -->
            <div class="rounded-2xl border border-sky-200 dark:border-sky-800 bg-gradient-to-br from-sky-50 to-blue-50 dark:from-sky-900/20 dark:to-blue-900/20 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-sky-600 dark:text-sky-400">الربح الصافي</p>
                        <p class="mt-3 text-3xl font-black {{ $stats['net_profit'] >= 0 ? 'text-sky-700 dark:text-sky-300' : 'text-rose-700 dark:text-rose-300' }}">
                            {{ number_format($stats['net_profit'], 2) }} ج.م
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-sky-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- نسبة الربحية -->
            <div class="rounded-2xl border border-purple-200 dark:border-purple-800 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-purple-600 dark:text-purple-400">نسبة الربحية</p>
                        <p class="mt-3 text-3xl font-black text-purple-700 dark:text-purple-300">
                            @if($stats['total_revenue'] > 0)
                                {{ number_format(($stats['net_profit'] / $stats['total_revenue']) * 100, 2) }}%
                            @else
                                0%
                            @endif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-percentage text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- الإحصائيات التفصيلية -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- الفواتير -->
        <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">الفواتير</h3>
            </div>
            <div class="p-5 sm:p-8 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-sm text-slate-600 dark:text-slate-400">إجمالي الفواتير</span>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ number_format($stats['total_invoices']) }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-sm text-slate-600 dark:text-slate-400">مدفوعة</span>
                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['paid_invoices']) }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-slate-600 dark:text-slate-400">معلقة</span>
                    <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_invoices']) }}</span>
                </div>
            </div>
        </section>

        <!-- المدفوعات -->
        <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">المدفوعات</h3>
            </div>
            <div class="p-5 sm:p-8 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800">
                    <span class="text-sm text-slate-600 dark:text-slate-400">إجمالي المدفوعات</span>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ number_format($stats['total_payments']) }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-slate-600 dark:text-slate-400">مكتملة</span>
                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['completed_payments']) }}</span>
                </div>
            </div>
        </section>

        <!-- المعاملات -->
        <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">المعاملات</h3>
            </div>
            <div class="p-5 sm:p-8 space-y-4">
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-slate-600 dark:text-slate-400">إجمالي المعاملات</span>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ number_format($stats['total_transactions']) }}</span>
                </div>
            </div>
        </section>
    </div>

    <!-- تقارير الإيرادات -->
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">تفاصيل الإيرادات</h3>
        </div>
        <div class="p-5 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- الإيرادات من المدفوعات -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">حسب طريقة الدفع</h4>
                    <div class="space-y-3">
                        @forelse($revenueReports['from_payments'] as $item)
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $item->payment_method }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->count }} دفعة</p>
                            </div>
                            <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($item->total, 2) }} ج.م</p>
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">لا توجد بيانات</p>
                        @endforelse
                    </div>
                </div>

                <!-- الإيرادات من المعاملات -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">حسب الفئة</h4>
                    <div class="space-y-3">
                        @forelse($revenueReports['from_transactions'] as $item)
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $item->category ?? 'غير محدد' }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->count }} معاملة</p>
                            </div>
                            <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($item->total, 2) }} ج.م</p>
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">لا توجد بيانات</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- تقارير المصروفات -->
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">تفاصيل المصروفات</h3>
        </div>
        <div class="p-5 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- المصروفات من جدول المصروفات -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">حسب الفئة</h4>
                    <div class="space-y-3">
                        @forelse($expenseReports['from_expenses'] as $item)
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ \App\Models\Expense::categoryLabel($item->category) }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->count }} مصروف</p>
                            </div>
                            <p class="text-sm font-bold text-rose-600 dark:text-rose-400">{{ number_format($item->total, 2) }} ج.م</p>
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">لا توجد بيانات</p>
                        @endforelse
                    </div>
                </div>

                <!-- المصروفات من المعاملات -->
                <div>
                    <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">من المعاملات</h4>
                    <div class="space-y-3">
                        @forelse($expenseReports['from_transactions'] as $item)
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $item->category ?? 'غير محدد' }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item->count }} معاملة</p>
                            </div>
                            <p class="text-sm font-bold text-rose-600 dark:text-rose-400">{{ number_format($item->total, 2) }} ج.م</p>
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4">لا توجد بيانات</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- الرسم البياني الشهري -->
    @if(count($monthlyData['months']) > 0)
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">الإيرادات والمصروفات الشهرية</h3>
        </div>
        <div class="p-5 sm:p-8">
            <div class="space-y-4">
                @foreach($monthlyData['months'] as $index => $month)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($month . '-01')->format('Y-m') }}</span>
                        <div class="flex items-center gap-4 text-xs">
                            <span class="text-emerald-600 dark:text-emerald-400">إيرادات: {{ number_format($monthlyData['revenues'][$index], 2) }} ج.م</span>
                            <span class="text-rose-600 dark:text-rose-400">مصروفات: {{ number_format($monthlyData['expenses'][$index], 2) }} ج.م</span>
                            <span class="text-sky-600 dark:text-sky-400 font-semibold">صافي: {{ number_format($monthlyData['revenues'][$index] - $monthlyData['expenses'][$index], 2) }} ج.م</span>
                        </div>
                    </div>
                    <div class="relative h-8 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="absolute inset-0 flex">
                            <div class="bg-emerald-500" style="width: {{ $monthlyData['revenues'][$index] > 0 ? min(($monthlyData['revenues'][$index] / max($monthlyData['revenues'][$index], $monthlyData['expenses'][$index])) * 100, 100) : 0 }}%"></div>
                            <div class="bg-rose-500" style="width: {{ $monthlyData['expenses'][$index] > 0 ? min(($monthlyData['expenses'][$index] / max($monthlyData['revenues'][$index], $monthlyData['expenses'][$index])) * 100, 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- الجداول التفصيلية -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- الفواتير التفصيلية -->
        @if(isset($detailedInvoices) && $detailedInvoices->count() > 0)
        <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">آخر الفواتير</h3>
                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'invoices'])) }}" 
                   class="text-xs text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                    <i class="fas fa-download"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                    <thead class="bg-slate-50 dark:bg-slate-900/70">
                        <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                            <th class="px-4 py-3">رقم الفاتورة</th>
                            <th class="px-4 py-3">العميل</th>
                            <th class="px-4 py-3">المبلغ</th>
                            <th class="px-4 py-3">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                        @foreach($detailedInvoices->take(10) as $invoice)
                        <tr class="bg-white/70 dark:bg-slate-900/60 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.invoices.show', $invoice) }}" class="font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">
                                    {{ $invoice->invoice_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-900 dark:text-white">{{ $invoice->user->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">{{ number_format($invoice->total_amount, 2) }} ج.م</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                                    @if($invoice->status == 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @elseif($invoice->status == 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                    @endif">
                                    {{ $invoice->status == 'paid' ? 'مدفوعة' : ($invoice->status == 'pending' ? 'معلقة' : 'متأخرة') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($detailedInvoices->count() > 10)
            <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 text-center">
                <a href="{{ route('admin.invoices.index', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" 
                   class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                    عرض جميع الفواتير ({{ $detailedInvoices->count() }})
                </a>
            </div>
            @endif
        </section>
        @endif

        <!-- المدفوعات التفصيلية -->
        @if(isset($detailedPayments) && $detailedPayments->count() > 0)
        <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">آخر المدفوعات</h3>
                <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'payments'])) }}" 
                   class="text-xs text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                    <i class="fas fa-download"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                    <thead class="bg-slate-50 dark:bg-slate-900/70">
                        <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                            <th class="px-4 py-3">رقم الدفعة</th>
                            <th class="px-4 py-3">العميل</th>
                            <th class="px-4 py-3">المبلغ</th>
                            <th class="px-4 py-3">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                        @foreach($detailedPayments->take(10) as $payment)
                        <tr class="bg-white/70 dark:bg-slate-900/60 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">
                                    {{ $payment->payment_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-900 dark:text-white">{{ $payment->user->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-3 font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($payment->amount, 2) }} ج.م</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                                    @if($payment->status == 'completed') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @elseif($payment->status == 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                    @endif">
                                    {{ $payment->status == 'completed' ? 'مكتملة' : ($payment->status == 'pending' ? 'معلقة' : 'فاشلة') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($detailedPayments->count() > 10)
            <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 text-center">
                <a href="{{ route('admin.payments.index', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" 
                   class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                    عرض جميع المدفوعات ({{ $detailedPayments->count() }})
                </a>
            </div>
            @endif
        </section>
        @endif
    </div>

    <!-- المعاملات التفصيلية -->
    @if(isset($detailedTransactions) && $detailedTransactions->count() > 0)
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">آخر المعاملات المالية</h3>
            <a href="{{ route('admin.accounting.reports.export', array_merge(request()->all(), ['type' => 'transactions'])) }}" 
               class="text-xs text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                <i class="fas fa-download"></i>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                <thead class="bg-slate-50 dark:bg-slate-900/70">
                    <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                        <th class="px-4 py-3">رقم المعاملة</th>
                        <th class="px-4 py-3">العميل</th>
                        <th class="px-4 py-3">النوع</th>
                        <th class="px-4 py-3">المبلغ</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                    @foreach($detailedTransactions->take(15) as $transaction)
                    <tr class="bg-white/70 dark:bg-slate-900/60 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">
                                {{ $transaction->transaction_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-900 dark:text-white">{{ $transaction->user->name ?? 'غير معروف' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                                {{ $transaction->type == 'credit' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200' }}">
                                {{ $transaction->type == 'credit' ? 'إيراد' : 'مصروف' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold {{ $transaction->type == 'credit' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ number_format($transaction->amount, 2) }} ج.م
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold
                                @if($transaction->status == 'completed') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                @elseif($transaction->status == 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                @endif">
                                {{ $transaction->status == 'completed' ? 'مكتملة' : ($transaction->status == 'pending' ? 'معلقة' : 'فاشلة') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($detailedTransactions->count() > 15)
        <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 text-center">
            <a href="{{ route('admin.transactions.index', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" 
               class="text-sm text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300">
                عرض جميع المعاملات ({{ $detailedTransactions->count() }})
            </a>
        </div>
        @endif
    </section>
    @endif
</div>
@endsection


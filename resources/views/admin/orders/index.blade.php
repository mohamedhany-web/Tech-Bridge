@extends('layouts.app')

@section('title', 'إدارة الطلبات')
@section('header', 'إدارة الطلبات')

@section('content')
@php
    $statCards = [
        [
            'label' => 'إجمالي الطلبات',
            'value' => number_format($stats['total']),
            'icon' => 'fas fa-shopping-cart',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
            'description' => 'كل الطلبات المسجلة في المنصة',
        ],
        [
            'label' => 'طلبات قيد المراجعة',
            'value' => number_format($stats['pending']),
            'icon' => 'fas fa-hourglass-half',
            'color' => 'text-amber-500 bg-amber-100/70 dark:text-amber-300 dark:bg-amber-500/10',
            'description' => 'بإنتظار الموافقة أو الرفض',
        ],
        [
            'label' => 'طلبات مكتملة',
            'value' => number_format($stats['approved']),
            'icon' => 'fas fa-check-circle',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
            'description' => 'تمت الموافقة عليها بنجاح',
        ],
        [
            'label' => 'طلبات مرفوضة',
            'value' => number_format($stats['rejected']),
            'icon' => 'fas fa-times-circle',
            'color' => 'text-rose-500 bg-rose-100/70 dark:text-rose-300 dark:bg-rose-500/10',
            'description' => 'تم رفضها بعد المراجعة',
        ],
    ];

    $statusBadges = [
        'pending' => ['label' => 'في الانتظار', 'classes' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200'],
        'approved' => ['label' => 'مقبولة', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200'],
        'rejected' => ['label' => 'مرفوضة', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200'],
    ];
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">لوحة إدارة الطلبات</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">متابعة حركة التسجيلات والطلبات المالية عبر المسارات التعليمية.</p>
            </div>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <i class="fas fa-sliders-h"></i>
                Orders Control Center
            </span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            @foreach ($statCards as $card)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                            <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
                        </div>
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $card['color'] }}">
                            <i class="{{ $card['icon'] }} text-xl"></i>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-300">{{ $card['description'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 xl:grid-cols-3">
            <div class="border-b border-slate-200 dark:border-slate-800 px-5 py-6 sm:px-8 xl:border-l xl:border-b-0 xl:py-8 xl:px-10">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">البحث المتقدم</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">فلترة الطلبات حسب الحالة، طريقة الدفع، أو بيانات الطالب.</p>
                <form method="GET" class="mt-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البحث</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم الطالب أو البريد أو الهاتف" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الحالة</label>
                        <select name="status" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                            <option value="">جميع الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبولة</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">طريقة الدفع</label>
                        <select name="payment_method" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                            <option value="">جميع الطرق</option>
                            <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>نقدي</option>
                            <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>أخرى</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-filter"></i>
                            تطبيق الفلترة
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="xl:col-span-2">
                <div class="border-b border-slate-200 dark:border-slate-800 px-5 py-6 sm:px-8 lg:px-12 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">الطلبات الحديثة</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">آخر التسجيلات مرتبة من الأحدث إلى الأقدم.</p>
                    </div>
                    <span class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">{{ $orders->total() }} طلب</span>
                </div>
                <div class="p-5 sm:p-8 space-y-4">
                    @forelse ($orders as $order)
                        <div class="rounded-2xl border border-slate-200 bg-white/80 dark:border-slate-800 dark:bg-slate-900/70 p-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between hover:border-sky-300 hover:shadow-lg transition">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl
                                    @if($order->status === 'pending') bg-amber-100/80 text-amber-600 dark:bg-amber-500/15 dark:text-amber-200
                                    @elseif($order->status === 'approved') bg-emerald-100/80 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @else bg-rose-100/80 text-rose-600 dark:bg-rose-500/15 dark:text-rose-200
                                    @endif">
                                    <i class="{{ $order->status === 'approved' ? 'fas fa-check' : ($order->status === 'pending' ? 'fas fa-clock' : 'fas fa-times') }}"></i>
                                </span>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $order->user->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300">{{ $order->user->phone }}</p>
                                    </div>
                                    <div class="space-y-1 text-xs text-slate-500 dark:text-slate-300">
                                        <p class="font-medium text-slate-700 dark:text-slate-200">{{ $order->course->title }}</p>
                                        <p>{{ optional($order->course->academicYear)->name }} • {{ optional($order->course->academicSubject)->name }}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-300">
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-money-bill-wave"></i>
                                            {{ number_format($order->amount) }} ج.م
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-calendar"></i>
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-wallet"></i>
                                            {{ $order->payment_method_label }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-3">
                                @php $badge = $statusBadges[$order->status] ?? null; @endphp
                                @if($badge)
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $badge['classes'] }}">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ $badge['label'] }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-sky-500 dark:hover:text-sky-300" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($order->status === 'pending')
                                        <form method="POST" action="{{ route('admin.orders.approve', $order) }}" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
                                            @csrf
                                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-emerald-200 text-emerald-600 transition hover:bg-emerald-500 hover:text-white dark:border-emerald-500/30 dark:text-emerald-300" title="موافقة">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.orders.reject', $order) }}" onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟');">
                                            @csrf
                                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-rose-200 text-rose-600 transition hover:bg-rose-500 hover:text-white dark:border-rose-500/30 dark:text-rose-300" title="رفض">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-slate-200 bg-white/80 p-10 text-center text-slate-500 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                            </div>
                            لا توجد طلبات مطابقة لخيارات البحث الحالية.
                        </div>
                    @endforelse

                    @if ($orders->hasPages())
                        <div class="border-t border-slate-200 pt-6 dark:border-slate-800">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">تحليل الأداء</h3>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">مؤشرات سريعة لمراقبة جودة عمليات القبول والتحصيل.</p>
            </div>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <i class="fas fa-chart-bar"></i>
                Order Insights
            </span>
        </div>
        <div class="p-5 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 p-5 dark:border-emerald-500/30 dark:bg-emerald-500/10">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/60 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-200">
                        <i class="fas fa-percentage text-lg"></i>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600 dark:text-emerald-300">معدل القبول</p>
                        <p class="mt-2 text-xl font-bold text-emerald-700 dark:text-emerald-200">{{ $stats['total'] > 0 ? round(($stats['approved'] / $stats['total']) * 100, 1) : 0 }}%</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-sky-200 bg-sky-50/80 p-5 dark:border-sky-500/30 dark:bg-sky-500/10">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/60 text-sky-600 dark:bg-sky-500/20 dark:text-sky-200">
                        <i class="fas fa-calendar text-lg"></i>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-sky-600 dark:text-sky-300">طلبات هذا الشهر</p>
                        <p class="mt-2 text-xl font-bold text-sky-700 dark:text-sky-200">{{ \App\Models\Order::whereMonth('created_at', now()->month)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-purple-200 bg-purple-50/80 p-5 dark:border-purple-500/30 dark:bg-purple-500/10">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/60 text-purple-600 dark:bg-purple-500/20 dark:text-purple-200">
                        <i class="fas fa-coins text-lg"></i>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-purple-600 dark:text-purple-300">متوسط قيمة الطلب</p>
                        <p class="mt-2 text-xl font-bold text-purple-700 dark:text-purple-200">{{ $stats['total'] > 0 ? number_format(\App\Models\Order::avg('amount')) : 0 }} ج.م</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
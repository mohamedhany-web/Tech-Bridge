@extends('layouts.app')

@section('title', 'تفاصيل المعاملة المالية - Tech Bridge')
@section('header', 'تفاصيل المعاملة المالية')

@section('content')
@php
    $statusBadges = [
        'completed' => ['label' => 'مكتملة', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200'],
        'pending' => ['label' => 'معلقة', 'classes' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200'],
        'failed' => ['label' => 'فاشلة', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200'],
        'cancelled' => ['label' => 'ملغاة', 'classes' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200'],
    ];

    $typeBadges = [
        'income' => ['label' => 'إيراد', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200', 'icon' => 'fas fa-arrow-down'],
        'expense' => ['label' => 'مصروف', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200', 'icon' => 'fas fa-arrow-up'],
        'transfer' => ['label' => 'تحويل', 'classes' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200', 'icon' => 'fas fa-exchange-alt'],
        'refund' => ['label' => 'استرداد', 'classes' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-200', 'icon' => 'fas fa-undo'],
    ];
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">معاملة رقم</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">#{{ $transaction->transaction_number ?? $transaction->id }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">أُنشئت في {{ $transaction->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.transactions.edit', $transaction) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                    <i class="fas fa-edit"></i>
                    تعديل المعاملة
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                    <i class="fas fa-arrow-right"></i>
                    العودة
                </a>
            </div>
        </div>

        <div class="px-5 py-6 sm:px-8 lg:px-12 space-y-6">
            <!-- معلومات المعاملة الرئيسية -->
            <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">معلومات المعاملة</h3>
                    <div class="flex items-center gap-3">
                        @php
                            $typeMeta = $typeBadges[$transaction->type] ?? null;
                            $statusMeta = $statusBadges[$transaction->status] ?? null;
                        @endphp
                        @if($typeMeta)
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $typeMeta['classes'] }}">
                                <i class="{{ $typeMeta['icon'] }} text-[10px]"></i>
                                {{ $typeMeta['label'] }}
                            </span>
                        @endif
                        @if($statusMeta)
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['classes'] }}">
                                <span class="h-2 w-2 rounded-full bg-current"></span>
                                {{ $statusMeta['label'] }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">المبلغ</span>
                            <span class="text-2xl font-black {{ $transaction->type == 'income' ? 'text-emerald-600 dark:text-emerald-400' : ($transaction->type == 'expense' ? 'text-rose-600 dark:text-rose-400' : 'text-slate-900 dark:text-white') }}">
                                {{ $transaction->type == 'expense' ? '-' : '+' }}{{ number_format($transaction->amount, 2) }} ج.م
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">العملة</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->currency ?? 'EGP' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">الفئة</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->category ?? 'غير محدد' }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">تاريخ الإنشاء</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">آخر تحديث</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                        @if($transaction->createdBy)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-sm text-slate-500 dark:text-slate-400">أنشأها</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->createdBy->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- معلومات العميل -->
            @if($transaction->user)
            <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-6 dark:border-slate-800 dark:bg-slate-900/60">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">بيانات العميل</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex justify-between gap-6">
                        <dt class="text-slate-500 dark:text-slate-400">الاسم</dt>
                        <dd class="font-semibold text-slate-900 dark:text-white">{{ $transaction->user->name ?? 'غير معروف' }}</dd>
                    </div>
                    <div class="flex justify-between gap-6">
                        <dt class="text-slate-500 dark:text-slate-400">رقم الهاتف</dt>
                        <dd class="font-semibold text-slate-900 dark:text-white">{{ $transaction->user->phone ?? '—' }}</dd>
                    </div>
                    @if($transaction->user->email)
                    <div class="flex justify-between gap-6">
                        <dt class="text-slate-500 dark:text-slate-400">البريد الإلكتروني</dt>
                        <dd class="font-semibold text-slate-900 dark:text-white">{{ $transaction->user->email }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between gap-6">
                        <dt class="text-slate-500 dark:text-slate-400">الدور</dt>
                        <dd class="font-semibold text-slate-900 dark:text-white">
                            @if($transaction->user->role == 'student') طالب
                            @elseif($transaction->user->role == 'instructor') مدرب
                            @elseif($transaction->user->role == 'admin') إداري
                            @else {{ $transaction->user->role }}
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            @endif

            <!-- الروابط المرتبطة -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($transaction->payment)
                <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">الدفعة المرتبطة</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">رقم الدفعة</span>
                            <a href="{{ route('admin.payments.show', $transaction->payment) }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                                {{ $transaction->payment->payment_number }}
                                <i class="fas fa-external-link-alt text-xs mr-1"></i>
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">المبلغ</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ number_format($transaction->payment->amount, 2) }} ج.م</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">طريقة الدفع</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $transaction->payment->payment_method ?? '—' }}</span>
                        </div>
                    </div>
                </div>
                @endif

                @if($transaction->invoice)
                <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">الفاتورة المرتبطة</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">رقم الفاتورة</span>
                            <a href="{{ route('admin.invoices.show', $transaction->invoice) }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">
                                {{ $transaction->invoice->invoice_number }}
                                <i class="fas fa-external-link-alt text-xs mr-1"></i>
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">المبلغ الإجمالي</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ number_format($transaction->invoice->total_amount, 2) }} ج.م</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">الحالة</span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                @if($transaction->invoice->status == 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                @elseif($transaction->invoice->status == 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                @endif">
                                {{ $transaction->invoice->status == 'paid' ? 'مدفوعة' : ($transaction->invoice->status == 'pending' ? 'معلقة' : 'متأخرة') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- الوصف -->
            @if($transaction->description)
            <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-3">الوصف</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $transaction->description }}</p>
            </div>
            @endif

            <!-- البيانات الإضافية -->
            @if($transaction->metadata && is_array($transaction->metadata) && count($transaction->metadata) > 0)
            <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-4">البيانات الإضافية</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @foreach($transaction->metadata as $key => $value)
                    <div class="flex justify-between gap-6">
                        <dt class="text-slate-500 dark:text-slate-400">{{ $key }}</dt>
                        <dd class="font-semibold text-slate-900 dark:text-white">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection


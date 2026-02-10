@extends('layouts.app')

@section('title', 'إدارة المعاملات المالية - Tech Bridge')
@section('header', 'إدارة المعاملات المالية')

@section('content')
@php
    $statCards = [
        [
            'label' => 'إجمالي المعاملات',
            'value' => number_format($stats['total'] ?? 0),
            'icon' => 'fas fa-exchange-alt',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
            'description' => 'كل المعاملات المسجلة في المنصة',
        ],
        [
            'label' => 'معاملات مكتملة',
            'value' => number_format($stats['completed'] ?? 0),
            'icon' => 'fas fa-check-circle',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
            'description' => 'تمت بنجاح',
        ],
        [
            'label' => 'معاملات معلقة',
            'value' => number_format($stats['pending'] ?? 0),
            'icon' => 'fas fa-hourglass-half',
            'color' => 'text-amber-500 bg-amber-100/70 dark:text-amber-300 dark:bg-amber-500/10',
            'description' => 'في انتظار المعالجة',
        ],
        [
            'label' => 'إجمالي المبلغ',
            'value' => number_format($stats['total_amount'] ?? 0, 2) . ' ج.م',
            'icon' => 'fas fa-money-bill-wave',
            'color' => 'text-purple-500 bg-purple-100/70 dark:text-purple-300 dark:bg-purple-500/10',
            'description' => 'قيمة المعاملات المكتملة',
        ],
    ];

    $statusBadges = [
        'completed' => ['label' => 'مكتملة', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200'],
        'pending' => ['label' => 'معلقة', 'classes' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200'],
        'failed' => ['label' => 'فاشلة', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200'],
        'cancelled' => ['label' => 'ملغاة', 'classes' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200'],
    ];

    $typeBadges = [
        'credit' => ['label' => 'إيراد (دائن)', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200', 'icon' => 'fas fa-arrow-down'],
        'debit' => ['label' => 'مصروف (مدين)', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200', 'icon' => 'fas fa-arrow-up'],
        'income' => ['label' => 'إيراد', 'classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200', 'icon' => 'fas fa-arrow-down'],
        'expense' => ['label' => 'مصروف', 'classes' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200', 'icon' => 'fas fa-arrow-up'],
        'transfer' => ['label' => 'تحويل', 'classes' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200', 'icon' => 'fas fa-exchange-alt'],
        'refund' => ['label' => 'استرداد', 'classes' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-200', 'icon' => 'fas fa-undo'],
    ];
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">لوحة إدارة المعاملات المالية</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">متابعة جميع المعاملات المالية، الإيرادات، والمصروفات عبر المنصة.</p>
                <div class="mt-3 inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">
                    <i class="fas fa-info-circle"></i>
                    <span>المعاملات المالية تشمل جميع الحركات المالية: الإيرادات (credit)، المصروفات (debit)، التحويلات، والاستردادات</span>
                </div>
            </div>
            <a href="{{ route('admin.transactions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-sky-600 rounded-xl shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                <i class="fas fa-plus"></i>
                إضافة معاملة جديدة
            </a>
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
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البحث</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="رقم المعاملة، اسم العميل، أو رقم الهاتف" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">النوع</label>
                        <select name="type" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400">
                            <option value="">جميع الأنواع</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>إيراد</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>مصروف</option>
                            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>إيراد (دائن)</option>
                            <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>مصروف (مدين)</option>
                            <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>تحويل</option>
                            <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>استرداد</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الحالة</label>
                        <select name="status" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400">
                            <option value="">جميع الحالات</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>فاشلة</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-search"></i>
                            بحث متقدم
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                <thead class="bg-slate-50 dark:bg-slate-900/70">
                    <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                        <th class="px-6 py-4">رقم المعاملة</th>
                        <th class="px-6 py-4">العميل</th>
                        <th class="px-6 py-4">النوع</th>
                        <th class="px-6 py-4">المبلغ</th>
                        <th class="px-6 py-4">الحالة</th>
                        <th class="px-6 py-4 whitespace-nowrap">التاريخ</th>
                        <th class="px-6 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                    @forelse ($transactions as $transaction)
                        <tr class="bg-white/70 dark:bg-slate-900/60 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100/80 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300">
                                        <i class="fas fa-exchange-alt"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $transaction->transaction_number ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300">{{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $transaction->user->name ?? 'غير معروف' }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-300">{{ $transaction->user->phone ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $typeMeta = $typeBadges[$transaction->type] ?? null;
                                @endphp
                                @if($typeMeta)
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $typeMeta['classes'] }}">
                                        <i class="{{ $typeMeta['icon'] }} text-[10px]"></i>
                                        {{ $typeMeta['label'] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200">
                                        {{ $transaction->type }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold {{ in_array($transaction->type, ['credit', 'income']) ? 'text-emerald-600 dark:text-emerald-400' : (in_array($transaction->type, ['debit', 'expense']) ? 'text-rose-600 dark:text-rose-400' : 'text-slate-900 dark:text-white') }}">
                                    {{ in_array($transaction->type, ['debit', 'expense']) ? '-' : '+' }}{{ number_format($transaction->amount, 2) }} ج.م
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMeta = $statusBadges[$transaction->status] ?? null;
                                @endphp
                                @if($statusMeta)
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['classes'] }}">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ $statusMeta['label'] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ $transaction->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-slate-900 dark:text-white">{{ $transaction->created_at->format('Y-m-d') }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-300">{{ $transaction->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="inline-flex items-center gap-1 rounded-xl bg-sky-50 px-3 py-1.5 text-xs font-semibold text-sky-600 hover:bg-sky-100 dark:bg-sky-500/15 dark:text-sky-300 dark:hover:bg-sky-500/25 transition-colors">
                                        <i class="fas fa-eye"></i>
                                        عرض
                                    </a>
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600 hover:bg-amber-100 dark:bg-amber-500/15 dark:text-amber-300 dark:hover:bg-amber-500/25 transition-colors">
                                        <i class="fas fa-edit"></i>
                                        تعديل
                                    </a>
                                    <form method="POST" action="{{ route('admin.transactions.destroy', $transaction) }}" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه المعاملة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100 dark:bg-rose-500/15 dark:text-rose-300 dark:hover:bg-rose-500/25 transition-colors">
                                            <i class="fas fa-trash"></i>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800">
                                        <i class="fas fa-exchange-alt text-2xl text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">لا توجد معاملات</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300 mt-1">لم يتم تسجيل أي معاملات مالية بعد</p>
                                    </div>
                                    <a href="{{ route('admin.transactions.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-sky-700">
                                        <i class="fas fa-plus"></i>
                                        إضافة معاملة جديدة
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($transactions) && $transactions->hasPages())
        <div class="px-5 py-4 sm:px-8 border-t border-slate-200 dark:border-slate-800">
            {{ $transactions->links() }}
        </div>
        @endif
    </section>
</div>
@endsection

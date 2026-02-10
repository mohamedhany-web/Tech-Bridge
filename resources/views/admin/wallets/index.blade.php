@extends('layouts.app')

@section('title', 'المحافظ الذكية')

@section('content')
@php
    $recentWallet = ($recentWallets ?? collect())->first();
    $netMonth = ($currentMonthDeposits ?? 0) - ($currentMonthWithdrawals ?? 0);
@endphp
<div class="container mx-auto px-4 py-8 space-y-8">
    <div class="bg-gradient-to-br from-sky-500 via-sky-600 to-purple-600 rounded-3xl shadow-xl text-white p-8 relative overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-2/5 pointer-events-none opacity-20">
            <div class="w-full h-full bg-[url('https://www.transparenttextures.com/patterns/asfalt-dark.png')]"></div>
        </div>
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-3xl font-black tracking-tight">المحافظ الذكية</h1>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20">
                        <i class="fas fa-layer-group text-xs"></i>
                        إجمالي {{ $stats['total'] ?? 0 }} محفظة
                    </span>
                </div>
                <p class="mt-3 text-white/70 max-w-xl">
                    إدارة محافظ الدفع المربوطة بالطلاب مع متابعة الأرصدة، المعاملات، وأنواع القنوات المالية المختلفة.
                </p>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        نشطة: {{ $stats['active'] ?? 0 }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-rose-300"></span>
                        غير نشطة: {{ $stats['inactive'] ?? 0 }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <i class="fas fa-chart-line text-xs"></i>
                        المعاملات المسجلة: {{ number_format($totalTransactions ?? 0) }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.wallets.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-sky-700 font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-plus"></i>
                    إضافة محفظة جديدة
                </a>
                <a href="{{ $recentWallet ? route('admin.wallets.reports', $recentWallet) : '#' }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white/20 text-white font-semibold border border-white/30 hover:bg-white/30 transition-all {{ $recentWallet ? '' : 'opacity-60 pointer-events-none' }}">
                    <i class="fas fa-chart-pie"></i>
                    تقارير سريعة
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-sky-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-sky-500">إجمالي المحافظ</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total'] ?? 0) }}</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                    <i class="fas fa-wallet text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">يشمل كل المحافظ المربوطة بالطلاب.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-emerald-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-500">الرصيد المتاح</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total_balance'] ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="fas fa-coins text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">إجمالي الأرصدة الحالية بكل المحافظ.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-amber-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-amber-500">الرصيد المعلّق</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['pending_balance'] ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">
                    <i class="fas fa-hourglass-half text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">المبالغ المعلّقة أو قيد المراجعة.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-purple-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-purple-500">صافي تدفقات الشهر</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($netMonth, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">
                    <i class="fas fa-wave-square text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">الإيداعات ناقص السحوبات خلال {{ \Carbon\Carbon::now()->translatedFormat('F') }}.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">نشاط الشهر الحالي</h2>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300">
                        <i class="fas fa-calendar-alt text-xs"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 bg-emerald-50/80 dark:bg-emerald-900/10">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-emerald-600">الإيداعات</p>
                            <i class="fas fa-arrow-down text-emerald-500"></i>
                        </div>
                        <p class="mt-3 text-2xl font-black text-gray-900 dark:text-white">
                            {{ number_format($currentMonthDeposits ?? 0, 2) }} ج.م
                        </p>
                    </div>
                    <div class="p-4 rounded-2xl border border-rose-100 dark:border-rose-900/40 bg-rose-50/80 dark:bg-rose-900/10">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-rose-600">السحوبات</p>
                            <i class="fas fa-arrow-up text-rose-500"></i>
                        </div>
                        <p class="mt-3 text-2xl font-black text-gray-900 dark:text-white">
                            {{ number_format($currentMonthWithdrawals ?? 0, 2) }} ج.م
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-black text-gray-900 dark:text-white mb-4">توزيع حسب النوع</h2>
                <div class="space-y-4">
                    @forelse($typeDistribution as $type)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                    <i class="fas fa-signal"></i>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $type['label'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($type['wallets_count']) }} محفظة</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold text-sky-600 dark:text-sky-300">
                                {{ number_format($type['total_balance'], 2) }} ج.م
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد بيانات كافية حالياً.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-lg font-black text-gray-900 dark:text-white mb-4">أحدث المحافظ المضافة</h2>
            <div class="space-y-4">
                @forelse($recentWallets as $recent)
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $recent->name ?? 'محفظة بدون اسم' }}</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($recent->created_at)->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-sky-600 dark:text-sky-300 mt-1">{{ $recent->type_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $recent->user?->name ?? 'غير مرتبط' }} · {{ $recent->user?->phone ?? 'بدون رقم' }}
                        </p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ number_format($recent->balance, 2) }} ج.م
                            </span>
                            <a href="{{ route('admin.wallets.show', $recent) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200">
                                تفاصيل <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 dark:text-gray-400">لا توجد محافظ حديثة.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">جميع المحافظ</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">قائمة المحافظ المفعلة وغير المفعلة مع تفاصيل الاتصال والرصيد.</p>
            </div>
        </div>

        @if($wallets->count())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($wallets as $wallet)
                    <div class="rounded-3xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg hover:shadow-xl transition-all p-6 flex flex-col gap-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ $wallet->name ?? 'محفظة بدون اسم' }}</h3>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold 
                                        @if($wallet->is_active) bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-300
                                        @else bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-300
                                        @endif">
                                        <span class="w-2 h-2 rounded-full {{ $wallet->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ $wallet->is_active ? 'نشطة' : 'غير نشطة' }}
                                    </span>
                                </div>
                                <p class="text-xs text-sky-600 dark:text-sky-300 mt-2">{{ $wallet->type_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $wallet->user?->name ?? $wallet->account_holder ?? 'غير محدد' }} · {{ $wallet->user?->phone ?? 'بدون رقم' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                <i class="fas fa-wallet"></i>
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">الرصيد الحالي</p>
                                <p class="mt-1 text-base font-black text-gray-900 dark:text-white">{{ number_format($wallet->balance, 2) }} ج.م</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">الرصيد المعلّق</p>
                                <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ number_format($wallet->pending_balance ?? 0, 2) }} ج.م</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">رقم الحساب</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $wallet->account_number ?? 'غير متوفر' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">البنك / القناة</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $wallet->bank_name ?? 'غير محدد' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>أضيفت {{ optional($wallet->created_at)->diffForHumans() }}</span>
                            <span>آخر تحديث {{ optional($wallet->updated_at)->diffForHumans() }}</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('admin.wallets.show', $wallet) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 font-semibold hover:bg-sky-200 dark:hover:bg-sky-900/60 transition-all">
                                <i class="fas fa-eye"></i>
                                عرض التفاصيل
                            </a>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.wallets.transactions', $wallet) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all" title="سجل المعاملات">
                                    <i class="fas fa-receipt"></i>
                                </a>
                                <a href="{{ route('admin.wallets.reports', $wallet) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all" title="التقارير">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <a href="{{ route('admin.wallets.edit', $wallet) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $wallets->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-lg p-12 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p>لا توجد محافظ حتى الآن. يمكنك إنشاء محفظة جديدة من خلال الزر العلوي.</p>
            </div>
        @endif
    </div>
</div>
@endsection

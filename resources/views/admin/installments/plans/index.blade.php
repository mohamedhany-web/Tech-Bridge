@extends('layouts.app')

@section('title', 'خطط التقسيط - Tech Bridge')
@section('header', 'خطط التقسيط والاشتراكات')

@section('content')
@php
    $statusColors = [
        true => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        false => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
    ];
@endphp
<div class="container mx-auto px-4 py-8 space-y-8">
    <div class="bg-gradient-to-br from-sky-500 via-sky-600 to-purple-600 rounded-3xl shadow-xl text-white p-8 relative overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/3 pointer-events-none opacity-20">
            <div class="w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        </div>
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-3xl font-black tracking-tight">لوحة خطط التقسيط</h1>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20">
                        <i class="fas fa-layer-group text-xs"></i>
                        إجمالي {{ number_format($stats['total'] ?? 0) }} خطة
                    </span>
                </div>
                <p class="mt-3 text-white/70 max-w-2xl">
                    تعرّف على أداء خطط الدفع بالتقسيط، قيمها الإجمالية، وعدد الاتفاقيات المرتبطة بها مع متابعة الخطط التي تستخدم التجديد الآلي عند تسجيل الطلاب.
                </p>
                <div class="mt-4 inline-flex items-start gap-2 rounded-xl bg-white/20 px-4 py-2.5 text-xs font-semibold text-white">
                    <i class="fas fa-info-circle mt-0.5"></i>
                    <div>
                        <strong>الفرق بين خطة التقسيط واتفاقية السداد:</strong><br>
                        <span class="opacity-90">• <strong>خطة التقسيط (Installment Plan):</strong> قالب عام/نموذج يحدد شروط التقسيط (عدد الأقساط، الدورية، المبلغ، فترة السماح). يمكن ربطها بكورس معين أو تكون عامة لجميع الكورسات. مثال: "خطة 6 أقساط شهرية بقيمة 1000 ج.م"</span><br>
                        <span class="opacity-90">• <strong>اتفاقية السداد (Installment Agreement):</strong> اتفاقية فعلية ومحددة بين طالب معين والمنصة بناءً على خطة تقسيط. كل طالب له اتفاقية خاصة به مرتبطة بخطة تقسيط معينة. مثال: "اتفاقية الطالب أحمد على خطة 6 أقساط شهرية"</span>
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        نشطة: {{ number_format($stats['active'] ?? 0) }}
                    </span>
                    <span class="inline-flex items-center_gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-rose-300"></span>
                        غير نشطة: {{ number_format($stats['inactive'] ?? 0) }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <i class="fas fa-robot text-xs"></i>
                        توليد تلقائي: {{ number_format($stats['auto_generate'] ?? 0) }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.installments.plans.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-sky-700 font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-plus"></i>
                    إضافة خطة جديدة
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-sky-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-sky-500">إجمالي القيم الممولة</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total_amount'] ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                    <i class="fas fa-coins text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">إجمالي المبالغ التي تغطيها الخطط الحالية.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-emerald-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-500">إجمالي الدفعات المقدمة</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['total_deposit'] ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="fas fa-piggy-bank text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">قيمة الدفعات المقدمة المطلوبة عند الاشتراك.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-purple-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-purple-500">متوسط عدد الأقساط</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['average_installments'] ?? 0, 1) }}</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">
                    <i class="fas fa-chart-area text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">متوسط الأقساط لكل خطة تمويلية.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-amber-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-amber-500">خطط جديدة هذا الشهر</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($monthlyNew ?? 0) }}</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">
                    <i class="fas fa-calendar-plus text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">بقيمة {{ number_format($monthlyAmount ?? 0, 2) }} ج.م منذ بداية الشهر.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">توزيع حسب دورية السداد</h2>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300">
                        <i class="fas fa-clock text-xs"></i>
                        {{ $frequencyBreakdown->sum('plans_count') }} خطة
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse($frequencyBreakdown as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                    <i class="fas fa-sync-alt"></i>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $unitLabels[$item->frequency_unit] ?? $item->frequency_unit }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($item->plans_count) }} خطة</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold text-sky-600 dark:text-sky-300">{{ number_format($item->total_amount, 2) }} ج.م</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد بيانات للتوزيع حالياً.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <h2 class="text-lg font-black text-gray-900 dark:text-white mb-4">أعلى الخطط قيمة</h2>
                <div class="space-y-4">
                    @forelse($highValuePlans as $plan)
                        <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $plan->name }}</p>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($plan->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-sky-600 dark:text-sky-300 mt-1">{{ $plan->course->title ?? 'خطة عامة' }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($plan->total_amount ?? 0, 2) }} ج.م</span>
                                <a href="{{ route('admin.installments.plans.show', $plan) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800 dark:text-sky-300 dark:hover:text-sky-200">
                                    تفاصيل <i class="fas fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 dark:text-gray-400">لا توجد خطط مميزة بعد.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-lg font-black text-gray-900 dark:text-white mb-4">أحدث الخطط</h2>
            <div class="space-y-4">
                @forelse($recentPlans as $recent)
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $recent->name }}</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($recent->created_at)->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-sky-600 dark:text-sky-300 mt-1">{{ $recent->course->title ?? 'خطة عامة' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($recent->installments_count) }} دفعة · كل {{ $recent->frequency_interval }} {{ $unitLabels[$recent->frequency_unit] ?? $recent->frequency_unit }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($recent->total_amount ?? 0, 2) }} ج.م</span>
                            <a href="{{ route('admin.installments.plans.show', $recent) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800 dark:text-sky-300 dark:hover:text-sky-200">
                                عرض سريع <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 dark:text-gray-400">لا توجد خطط حديثة.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">قائمة خطط التقسيط</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">كل الخطط المتاحة مع تفاصيل المبالغ، الدورية، وعدد الاتفاقيات المرتبطة.</p>
            </div>
        </div>

        @if($plans->count())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    <div class="rounded-3xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg hover:shadow-xl transition-all p-6 flex flex-col gap-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$plan->is_active] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        <span class="w-2 h-2 rounded-full {{ $plan->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ $plan->is_active ? 'نشطة' : 'معطلة' }}
                                    </span>
                                    @if($plan->auto_generate_on_enrollment)
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                            <i class="fas fa-robot"></i>
                                            توليد تلقائي
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-sky-600 dark:text-sky-300 mt-2">{{ $plan->course->title ?? 'خطة عامة' }}</p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                <i class="fas fa-wallet"></i>
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">إجمالي المبلغ</p>
                                <p class="mt-1 text-base font-black text-gray-900 dark:text-white">{{ number_format($plan->total_amount ?? 0, 2) }} ج.م</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">دفعة مقدمة</p>
                                <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ number_format($plan->deposit_amount ?? 0, 2) }} ج.م</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">عدد الأقساط</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $plan->installments_count }} دفعة</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">الدورية</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">كل {{ $plan->frequency_interval }} {{ $unitLabels[$plan->frequency_unit] ?? $plan->frequency_unit }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>أضيفت {{ optional($plan->created_at)->diffForHumans() }}</span>
                            <span>اتفاقيات مرتبطة: {{ number_format($plan->agreements_count ?? 0) }}</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('admin.installments.plans.show', $plan) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 font-semibold hover:bg-sky-200 dark:hover:bg-sky-900/60 transition-all">
                                <i class="fas fa-eye"></i>
                                عرض التفاصيل
                            </a>
                            <a href="{{ route('admin.installments.plans.edit', $plan) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.installments.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخطة؟');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-rose-600 hover:bg-rose-50 dark:bg-gray-800 dark:text-rose-300 dark:hover:bg-rose-900/30 transition-all" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $plans->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-lg p-12 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-folder-open text-4xl mb-4"></i>
                <p class="font-semibold">لا توجد خطط تقسيط بعد</p>
                <p class="text-sm text-gray-400 mt-2">ابدأ بإنشاء أول خطة لتفعيل نظام الأقساط.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'الاشتراكات')
@section('header', 'الاشتراكات')

@section('content')
@php
    $statusColors = [
        'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
        'expired' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
        'cancelled' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
    ];
@endphp
<div class="container mx-auto px-4 py-8 space-y-8">
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gradient-to-br from-sky-500 via-sky-600 to-purple-600 rounded-3xl shadow-xl text-white p-8 relative overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/3 pointer-events-none opacity-20">
            <div class="w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        </div>
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-3xl font-black tracking-tight">لوحة الاشتراكات</h1>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/20">
                        <i class="fas fa-layer-group text-xs"></i>
                        إجمالي {{ number_format($stats['total'] ?? 0) }} اشتراك
                    </span>
                </div>
                <p class="mt-3 text-white/70 max-w-2xl">
                    راقب أداء الاشتراكات، الإيرادات المتجددة، وحالات التجديد التلقائي مع رؤية سريعة للحسابات التي أوشكت على الانتهاء.
                </p>
                <div class="mt-4 inline-flex items-start gap-2 rounded-xl bg-white/20 px-4 py-2.5 text-xs font-semibold text-white">
                    <i class="fas fa-info-circle mt-0.5"></i>
                    <div>
                        <strong>ما هي الاشتراكات (Subscriptions)؟</strong><br>
                        الاشتراكات هي خطط دفع متكررة (شهرية، ربع سنوية، سنوية، مدى الحياة) تتيح للمستخدمين الوصول للمنصة أو لخدمات معينة لفترة محددة. عند إنشاء اشتراك، يتم إنشاء فاتورة تلقائياً ويمكن تفعيل التجديد التلقائي. الاشتراكات مختلفة عن خطط التقسيط - الاشتراكات للوصول المتكرر، بينما خطط التقسيط لدفع مبلغ واحد على أقساط.
                    </div>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        نشطة: {{ number_format($stats['active'] ?? 0) }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-rose-300"></span>
                        منتهية: {{ number_format($stats['expired'] ?? 0) }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15">
                        <span class="w-2 h-2 rounded-full bg-amber-300"></span>
                        ملغاة: {{ number_format($stats['cancelled'] ?? 0) }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.subscriptions.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white text-sky-700 font-semibold shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-plus"></i>
                    إضافة اشتراك جديد
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-sky-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-sky-500">إيراد الاشتراكات النشطة</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['active_revenue'] ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                    <i class="fas fa-coins text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">قيمة الخطط المفعلة حالياً.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-emerald-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-500">تجديد تلقائي</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($stats['auto_renew'] ?? 0) }}</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                    <i class="fas fa-sync text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">اشتراكات محددة للتجديد التلقائي.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-purple-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-purple-500">اشتراكات هذا الشهر</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($monthlyNew ?? 0) }}</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">
                    <i class="fas fa-calendar-plus text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">تم تفعيلها منذ بداية الشهر.</p>
        </div>
        <div class="rounded-2xl bg-white dark:bg-gray-900 shadow-lg border border-amber-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-amber-500">إيراد الشهر الحالي</p>
                    <p class="mt-2 text-3xl font-black text-gray-900 dark:text-white">{{ number_format($monthlyRevenue ?? 0, 2) }} ج.م</p>
                </div>
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">
                    <i class="fas fa-chart-line text-lg"></i>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">إجمالي قيمة الاشتراكات الجديدة هذا الشهر.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">توزيع الاشتراكات حسب النوع</h2>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300">
                        <i class="fas fa-th-large text-xs"></i>
                        {{ $planDistribution->sum('subscriptions_count') }} إجمالي
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse($planDistribution as $distribution)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $distribution['label'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($distribution['subscriptions_count']) }} اشتراك</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold text-sky-600 dark:text-sky-300">{{ number_format($distribution['total_price'], 2) }} ج.م</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد بيانات كافية حالياً.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">اشتراكات يقترب انتهاءها</h2>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1 rounded-full bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">
                        <i class="fas fa-hourglass-half text-xs"></i>
                        خلال 30 يوم
                    </span>
                </div>
                <div class="space-y-4">
                    @forelse($expiringSoon as $upcoming)
                        <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $upcoming->plan_name }}</p>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($upcoming->end_date)->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-sky-600 dark:text-sky-300 mt-1">{{ $upcoming->user->name ?? 'غير معروف' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $upcoming->start_date?->format('Y-m-d') }} → {{ $upcoming->end_date?->format('Y-m-d') }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($upcoming->price, 2) }} ج.م</span>
                                <a href="{{ route('admin.subscriptions.show', $upcoming) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800 dark:text-sky-300 dark:hover:text-sky-200">
                                    تفاصيل <i class="fas fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500 dark:text-gray-400">لا توجد اشتراكات على وشك الانتهاء.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-lg font-black text-gray-900 dark:text-white mb-4">أحدث الاشتراكات</h2>
            <div class="space-y-4">
                @forelse($recentSubscriptions as $recent)
                    <div class="p-4 rounded-2xl border border-gray-100 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $recent->plan_name }}</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($recent->created_at)->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-sky-600 dark:text-sky-300 mt-1">{{ $recent->user->name ?? 'غير مرتبط' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ \App\Models\Subscription::typeLabel($recent->subscription_type) }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($recent->price, 2) }} ج.م</span>
                            <a href="{{ route('admin.subscriptions.show', $recent) }}" class="text-xs font-semibold text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200">
                                عرض سريع <i class="fas fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500 dark:text-gray-400">لا توجد اشتراكات حديثة.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">قائمة الاشتراكات</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">كل الاشتراكات الحالية مع تفاصيل المستخدم والحالة.</p>
            </div>
        </div>

        @if($subscriptions->count())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($subscriptions as $subscription)
                    <div class="rounded-3xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg hover:shadow-xl transition-all p-6 flex flex-col gap-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white">{{ $subscription->plan_name }}</h3>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$subscription->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        <span class="w-2 h-2 rounded-full {{ $subscription->status === 'active' ? 'bg-emerald-500' : ($subscription->status === 'expired' ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                        {{ $subscription->status === 'active' ? 'نشط' : ($subscription->status === 'expired' ? 'منتهي' : 'ملغي') }}
                                    </span>
                                </div>
                                <p class="text-xs text-sky-600 dark:text-sky-300 mt-2">{{ \App\Models\Subscription::typeLabel($subscription->subscription_type) }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subscription->user->name ?? 'غير معروف' }} · {{ $subscription->user->phone ?? 'بدون رقم' }}</p>
                            </div>
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">السعر</p>
                                <p class="mt-1 text-base font-black text-gray-900 dark:text-white">{{ number_format($subscription->price, 2) }} ج.م</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">دورة الفوترة</p>
                                <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">{{ \App\Models\Subscription::billingCycleLabel($subscription->billing_cycle) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">تاريخ البداية</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $subscription->start_date?->format('Y-m-d') ?? 'غير محدد' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">تاريخ الانتهاء</p>
                                <p class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $subscription->end_date?->format('Y-m-d') ?? 'غير محدد' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>أضيف {{ optional($subscription->created_at)->diffForHumans() }}</span>
                            <span>تحديث {{ optional($subscription->updated_at)->diffForHumans() }}</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 font-semibold hover:bg-sky-200 dark:hover:bg-sky-900/60 transition-all">
                                <i class="fas fa-eye"></i>
                                عرض التفاصيل
                            </a>
                            <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')" class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-gray-100 text-rose-600 hover:bg-rose-50 dark:bg-gray-800 dark:text-rose-300 dark:hover:bg-rose-900/30 transition-all" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $subscriptions->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-lg p-12 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p>لا توجد اشتراكات حتى الآن. يمكنك إنشاء اشتراك جديد من الزر العلوي.</p>
            </div>
        @endif
    </div>
</div>
@endsection

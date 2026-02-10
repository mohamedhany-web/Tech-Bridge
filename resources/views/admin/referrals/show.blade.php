@extends('layouts.app')

@section('title', 'تفاصيل الإحالة - Tech Bridge')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-user-friends text-sky-600 ml-3"></i>
                        تفاصيل الإحالة
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">معلومات تفصيلية عن الإحالة</p>
                </div>
                <a href="{{ route('admin.referrals.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-5 py-2.5 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Referrer Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-user-check text-sky-600"></i>
                    معلومات المحيل
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">الاسم</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referrer->name ?? 'غير معروف' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">رقم الهاتف</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referrer->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">البريد الإلكتروني</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referrer->email ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 dark:text-gray-400">كود الإحالة</span>
                        <span class="font-mono font-bold text-sky-600 dark:text-sky-400">{{ $referral->referrer->referral_code ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Referred Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-user-plus text-emerald-600"></i>
                    معلومات المحال
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">الاسم</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referred->name ?? 'غير معروف' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">رقم الهاتف</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referred->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">البريد الإلكتروني</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referred->email ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 dark:text-gray-400">تاريخ التسجيل</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referred->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 mt-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-purple-600"></i>
                تفاصيل الإحالة
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">البرنامج</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $referral->referralProgram->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">كود الإحالة</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $referral->referral_code ?? $referral->code ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">الحالة</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($referral->status == 'completed') bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300
                        @elseif($referral->status == 'pending') bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300
                        @else bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300
                        @endif">
                        @if($referral->status == 'completed') مكتملة
                        @elseif($referral->status == 'pending') قيد الانتظار
                        @else ملغاة
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">تاريخ الإحالة</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $referral->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($referral->completed_at)
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">تاريخ الإكمال</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $referral->completed_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">الخصم المطبق</span>
                    <span class="font-bold text-purple-600 dark:text-purple-400">{{ number_format($referral->discount_amount ?? 0, 2) }} ج.م</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">عدد مرات استخدام الخصم</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $referral->discount_used_count ?? 0 }} / {{ $referral->referralProgram->max_discount_uses_per_referred ?? 1 }}</span>
                </div>
                @if($referral->discount_expires_at)
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">انتهاء صلاحية الخصم</span>
                    <span class="font-medium text-gray-900 dark:text-white {{ $referral->discount_expires_at < now() ? 'text-red-600' : '' }}">
                        {{ $referral->discount_expires_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                @endif
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">المكافأة</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($referral->reward_amount ?? 0, 2) }} ج.م</span>
                </div>
                @if($referral->autoCoupon)
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">الكوبون التلقائي</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $referral->autoCoupon->code }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($referral->invoice)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 mt-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-file-invoice text-sky-600"></i>
                الفاتورة المرتبطة
            </h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400">رقم الفاتورة</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $referral->invoice->invoice_number }}</p>
                </div>
                <a href="{{ route('admin.invoices.show', $referral->invoice) }}" 
                   class="bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-eye"></i>
                    عرض الفاتورة
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
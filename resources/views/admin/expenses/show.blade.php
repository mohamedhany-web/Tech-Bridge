@extends('layouts.app')

@section('title', 'تفاصيل المصروف #' . $expense->expense_number)
@section('header', 'تفاصيل المصروف #' . $expense->expense_number)

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-receipt text-sky-600 ml-3"></i>
                    {{ __('تفاصيل المصروف') }} #{{ $expense->expense_number }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-xs"></i>
                    {{ $expense->created_at->format('d/m/Y - H:i') }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.expenses.edit', $expense) }}" 
                   class="bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    <span>{{ __('تعديل') }}</span>
                </a>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>{{ __('العودة') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- المحتوى الرئيسي -->
        <div class="lg:col-span-2 space-y-6">
            <!-- معلومات المصروف الأساسية -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-info-circle text-sky-600 dark:text-sky-400"></i>
                        {{ __('معلومات المصروف') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-heading text-sky-600 ml-1"></i>
                                {{ __('العنوان') }}
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $expense->title }}</div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-tags text-sky-600 ml-1"></i>
                                {{ __('الفئة') }}
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $expense->category_label ?? $expense->category }}</div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-money-bill-wave text-sky-600 ml-1"></i>
                                {{ __('المبلغ') }}
                            </label>
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($expense->amount, 2) }} {{ $expense->currency }}</div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-calendar-alt text-sky-600 ml-1"></i>
                                {{ __('تاريخ المصروف') }}
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $expense->expense_date->format('d/m/Y') }}</div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-credit-card text-sky-600 ml-1"></i>
                                {{ __('طريقة الدفع') }}
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">
                                @php
                                    $paymentMethods = [
                                        'cash' => 'نقدي',
                                        'bank_transfer' => 'تحويل بنكي',
                                        'card' => 'بطاقة',
                                        'wallet' => 'محفظة إلكترونية',
                                        'other' => 'أخرى',
                                    ];
                                @endphp
                                {{ $paymentMethods[$expense->payment_method] ?? $expense->payment_method }}
                            </div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-hashtag text-sky-600 ml-1"></i>
                                {{ __('رقم المرجع') }}
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $expense->reference_number ?? '—' }}</div>
                        </div>
                    </div>

                    @if($expense->description)
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                            <i class="fas fa-align-right text-sky-600 ml-1"></i>
                            {{ __('الوصف') }}
                        </label>
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $expense->description }}</p>
                    </div>
                    @endif

                    @if($expense->notes)
                    <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-800">
                        <label class="block text-xs font-semibold text-amber-600 dark:text-amber-400 mb-2 uppercase tracking-wide">
                            <i class="fas fa-sticky-note text-amber-600 ml-1"></i>
                            {{ __('ملاحظات') }}
                        </label>
                        <p class="text-sm text-amber-800 dark:text-amber-200 whitespace-pre-wrap">{{ $expense->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- حالة المصروف -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-check-circle text-sky-600 dark:text-sky-400"></i>
                        {{ __('حالة المصروف') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold
                            @if($expense->status === 'approved') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                            @elseif($expense->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                            @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                            @endif">
                            @if($expense->status === 'approved')
                                <i class="fas fa-check-circle ml-2"></i>
                                {{ __('موافق عليه') }}
                            @elseif($expense->status === 'pending')
                                <i class="fas fa-hourglass-half ml-2"></i>
                                {{ __('قيد الانتظار') }}
                            @else
                                <i class="fas fa-times-circle ml-2"></i>
                                {{ __('مرفوض') }}
                            @endif
                        </span>

                        @if($expense->approved_at)
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-user-check text-sky-600 ml-1"></i>
                            {{ __('تمت الموافقة بواسطة:') }} 
                            <span class="font-bold text-gray-900 dark:text-white">{{ $expense->approvedBy->name ?? 'غير محدد' }}</span>
                            <span class="mr-2">في {{ $expense->approved_at->format('d/m/Y - H:i') }}</span>
                        </div>
                        @endif

                        @if($expense->createdBy)
                        <div class="text-sm text-gray-600 dark:text-gray-400 mr-auto">
                            <i class="fas fa-user-plus text-sky-600 ml-1"></i>
                            {{ __('أنشأ بواسطة:') }} 
                            <span class="font-bold text-gray-900 dark:text-white">{{ $expense->createdBy->name ?? 'غير محدد' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- المرفق (صورة الإيصال) -->
            @if($expense->attachment)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-paperclip text-sky-600 dark:text-sky-400"></i>
                        {{ __('صورة الإيصال/الفاتورة') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="inline-block p-2 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                            @php
                                $imagePath = 'storage/' . $expense->attachment;
                                $fullPath = storage_path('app/public/' . $expense->attachment);
                                $imageExists = file_exists($fullPath);
                                $imageUrl = asset($imagePath);
                            @endphp
                            @if($imageExists)
                            <img src="{{ $imageUrl }}" 
                                 alt="مرفق المصروف" 
                                 class="max-w-full h-auto rounded-lg shadow-md cursor-pointer hover:shadow-xl transition-all duration-300"
                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';"
                                 onclick="openImageModal(this.src)">
                            <div class="hidden p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <p class="text-sm text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>الصورة غير متوفرة حالياً</span>
                                </p>
                            </div>
                            @else
                            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <p class="text-sm text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>المرفق غير موجود. محاولة العرض عبر Route بديل.</span>
                                </p>
                                <img src="{{ route('storage.fallback', ['path' => $expense->attachment]) }}" 
                                     alt="مرفق المصروف (بديل)" 
                                     class="max-w-full h-auto rounded-lg shadow-md cursor-pointer hover:shadow-xl transition-all duration-300 mt-4"
                                     onerror="this.onerror=null; this.style.display='none'; this.previousElementSibling.style.display='block';"
                                     onclick="openImageModal(this.src)">
                            </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4 flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            اضغط على الصورة لعرضها بحجم أكبر
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- الترابطات -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-link text-sky-600 dark:text-sky-400"></i>
                        {{ __('الترابطات') }}
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- المعاملة المالية المرتبطة -->
                    @if($expense->transaction)
                    <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-exchange-alt text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('المعاملة المالية المرتبطة') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">#{{ $expense->transaction->transaction_number ?? $expense->transaction->id }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.transactions.show', $expense->transaction) }}" 
                               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <span>{{ __('عرض') }}</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                        <div class="mt-3 pt-3 border-t border-emerald-200 dark:border-emerald-800">
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('المبلغ:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ number_format($expense->transaction->amount, 2) }} {{ $expense->transaction->currency }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('النوع:') }}</span>
                                    <span class="font-bold text-red-600 dark:text-red-400 mr-2">debit (مصروف)</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('الحالة:') }}</span>
                                    <span class="font-bold 
                                        @if($expense->transaction->status === 'completed') text-emerald-600 dark:text-emerald-400
                                        @elseif($expense->transaction->status === 'pending') text-amber-600 dark:text-amber-400
                                        @else text-red-600 dark:text-red-400
                                        @endif mr-2">
                                        {{ $expense->transaction->status === 'completed' ? 'مكتملة' : ($expense->transaction->status === 'pending' ? 'معلقة' : 'ملغاة') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('التاريخ:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ $expense->transaction->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- المحفظة المرتبطة -->
                    @if($expense->wallet)
                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-wallet text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('المحفظة المستخدمة') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $expense->wallet->name ?? $expense->wallet->type_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-blue-200 dark:border-blue-800">
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('النوع:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ $expense->wallet->type_name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('رقم الحساب:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ $expense->wallet->account_number }}</span>
                                </div>
                                @if($expense->wallet->bank_name)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('اسم البنك:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ $expense->wallet->bank_name }}</span>
                                </div>
                                @endif
                                @if($expense->wallet->account_holder)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('صاحب الحساب:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ $expense->wallet->account_holder }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- الفاتورة المرتبطة -->
                    @if($expense->invoice)
                    <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl border border-purple-200 dark:border-purple-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-file-invoice text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('الفاتورة المرتبطة') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">#{{ $expense->invoice->invoice_number }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.invoices.show', $expense->invoice) }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <span>{{ __('عرض') }}</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                        <div class="mt-3 pt-3 border-t border-purple-200 dark:border-purple-800">
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('المبلغ:') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white mr-2">{{ number_format($expense->invoice->total_amount, 2) }} {{ $expense->invoice->currency ?? 'EGP' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('الحالة:') }}</span>
                                    <span class="font-bold 
                                        @if($expense->invoice->status === 'paid') text-emerald-600 dark:text-emerald-400
                                        @elseif($expense->invoice->status === 'pending') text-amber-600 dark:text-amber-400
                                        @else text-red-600 dark:text-red-400
                                        @endif mr-2">
                                        {{ $expense->invoice->status === 'paid' ? 'مدفوعة' : ($expense->invoice->status === 'pending' ? 'معلقة' : 'متأخرة') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!$expense->transaction && !$expense->wallet && !$expense->invoice)
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle ml-2"></i>
                            {{ __('لا توجد ترابطات مرتبطة بهذا المصروف') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="space-y-6">
            <!-- معلومات سريعة -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-chart-line text-sky-600 dark:text-sky-400"></i>
                        {{ __('معلومات سريعة') }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('رقم المصروف') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">#{{ $expense->expense_number }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('تاريخ الإنشاء') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $expense->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('آخر تحديث') }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $expense->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- الإجراءات -->
            @if($expense->status === 'pending')
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-cog text-sky-600 dark:text-sky-400"></i>
                        {{ __('الإجراءات') }}
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <form action="{{ route('admin.expenses.approve', $expense) }}" method="POST" class="inline-block w-full" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا المصروف؟ سيتم خصم المبلغ من المحفظة إذا كانت موجودة.');">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gradient-to-l from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white px-4 py-3 rounded-xl font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>{{ __('الموافقة على المصروف') }}</span>
                        </button>
                    </form>
                    <form action="{{ route('admin.expenses.reject', $expense) }}" method="POST" class="inline-block w-full" onsubmit="return confirm('هل أنت متأكد من رفض هذا المصروف؟');">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gradient-to-l from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-4 py-3 rounded-xl font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            <span>{{ __('رفض المصروف') }}</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal لعرض الصورة بحجم أكبر -->
<div id="imageModal" class="hidden fixed inset-0 z-50 overflow-y-auto" onclick="closeImageModal()">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" onclick="closeImageModal()"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-4xl w-full p-4">
            <button onclick="closeImageModal()" class="absolute top-4 left-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img id="modalImage" src="" alt="صورة مكبرة" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>

@push('scripts')
<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
@endpush
@endsection


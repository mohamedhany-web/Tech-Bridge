@extends('layouts.app')

@section('title', 'تفاصيل الفاتورة')
@section('header', 'تفاصيل الفاتورة')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <a href="{{ route('student.invoices.index') }}" class="text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 mb-4 inline-block">
                <i class="fas fa-arrow-right mr-2"></i>رجوع إلى الفواتير
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">فاتورة #{{ $invoice->invoice_number }}</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">معلومات الفاتورة</h3>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600 dark:text-gray-400">النوع:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $invoice->type }}</span></div>
                    <div><span class="text-gray-600 dark:text-gray-400">الحالة:</span> 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($invoice->status == 'paid') bg-green-100 text-green-800
                            @elseif($invoice->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif mr-2">
                            {{ $invoice->status == 'paid' ? 'مدفوعة' : ($invoice->status == 'pending' ? 'معلقة' : 'متأخرة') }}
                        </span>
                    </div>
                    <div><span class="text-gray-600 dark:text-gray-400">تاريخ الاستحقاق:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '-' }}</span></div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">تفاصيل المبلغ</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">المبلغ الفرعي:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($invoice->subtotal, 2) }} ج.م</span>
                    </div>
                    @if($invoice->tax_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">الضريبة:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($invoice->tax_amount, 2) }} ج.م</span>
                    </div>
                    @endif
                    @if($invoice->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">الخصم:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">-{{ number_format($invoice->discount_amount, 2) }} ج.م</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                        <span class="text-gray-900 dark:text-white">المبلغ الإجمالي:</span>
                        <span class="text-sky-600 dark:text-sky-400">{{ number_format($invoice->total_amount, 2) }} ج.م</span>
                    </div>
                </div>
            </div>
        </div>

        @if($invoice->payments && $invoice->payments->count() > 0)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">المدفوعات</h3>
            <div class="space-y-2">
                @foreach($invoice->payments as $payment)
                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ $payment->payment_number }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d') : '-' }}</div>
                    </div>
                    <div class="font-medium text-green-600 dark:text-green-400">{{ number_format($payment->amount, 2) }} ج.م</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($invoice->description)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">الوصف</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ $invoice->description }}</p>
        </div>
        @endif
    </div>
</div>
@endsection


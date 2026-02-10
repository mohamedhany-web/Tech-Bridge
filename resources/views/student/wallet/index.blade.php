@extends('layouts.app')

@section('title', 'محفظتي')
@section('header', 'محفظتي')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">محفظتي</h1>
        @if(isset($wallet))
        <div class="mt-4">
            <div class="text-sm text-gray-600 dark:text-gray-400">الرصيد الحالي</div>
            <div class="text-3xl font-bold text-sky-600 mt-2">{{ number_format($wallet->balance ?? 0, 2) }} ج.م</div>
        </div>
        @endif
    </div>

    @if(isset($transactions) && $transactions->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">سجل المعاملات</h2>
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ $transaction->description ?? 'معاملة' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : '-' }}</div>
                    </div>
                    <div class="text-lg font-bold {{ ($transaction->type == 'deposit' || $transaction->type == 'إيداع') ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($transaction->type == 'deposit' || $transaction->type == 'إيداع') ? '+' : '-' }}{{ number_format($transaction->amount ?? 0, 2) }} ج.م
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $transactions->links() }}</div>
        </div>
    </div>
    @endif
</div>
@endsection

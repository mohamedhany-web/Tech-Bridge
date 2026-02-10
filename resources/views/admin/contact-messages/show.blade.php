@extends('layouts.app')

@section('title', 'عرض الرسالة - Tech Bridge')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">عرض الرسالة</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $contactMessage->subject }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($contactMessage->status !== 'new')
                    <form action="{{ route('admin.contact-messages.mark-as-unread', $contactMessage) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            تحديد كغير مقروءة
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.contact-messages.mark-as-read', $contactMessage) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>
                            تحديد كمقروءة
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('admin.contact-messages.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-right mr-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">الاسم</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $contactMessage->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">البريد الإلكتروني</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $contactMessage->email }}</p>
                    </div>
                    @if($contactMessage->phone)
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">رقم الهاتف</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $contactMessage->phone }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">الموضوع</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $contactMessage->subject }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">الرسالة</p>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $contactMessage->message }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            @if($contactMessage->status !== 'new')
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                مقروءة
                            </span>
                            @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                غير مقروءة
                            </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ الإرسال</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




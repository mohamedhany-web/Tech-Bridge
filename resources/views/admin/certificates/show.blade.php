@extends('layouts.app')

@section('title', 'تفاصيل الشهادة')
@section('header', 'تفاصيل الشهادة')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">شهادة #{{ $certificate->certificate_number }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">تاريخ الإنشاء: {{ $certificate->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg font-medium transition-colors mr-2">
                    تعديل
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    رجوع
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">معلومات الطالب</h3>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600 dark:text-gray-400">الاسم:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->user->name ?? 'غير معروف' }}</span></div>
                    <div><span class="text-gray-600 dark:text-gray-400">البريد:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->user->email ?? '-' }}</span></div>
                    <div><span class="text-gray-600 dark:text-gray-400">الهاتف:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->user->phone ?? '-' }}</span></div>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">معلومات الشهادة</h3>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600 dark:text-gray-400">العنوان:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->title ?? $certificate->course_name ?? '-' }}</span></div>
                    @if($certificate->course)
                    <div><span class="text-gray-600 dark:text-gray-400">الكورس:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->course->title }}</span></div>
                    @elseif($certificate->course_name)
                    <div><span class="text-gray-600 dark:text-gray-400">الكورس:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->course_name }}</span></div>
                    @endif
                    <div><span class="text-gray-600 dark:text-gray-400">الحالة:</span> 
                        @php
                            $status = $certificate->status ?? ($certificate->is_verified ? 'issued' : 'pending');
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($status == 'issued') bg-green-100 text-green-800
                            @elseif($status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif mr-2">
                            {{ $status == 'issued' ? 'مُصدرة' : ($status == 'pending' ? 'معلقة' : 'ملغاة') }}
                        </span>
                    </div>
                    <div><span class="text-gray-600 dark:text-gray-400">تاريخ الإصدار:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ ($certificate->issued_at ? $certificate->issued_at->format('Y-m-d') : ($certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '-')) }}</span></div>
                    <div><span class="text-gray-600 dark:text-gray-400">رمز التحقق:</span> <span class="font-medium text-gray-900 dark:text-white mr-2">{{ $certificate->verification_code ?? '-' }}</span></div>
                </div>
            </div>
        </div>

        @if($certificate->description)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">الوصف</h3>
            <p class="text-gray-600 dark:text-gray-400">{{ $certificate->description }}</p>
        </div>
        @endif
    </div>
</div>
@endsection


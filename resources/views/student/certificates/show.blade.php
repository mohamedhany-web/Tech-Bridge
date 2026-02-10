@extends('layouts.app')

@section('title', 'الشهادة')
@section('header', 'الشهادة')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <a href="{{ route('student.certificates.index') }}" class="text-sky-600 hover:text-sky-900 dark:text-sky-400 dark:hover:text-sky-300 mb-4 inline-block">
                <i class="fas fa-arrow-right mr-2"></i>رجوع إلى الشهادات
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $certificate->title }}</h1>
        </div>

        <div class="text-center border-4 border-sky-600 rounded-xl p-12 bg-gradient-to-br from-sky-50 to-blue-50 dark:from-gray-700 dark:to-gray-800">
            <div class="mb-6">
                <i class="fas fa-certificate text-8xl text-sky-600 mb-4"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">شهادة إتمام</h2>
            <p class="text-xl text-gray-700 dark:text-gray-300 mb-6">{{ $certificate->title ?? $certificate->course_name ?? 'شهادة الإتمام' }}</p>
            @if($certificate->course)
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">في: {{ $certificate->course->title }}</p>
            @elseif($certificate->course_name)
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">في: {{ $certificate->course_name }}</p>
            @endif
            @if($certificate->description)
            <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $certificate->description }}</p>
            @endif
            <div class="mt-8 pt-6 border-t border-gray-300 dark:border-gray-600">
                <p class="text-sm text-gray-600 dark:text-gray-400">رقم الشهادة: {{ $certificate->certificate_number }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">تاريخ الإصدار: {{ ($certificate->issued_at ? $certificate->issued_at->format('Y-m-d') : ($certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '-')) }}</p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <button onclick="window.print()" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-print mr-2"></i>طباعة الشهادة
            </button>
        </div>
    </div>
</div>
@endsection


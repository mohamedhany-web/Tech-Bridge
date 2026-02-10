@extends('layouts.app')

@section('title', 'شهاداتي')
@section('header', 'شهاداتي')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">شهاداتي</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">جميع الشهادات الخاصة بي</p>
    </div>

    @if(isset($certificates) && $certificates->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($certificates as $certificate)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <i class="fas fa-certificate text-6xl text-sky-600 mb-4"></i>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $certificate->title }}</h3>
                @if($certificate->course)
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $certificate->course->title }}</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('student.certificates.show', $certificate) }}" class="text-sky-600 hover:text-sky-900">عرض الشهادة</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $certificates->links() }}</div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
        <i class="fas fa-certificate text-gray-400 text-6xl mb-4"></i>
        <p class="text-gray-600 dark:text-gray-400">لا توجد شهادات</p>
    </div>
    @endif
</div>
@endsection

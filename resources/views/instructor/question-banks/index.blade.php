@extends('layouts.app')

@section('title', 'بنك أسئلتي')
@section('header', 'بنك أسئلتي')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">بنوك الأسئلة</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">إنشاء وإدارة بنوك الأسئلة لاستخدامها في الاختبارات. الأسئلة هنا تظهر لك فقط عند إنشاء اختبار.</p>
        </div>
        <a href="{{ route('instructor.question-banks.create') }}" class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
            <i class="fas fa-plus ml-2"></i>
            بنك جديد
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-xl">{{ session('success') }}</div>
    @endif

    @if($banks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($banks as $bank)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $bank->title }}</h3>
                        @if($bank->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">{{ $bank->description }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                <i class="fas fa-question-circle ml-1"></i>
                                {{ $bank->questions_count }} سؤال
                            </span>
                            <a href="{{ route('instructor.question-banks.show', $bank) }}" class="text-sky-600 dark:text-sky-400 hover:underline font-medium text-sm">
                                عرض / إضافة أسئلة
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $banks->links() }}</div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
            <div class="w-20 h-20 mx-auto mb-4 bg-sky-100 dark:bg-sky-900/40 rounded-full flex items-center justify-center">
                <i class="fas fa-database text-3xl text-sky-600 dark:text-sky-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد بنوك أسئلة</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">أنشئ بنكاً أولاً ثم أضف إليه الأسئلة لاستخدامها في الاختبارات.</p>
            <a href="{{ route('instructor.question-banks.create') }}" class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                <i class="fas fa-plus ml-2"></i>
                إنشاء بنك أسئلة
            </a>
        </div>
    @endif
</div>
@endsection

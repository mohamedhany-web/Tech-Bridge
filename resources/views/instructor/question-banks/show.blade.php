@extends('layouts.app')

@section('title', $questionBank->title . ' - بنك أسئلتي')
@section('header', $questionBank->title)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('instructor.question-banks.index') }}" class="text-sky-600 dark:text-sky-400 hover:underline text-sm mb-2 inline-block">
                <i class="fas fa-arrow-right ml-1"></i>
                بنوك الأسئلة
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $questionBank->title }}</h1>
            @if($questionBank->description)
                <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $questionBank->description }}</p>
            @endif
        </div>
        <a href="{{ route('instructor.question-banks.questions.create', $questionBank) }}" class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
            <i class="fas fa-plus ml-2"></i>
            إضافة سؤال
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded-xl">{{ session('success') }}</div>
    @endif

    @if($questionBank->questions->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">أسئلة البنك ({{ $questionBank->questions->count() }})</h2>
            </div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($questionBank->questions as $index => $q)
                    <li class="px-6 py-4 flex items-start justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $index + 1 }}. {{ Str::limit($q->question, 120) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $q->getTypeLabel() }} · {{ $q->points }} درجة · {{ $q->getDifficultyLabel() }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-200 dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400 mb-6">لا توجد أسئلة في هذا البنك بعد.</p>
            <a href="{{ route('instructor.question-banks.questions.create', $questionBank) }}" class="inline-flex items-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                <i class="fas fa-plus ml-2"></i>
                إضافة أول سؤال
            </a>
        </div>
    @endif
</div>
@endsection

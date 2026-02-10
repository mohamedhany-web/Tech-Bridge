@extends('layouts.app')

@section('title', 'إنشاء بنك أسئلة')
@section('header', 'إنشاء بنك أسئلة')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('instructor.question-banks.index') }}" class="text-sky-600 dark:text-sky-400 hover:underline">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة لبنوك الأسئلة
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">بنك أسئلة جديد</h2>
            </div>
            <form action="{{ route('instructor.question-banks.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم البنك <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white"
                           placeholder="مثال: أسئلة الوحدة الأولى">
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف (اختياري)</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium">إنشاء البنك</button>
                    <a href="{{ route('instructor.question-banks.index') }}" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

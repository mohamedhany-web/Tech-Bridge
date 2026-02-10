@extends('layouts.app')

@section('title', 'إضافة سؤال - ' . $questionBank->title)
@section('header', 'إضافة سؤال')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('instructor.question-banks.show', $questionBank) }}" class="text-sky-600 dark:text-sky-400 hover:underline">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة إلى {{ $questionBank->title }}
        </a>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">سؤال جديد</h2>
            </div>
            <form action="{{ route('instructor.question-banks.questions.store', $questionBank) }}" method="POST" class="p-6 space-y-4" x-data="{
                    type: @json(old('type', 'multiple_choice')),
                    option_1: @json(old('option_1')),
                    option_2: @json(old('option_2')),
                    option_3: @json(old('option_3')),
                    option_4: @json(old('option_4')),
                    correctOption: @json(old('correct_option'))
                }">
                @csrf
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نص السؤال <span class="text-red-500">*</span></label>
                    <textarea name="question" id="question" rows="3" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white" placeholder="اكتب السؤال...">{{ old('question') }}</textarea>
                    @error('question')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نوع السؤال <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required x-model="type" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            @foreach($questionTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">مستوى الصعوبة <span class="text-red-500">*</span></label>
                        <select name="difficulty_level" id="difficulty_level" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            @foreach($difficultyLevels as $key => $label)
                                <option value="{{ $key }}" {{ old('difficulty_level', 'medium') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="points" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الدرجة <span class="text-red-500">*</span></label>
                        <input type="number" name="points" id="points" value="{{ old('points', 1) }}" min="0.5" max="100" step="0.5" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                @if($categories->count() > 0)
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التصنيف (اختياري)</label>
                    <select name="category_id" id="category_id" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">بدون تصنيف</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- اختيار من متعدد -->
                <div x-show="type === 'multiple_choice'" x-cloak class="space-y-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">الخيارات (حدد الإجابة الصحيحة)</p>
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_option" :value="option_1" id="correct_1" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" :checked="correctOption === option_1 && option_1">
                        <input type="text" name="option_1" x-model="option_1" placeholder="الخيار 1" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_option" :value="option_2" id="correct_2" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" :checked="correctOption === option_2 && option_2">
                        <input type="text" name="option_2" x-model="option_2" placeholder="الخيار 2" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_option" :value="option_3" id="correct_3" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" :checked="correctOption === option_3 && option_3">
                        <input type="text" name="option_3" x-model="option_3" placeholder="الخيار 3" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="radio" name="correct_option" :value="option_4" id="correct_4" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" :checked="correctOption === option_4 && option_4">
                        <input type="text" name="option_4" x-model="option_4" placeholder="الخيار 4" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                    </div>
                    <p class="text-xs text-gray-500">اختر دائرة الإجابة الصحيحة بجانب الخيار الصحيح.</p>
                </div>

                <!-- صح أو خطأ -->
                <div x-show="type === 'true_false'" x-cloak class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الإجابة الصحيحة</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="true_false_answer" value="صح" {{ old('true_false_answer') == 'صح' ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <span>صح</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="true_false_answer" value="خطأ" {{ old('true_false_answer') == 'خطأ' ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            <span>خطأ</span>
                        </label>
                    </div>
                </div>

                <!-- إجابة نموذجية (قصيرة/مقالي/املأ الفراغ) -->
                <div x-show="['short_answer', 'essay', 'fill_blank'].includes(type)" x-cloak>
                    <label for="model_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">إجابة نموذجية (اختياري)</label>
                    <textarea name="model_answer" id="model_answer" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('model_answer') }}</textarea>
                </div>

                <div>
                    <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">شرح الإجابة (اختياري)</label>
                    <textarea name="explanation" id="explanation" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('explanation') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium">إضافة السؤال</button>
                    <a href="{{ route('instructor.question-banks.show', $questionBank) }}" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

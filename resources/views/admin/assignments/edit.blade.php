@extends('layouts.app')

@section('title', 'تعديل الواجب')
@section('header', 'الواجبات والمشاريع')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">تعديل الواجب: {{ $assignment->title }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تحديث بيانات الواجب</p>
        </div>

        <form action="{{ route('admin.assignments.update', $assignment) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="advanced_course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الكورس <span class="text-red-500">*</span></label>
                    <select name="advanced_course_id" id="advanced_course_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('advanced_course_id', $assignment->advanced_course_id ?? $assignment->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('advanced_course_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lesson_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الدرس (اختياري)</label>
                    <select name="lesson_id" id="lesson_id"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                        <option value="">بدون درس محدد</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ old('lesson_id', $assignment->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('lesson_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان الواجب <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $assignment->title) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الوصف</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">{{ old('description', $assignment->description) }}</textarea>
                </div>

                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">التعليمات</label>
                    <textarea name="instructions" id="instructions" rows="4"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">{{ old('instructions', $assignment->instructions) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ الاستحقاق</label>
                        <input type="datetime-local" name="due_date" id="due_date"
                               value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                    </div>
                    <div>
                        <label for="max_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الدرجة الكلية <span class="text-red-500">*</span></label>
                        <input type="number" name="max_score" id="max_score" value="{{ old('max_score', $assignment->max_score) }}" min="1" max="1000" required
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="allow_late_submission" id="allow_late_submission" value="1"
                           {{ old('allow_late_submission', $assignment->allow_late_submission) ? 'checked' : '' }}
                           class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600">
                    <label for="allow_late_submission" class="text-sm font-medium text-gray-700 dark:text-gray-300">السماح بالتسليم المتأخر</label>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الحالة <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-colors">
                        <option value="draft" {{ old('status', $assignment->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="published" {{ old('status', $assignment->status) == 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="archived" {{ old('status', $assignment->status) == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.assignments.show', $assignment) }}"
                       class="inline-flex items-center px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        إلغاء
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-medium transition-colors shadow-md hover:shadow-lg">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

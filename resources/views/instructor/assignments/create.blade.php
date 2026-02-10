@extends('layouts.app')

@section('title', 'إنشاء واجب جديد - Tech Bridge')
@section('header', 'إنشاء واجب جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('instructor.assignments.index') }}" class="hover:text-sky-600">الواجبات</a>
                <span class="mx-2">/</span>
                <span>إنشاء واجب جديد</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">إنشاء واجب جديد</h1>
        </div>

        <form action="{{ route('instructor.assignments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- الكورس -->
            <div>
                <label for="advanced_course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الكورس <span class="text-red-500">*</span>
                </label>
                <select name="advanced_course_id" id="advanced_course_id" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">اختر الكورس</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('advanced_course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('advanced_course_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الدرس (اختياري) -->
            <div>
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الدرس (اختياري)
                </label>
                <select name="lesson_id" id="lesson_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">بدون درس محدد</option>
                    <!-- سيتم ملء هذا من خلال JavaScript بناءً على الكورس المختار -->
                </select>
                @error('lesson_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- العنوان -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    عنوان الواجب <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                       placeholder="مثال: واجب البرمجة الكائنية">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الوصف -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الوصف
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                          placeholder="وصف مختصر عن الواجب">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- التعليمات -->
            <div>
                <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    التعليمات
                </label>
                <textarea name="instructions" id="instructions" rows="6"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                          placeholder="تعليمات مفصلة للطلاب حول كيفية إنجاز الواجب">{{ old('instructions') }}</textarea>
                @error('instructions')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- تاريخ الاستحقاق -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        تاريخ الاستحقاق
                    </label>
                    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الدرجة الكلية -->
                <div>
                    <label for="max_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        الدرجة الكلية <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_score" id="max_score" value="{{ old('max_score', 100) }}" 
                           min="1" max="1000" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('max_score')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- السماح بالتسليم المتأخر -->
            <div class="flex items-center">
                <input type="checkbox" name="allow_late_submission" id="allow_late_submission" value="1"
                       {{ old('allow_late_submission') ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                <label for="allow_late_submission" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    السماح بالتسليم المتأخر
                </label>
            </div>

            <!-- الحالة -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الحالة <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>مسودة</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منشور</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الأزرار -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('instructor.assignments.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                    <i class="fas fa-save ml-2"></i>
                    إنشاء الواجب
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // تحديث قائمة الدروس عند اختيار الكورس
    document.getElementById('advanced_course_id').addEventListener('change', function() {
        const courseId = this.value;
        const lessonSelect = document.getElementById('lesson_id');
        
        // مسح الخيارات الحالية (ما عدا الخيار الأول)
        while (lessonSelect.children.length > 1) {
            lessonSelect.removeChild(lessonSelect.lastChild);
        }
        
        if (courseId) {
            // جلب دروس الكورس
            fetch(`/api/courses/${courseId}/lessons`)
                .then(response => response.json())
                .then(data => {
                    if (data.lessons) {
                        data.lessons.forEach(lesson => {
                            const option = document.createElement('option');
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            lessonSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching lessons:', error);
                });
        }
    });
</script>
@endsection


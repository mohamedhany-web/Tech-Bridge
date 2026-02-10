@extends('layouts.app')

@section('title', 'إنشاء اختبار جديد')
@section('header', 'إنشاء اختبار جديد')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('instructor.exams.index') }}" class="hover:text-sky-600 dark:hover:text-sky-400">الاختبارات</a>
            <span class="mx-2">/</span>
            <span>إنشاء اختبار جديد</span>
        </nav>
        <a href="{{ route('instructor.exams.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة
        </a>
    </div>

    <form action="{{ route('instructor.exams.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <!-- معلومات أساسية -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات الاختبار</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان الاختبار <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="مثال: اختبار الوحدة الأولى">
                            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="advanced_course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكورس <span class="text-red-500">*</span></label>
                                <select name="advanced_course_id" id="advanced_course_id" required
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">اختر الكورس</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('advanced_course_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                                    @endforeach
                                </select>
                                @error('advanced_course_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="course_lesson_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الدرس (اختياري)</label>
                                <select name="course_lesson_id" id="course_lesson_id"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">امتحان عام للكورس</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف</label>
                            <textarea name="description" id="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تعليمات الاختبار</label>
                            <textarea name="instructions" id="instructions" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white" placeholder="تعليمات تظهر للطالب قبل البدء...">{{ old('instructions') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- التوقيت والدرجات -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">التوقيت والدرجات</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المدة (دقيقة) <span class="text-red-500">*</span></label>
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="5" max="480" required
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                @error('duration_minutes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="total_marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الدرجة الكلية <span class="text-red-500">*</span></label>
                                <input type="number" name="total_marks" id="total_marks" value="{{ old('total_marks', 100) }}" min="1" step="0.5" required
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                @error('total_marks')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="passing_marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">درجة النجاح <span class="text-red-500">*</span></label>
                                <input type="number" name="passing_marks" id="passing_marks" value="{{ old('passing_marks', 60) }}" min="0" step="0.5" required
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                @error('passing_marks')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="attempts_allowed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عدد المحاولات المسموحة <span class="text-red-500">*</span></label>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" value="{{ old('attempts_allowed', 1) }}" min="1" max="10" required
                                   class="w-full max-w-xs px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            @error('attempts_allowed')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">بداية الاختبار</label>
                                <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نهاية الاختبار</label>
                                <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إعدادات العرض -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إعدادات العرض</h3>
                    </div>
                    <div class="p-6 flex flex-wrap gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="randomize_questions" value="1" {{ old('randomize_questions') ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            خلط ترتيب الأسئلة
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="randomize_options" value="1" {{ old('randomize_options') ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            خلط الخيارات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_results_immediately" value="1" {{ old('show_results_immediately', true) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            عرض النتيجة فوراً
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_correct_answers" value="1" {{ old('show_correct_answers') ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            عرض الإجابات الصحيحة
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_explanations" value="1" {{ old('show_explanations') ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            عرض شرح الإجابات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="allow_review" value="1" {{ old('allow_review', true) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            السماح بمراجعة الإجابات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                            اختبار نشط
                        </label>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <i class="fas fa-info-circle text-sky-500 ml-1"></i>
                        بعد الإنشاء ستتمكن من إضافة الأسئلة من بنك أسئلتك في صفحة تعديل الاختبار.
                    </p>
                    <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        إنشاء الاختبار
                    </button>
                    <a href="{{ route('instructor.exams.index') }}" class="mt-3 w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-3 px-4 rounded-lg font-medium block text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('advanced_course_id');
    const lessonSelect = document.getElementById('course_lesson_id');
    if (!courseSelect || !lessonSelect) return;
    function loadLessons() {
        const courseId = courseSelect.value;
        lessonSelect.innerHTML = '<option value="">امتحان عام للكورس</option>';
        if (!courseId) return;
        fetch('/instructor/courses/' + courseId + '/lessons-list')
            .then(r => r.json())
            .then(lessons => {
                lessons.forEach(l => {
                    const opt = document.createElement('option');
                    opt.value = l.id;
                    opt.textContent = l.title;
                    lessonSelect.appendChild(opt);
                });
            })
            .catch(() => {});
    }
    courseSelect.addEventListener('change', loadLessons);
    if (courseSelect.value) loadLessons();
});
</script>
@endpush
@endsection

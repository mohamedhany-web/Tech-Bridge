@extends('layouts.app')

@section('title', 'تعديل الاختبار - ' . $exam->title)
@section('header', 'تعديل الاختبار')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('instructor.exams.index') }}" class="hover:text-sky-600">الاختبارات</a>
            <span class="mx-2">/</span>
            <a href="{{ route('instructor.exams.show', $exam) }}" class="hover:text-sky-600">{{ $exam->title }}</a>
            <span class="mx-2">/</span>
            <span>تعديل</span>
        </nav>
        <a href="{{ route('instructor.exams.show', $exam) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة
        </a>
    </div>

    <form action="{{ route('instructor.exams.update', $exam) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <!-- معلومات أساسية (نفس create مع القيم الحالية) -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات الاختبار</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان الاختبار <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $exam->title) }}" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="advanced_course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكورس <span class="text-red-500">*</span></label>
                                <select name="advanced_course_id" id="advanced_course_id" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ old('advanced_course_id', $exam->advanced_course_id) == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="course_lesson_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الدرس (اختياري)</label>
                                <select name="course_lesson_id" id="course_lesson_id" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">امتحان عام للكورس</option>
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id }}" {{ old('course_lesson_id', $exam->course_lesson_id) == $lesson->id ? 'selected' : '' }}>{{ $lesson->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف</label>
                            <textarea name="description" id="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('description', $exam->description) }}</textarea>
                        </div>
                        <div>
                            <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تعليمات الاختبار</label>
                            <textarea name="instructions" id="instructions" rows="3" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">{{ old('instructions', $exam->instructions) }}</textarea>
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
                                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $exam->duration_minutes) }}" min="5" max="480" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="total_marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الدرجة الكلية <span class="text-red-500">*</span></label>
                                <input type="number" name="total_marks" value="{{ old('total_marks', $exam->total_marks) }}" min="1" step="0.5" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="passing_marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">درجة النجاح <span class="text-red-500">*</span></label>
                                <input type="number" name="passing_marks" value="{{ old('passing_marks', $exam->passing_marks) }}" min="0" step="0.5" required class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="attempts_allowed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عدد المحاولات المسموحة <span class="text-red-500">*</span></label>
                            <input type="number" name="attempts_allowed" value="{{ old('attempts_allowed', $exam->attempts_allowed) }}" min="1" max="10" required class="w-full max-w-xs px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">بداية الاختبار</label>
                                <input type="datetime-local" name="start_time" value="{{ $exam->start_time ? $exam->start_time->format('Y-m-d\TH:i') : '' }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نهاية الاختبار</label>
                                <input type="datetime-local" name="end_time" value="{{ $exam->end_time ? $exam->end_time->format('Y-m-d\TH:i') : '' }}" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أسئلة الاختبار (من بنك أسئلتك فقط) -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">أسئلة الاختبار</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">اختر الأسئلة من بنك أسئلتك فقط. لا يمكنك الاطلاع على أسئلة المدربين الآخرين.</p>
                    </div>
                    <div class="p-6">
                        @if($availableQuestions->count() > 0)
                            @php $currentQuestionIds = $exam->questions->pluck('id'); $orderedQuestions = $exam->questions->merge($availableQuestions->whereNotIn('id', $currentQuestionIds)); @endphp
                            <ul class="space-y-3">
                                @foreach($orderedQuestions as $q)
                                    @php $inExam = $currentQuestionIds->contains($q->id); $marks = $inExam ? ($exam->questions->firstWhere('id', $q->id)->pivot->marks ?? $exam->questions->firstWhere('id', $q->id)->pivot->points ?? 1) : 1; @endphp
                                    <li class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <label class="flex items-center gap-2 cursor-pointer flex-shrink-0">
                                            <input type="checkbox" name="questions[]" value="{{ $q->id }}" {{ $inExam ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">تضمين</span>
                                        </label>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ Str::limit($q->question, 80) }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $q->getTypeLabel() }}</p>
                                        </div>
                                        <div class="w-24 flex-shrink-0">
                                            <label for="marks_{{ $q->id }}" class="sr-only">الدرجة</label>
                                            <input type="number" name="question_marks[{{ $q->id }}]" id="marks_{{ $q->id }}" value="{{ old('question_marks.'.$q->id, $marks) }}" min="0.5" step="0.5" class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-700 dark:text-white">
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-6">لا توجد أسئلة في بنك أسئلتك. أنشئ بنك أسئلة وأضف أسئلة من لوحة التحكم (بنك الأسئلة) ثم ارجع هنا.</p>
                        @endif
                    </div>
                </div>

                <!-- إعدادات العرض -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إعدادات العرض</h3>
                    </div>
                    <div class="p-6 flex flex-wrap gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="randomize_questions" value="1" {{ old('randomize_questions', $exam->randomize_questions) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> خلط ترتيب الأسئلة
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="randomize_options" value="1" {{ old('randomize_options', $exam->randomize_options) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> خلط الخيارات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_results_immediately" value="1" {{ old('show_results_immediately', $exam->show_results_immediately) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> عرض النتيجة فوراً
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_correct_answers" value="1" {{ old('show_correct_answers', $exam->show_correct_answers) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> عرض الإجابات الصحيحة
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="show_explanations" value="1" {{ old('show_explanations', $exam->show_explanations) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> عرض شرح الإجابات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="allow_review" value="1" {{ old('allow_review', $exam->allow_review) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> السماح بمراجعة الإجابات
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $exam->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-500"> اختبار نشط
                        </label>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('instructor.exams.show', $exam) }}" class="mt-3 w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 py-3 px-4 rounded-lg font-medium block text-center">إلغاء</a>
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
        fetch('/instructor/courses/' + courseId + '/lessons-list').then(r => r.json()).then(lessons => {
            lessons.forEach(l => {
                const opt = document.createElement('option');
                opt.value = l.id;
                opt.textContent = l.title;
                if (opt.value === '{{ old("course_lesson_id", $exam->course_lesson_id) }}') opt.selected = true;
                lessonSelect.appendChild(opt);
            });
        }).catch(() => {});
    }
    courseSelect.addEventListener('change', loadLessons);
});
</script>
@endpush
@endsection

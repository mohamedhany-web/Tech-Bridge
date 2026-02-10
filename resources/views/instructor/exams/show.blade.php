@extends('layouts.app')

@section('title', 'تفاصيل الاختبار - ' . $exam->title)
@section('header', 'تفاصيل الاختبار')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('instructor.exams.index') }}" class="hover:text-sky-600">الاختبارات</a>
            <span class="mx-2">/</span>
            <span>{{ $exam->title }}</span>
        </nav>
        <div class="flex items-center gap-2">
            <a href="{{ route('instructor.exams.edit', $exam) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-edit ml-2"></i>
                تعديل
            </a>
            <a href="{{ route('instructor.exams.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات الاختبار</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $exam->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ $exam->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </div>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $exam->title }}</h2>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <span><i class="fas fa-book ml-1"></i> {{ $exam->advancedCourse->title ?? '—' }}</span>
                        @if($exam->lesson)
                            <span><i class="fas fa-play-circle ml-1"></i> {{ $exam->lesson->title }}</span>
                        @endif
                        <span><i class="fas fa-clock ml-1"></i> {{ $exam->duration_minutes }} دقيقة</span>
                        <span><i class="fas fa-star ml-1"></i> {{ $exam->total_marks }} درجة</span>
                        <span><i class="fas fa-check ml-1"></i> نجاح {{ $exam->passing_marks }}</span>
                    </div>
                    @if($exam->description)
                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $exam->description }}</p>
                    @endif
                    @if($exam->instructions)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تعليمات الاختبار</p>
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $exam->instructions }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- الأسئلة -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">أسئلة الاختبار ({{ $exam->questions->count() }})</h3>
                </div>
                <div class="p-6">
                    @if($exam->questions->count() > 0)
                        <ul class="space-y-3">
                            @foreach($exam->questions as $index => $question)
                                <li class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <span class="flex-shrink-0 w-8 h-8 bg-sky-100 dark:bg-sky-900 rounded-full flex items-center justify-center text-sky-700 dark:text-sky-300 text-sm font-medium">{{ $index + 1 }}</span>
                                    <div class="min-w-0">
                                        <p class="text-gray-900 dark:text-white font-medium">{{ Str::limit($question->question, 120) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $question->getTypeLabel() }} · {{ $question->pivot->marks ?? $question->pivot->points ?? 1 }} درجة</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-6">لا توجد أسئلة. أضف أسئلة من صفحة التعديل (بنك أسئلتك فقط).</p>
                        <a href="{{ route('instructor.exams.edit', $exam) }}" class="block text-center text-sky-600 dark:text-sky-400 hover:underline">تعديل الاختبار وإضافة أسئلة</a>
                    @endif
                </div>
            </div>

            <!-- المحاولات -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">آخر المحاولات</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    @if($attempts->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400">الطالب</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400">النتيجة</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400">الحالة</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($attempts as $attempt)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $attempt->user->name ?? '—' }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $attempt->score ?? '—' }} / {{ $exam->total_marks }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex px-2 py-0.5 rounded text-xs font-medium {{ $attempt->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                {{ $attempt->status === 'completed' ? 'مكتمل' : 'قيد التنفيذ' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $attempt->submitted_at?->format('Y/m/d H:i') ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $attempts->links() }}</div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-6">لا توجد محاولات بعد.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full bg-sky-100 dark:bg-sky-900">
                        <i class="fas fa-question-circle text-sky-600 dark:text-sky-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $exam->questions->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">سؤال</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full bg-green-100 dark:bg-green-900">
                        <i class="fas fa-users text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $attemptStats['total'] ?? 0 }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">محاولة</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full bg-purple-100 dark:bg-purple-900">
                        <i class="fas fa-chart-line text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($attemptStats['average_score'] ?? 0, 1) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">متوسط الدرجات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

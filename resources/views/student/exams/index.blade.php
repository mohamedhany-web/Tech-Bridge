@extends('layouts.app')

@section('title', 'امتحاناتي')
@section('header', 'امتحاناتي')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">الامتحانات المتاحة من الكورسات المفعلة لك</p>
                </div>
                <a href="{{ route('my-courses.index') }}" 
                   class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-book-open ml-2"></i>
                    كورساتي
                </a>
            </div>
        </div>
    </div>

    <!-- الامتحانات المتاحة -->
    @if($availableExams->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($availableExams as $exam)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- هيدر البطاقة -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $exam->title }}</h3>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            @if($exam->can_attempt)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <i class="fas fa-check-circle ml-1"></i>
                                    متاح
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <i class="fas fa-times-circle ml-1"></i>
                                    غير متاح
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- محتوى البطاقة -->
                <div class="p-6">
                    <!-- معلومات الامتحان -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">الكورس:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $exam->course->title }}</span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-book text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">المادة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ optional($exam->course->academicSubject)->name ?? 'غير محدد' }}</span>
                        </div>

                        @if($exam->lesson)
                            <div class="flex items-center">
                                <i class="fas fa-play-circle text-gray-400 w-4 ml-2"></i>
                                <span class="text-gray-600 dark:text-gray-400">الدرس:</span>
                                <span class="text-gray-900 dark:text-white mr-2">{{ $exam->lesson->title }}</span>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">المدة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $exam->duration_minutes }} دقيقة</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-question-circle text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">عدد الأسئلة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $exam->questions_count }} سؤال</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-star text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">درجة النجاح:</span>
                            <span class="text-gray-900 dark:text-white mr-2">{{ $exam->passing_marks }}%</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-redo text-gray-400 w-4 ml-2"></i>
                            <span class="text-gray-600 dark:text-gray-400">المحاولات المسموحة:</span>
                            <span class="text-gray-900 dark:text-white mr-2">
                                {{ $exam->attempts_allowed == 0 ? 'غير محدود' : $exam->attempts_allowed }}
                            </span>
                        </div>
                    </div>

                    <!-- معلومات المحاولات -->
                    @if($exam->user_attempts > 0)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-blue-900 dark:text-blue-100">محاولاتك السابقة</div>
                                    <div class="text-sm text-blue-700 dark:text-blue-300">
                                        {{ $exam->user_attempts }} من {{ $exam->attempts_allowed == 0 ? 'غير محدود' : $exam->attempts_allowed }}
                                    </div>
                                </div>
                                @if($exam->best_score !== null)
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ number_format($exam->best_score, 1) }}%</div>
                                        <div class="text-xs text-blue-700 dark:text-blue-300">أفضل نتيجة</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($exam->description)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $exam->description }}</p>
                        </div>
                    @endif

                    <!-- أزرار العمل -->
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            @if($exam->start_time)
                                <div>يبدأ: {{ $exam->start_time->format('Y-m-d H:i') }}</div>
                            @endif
                            @if($exam->end_time)
                                <div>ينتهي: {{ $exam->end_time->format('Y-m-d H:i') }}</div>
                            @endif
                        </div>

                        <div>
                            @if($exam->can_attempt)
                                <a href="{{ route('student.exams.show', $exam) }}" 
                                   class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-play ml-2"></i>
                                    ابدأ الامتحان
                                </a>
                            @elseif($exam->user_attempts >= $exam->attempts_allowed && $exam->attempts_allowed > 0)
                                <span class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm font-medium">
                                    استنفدت المحاولات
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium">
                                    غير متاح حالياً
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- معلومات الأمان -->
                    @if($exam->prevent_tab_switch || $exam->require_camera || $exam->require_microphone)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 text-xs text-yellow-700 dark:text-yellow-300">
                                <i class="fas fa-shield-alt"></i>
                                <span>امتحان محمي:</span>
                                @if($exam->prevent_tab_switch)
                                    <span class="bg-yellow-100 dark:bg-yellow-900 px-2 py-1 rounded">منع تبديل التبويبات</span>
                                @endif
                                @if($exam->require_camera)
                                    <span class="bg-yellow-100 dark:bg-yellow-900 px-2 py-1 rounded">يتطلب كاميرا</span>
                                @endif
                                @if($exam->require_microphone)
                                    <span class="bg-yellow-100 dark:bg-yellow-900 px-2 py-1 rounded">يتطلب مايكروفون</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- الامتحانات المكتملة -->
        @php
            $completedExams = $availableExams->filter(function($exam) {
                return $exam->last_attempt && $exam->last_attempt->status === 'completed';
            });
        @endphp

        @if($completedExams->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الامتحانات المكتملة</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($completedExams as $exam)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $exam->title }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $exam->course->title }} - {{ $exam->last_attempt->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold {{ $exam->last_attempt->result_color == 'green' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($exam->last_attempt->percentage, 1) }}%
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $exam->last_attempt->result_status }}</div>
                                </div>
                                <div>
                                    @if($exam->show_results_immediately)
                                        <a href="{{ route('student.exams.result', [$exam, $exam->last_attempt]) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-chart-line ml-1"></i>
                                            عرض النتيجة
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-check text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">لا توجد امتحانات متاحة</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">لا توجد امتحانات متاحة في الكورسات المفعلة لك حالياً</p>
            <a href="{{ route('my-courses.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-book-open ml-2"></i>
                عرض كورساتي
            </a>
        </div>
    @endif

    <!-- إحصائيات سريعة -->
    @if($availableExams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <i class="fas fa-clipboard-check text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $availableExams->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">امتحانات متاحة</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedExams->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">مكتملة</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $availableExams->where('can_attempt', true)->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">يمكن أداؤها</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                        <i class="fas fa-percentage text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div class="mr-4">
                        @php
                            $avgScore = $completedExams->where('best_score', '!=', null)->avg('best_score');
                        @endphp
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $avgScore ? number_format($avgScore, 1) : 0 }}%</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">متوسط النتائج</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

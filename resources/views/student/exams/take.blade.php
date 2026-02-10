@extends('layouts.app')

@section('title', $exam->title)
@section('header', '')

@section('content')
<div class="min-h-screen bg-black text-white">
    <!-- شريط التحكم العلوي -->
    <div class="bg-gray-900 px-6 py-4 flex items-center justify-between border-b border-gray-700">
        <div class="flex items-center space-x-4 space-x-reverse">
            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center">
                <i class="fas fa-clipboard-check text-white"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold">{{ $exam->title }}</h1>
                <p class="text-sm text-gray-400">{{ $exam->course->title }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-6 space-x-reverse">
            <!-- العداد التنازلي -->
            <div class="text-center">
                <div id="timer" class="text-2xl font-bold text-yellow-400">{{ sprintf('%02d:%02d', floor($attempt->remaining_time / 60), $attempt->remaining_time % 60) }}</div>
                <div class="text-xs text-gray-400">الوقت المتبقي</div>
            </div>
            
            <!-- التقدم -->
            <div class="text-center">
                <div id="progress-text" class="text-lg font-medium text-blue-400">0 / {{ $questions->count() }}</div>
                <div class="text-xs text-gray-400">الأسئلة المجابة</div>
            </div>

            <!-- زر التسليم -->
            <button onclick="confirmSubmit()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-check ml-2"></i>
                تسليم الامتحان
            </button>
        </div>
    </div>

    <!-- محتوى الامتحان -->
    <div class="flex h-screen">
        <!-- قائمة الأسئلة الجانبية -->
        <div class="w-64 bg-gray-800 border-l border-gray-700 overflow-y-auto">
            <div class="p-4 border-b border-gray-700">
                <h3 class="font-medium text-gray-200">قائمة الأسئلة</h3>
            </div>
            <div class="p-2">
                @foreach($questions as $index => $examQuestion)
                    <button onclick="goToQuestion({{ $index }})" 
                            id="question-nav-{{ $index }}"
                            class="w-full text-right p-3 mb-2 rounded-lg transition-colors question-nav-btn
                                   {{ $index == 0 ? 'bg-blue-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">السؤال {{ $index + 1 }}</span>
                            <div class="w-4 h-4 rounded-full border-2 border-gray-400" id="question-status-{{ $index }}"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">{{ $examQuestion->marks }} نقطة</div>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- منطقة الأسئلة -->
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-4xl mx-auto p-6">
                @foreach($questions as $index => $examQuestion)
                    <div class="question-container {{ $index == 0 ? '' : 'hidden' }}" id="question-{{ $index }}">
                        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
                            <!-- رأس السؤال -->
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-xl font-bold text-white">السؤال {{ $index + 1 }}</h2>
                                    <div class="flex items-center gap-4 text-sm text-gray-400 mt-1">
                                        <span>{{ $examQuestion->marks }} نقطة</span>
                                        <span>{{ $examQuestion->question->type_text }}</span>
                                        @if($examQuestion->question->difficulty_level)
                                            <span class="px-2 py-1 rounded text-xs
                                                @if($examQuestion->question->difficulty_level == 'easy') bg-green-900 text-green-300
                                                @elseif($examQuestion->question->difficulty_level == 'medium') bg-yellow-900 text-yellow-300
                                                @else bg-red-900 text-red-300
                                                @endif">
                                                {{ $examQuestion->question->difficulty_text }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($examQuestion->time_limit)
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-yellow-400" id="question-timer-{{ $index }}">{{ gmdate('i:s', $examQuestion->time_limit) }}</div>
                                        <div class="text-xs text-gray-400">وقت السؤال</div>
                                    </div>
                                @endif
                            </div>

                            <!-- نص السؤال -->
                            <div class="mb-6">
                                <div class="text-lg text-white leading-relaxed">{{ $examQuestion->question->question }}</div>
                                
                                <!-- الوسائط -->
                                @if($examQuestion->question->image_url)
                                    <div class="mt-4">
                                        <img src="{{ $examQuestion->question->secure_image_url }}" 
                                             alt="صورة السؤال" 
                                             class="max-w-full h-auto rounded-lg border border-gray-600"
                                             style="max-height: 300px;">
                                    </div>
                                @endif

                                @if($examQuestion->question->audio_url)
                                    <div class="mt-4">
                                        <audio controls class="w-full">
                                            <source src="{{ $examQuestion->question->audio_url }}" type="audio/mpeg">
                                            متصفحك لا يدعم تشغيل الصوت.
                                        </audio>
                                    </div>
                                @endif

                                @if($examQuestion->question->video_url)
                                    <div class="mt-4">
                                        <div class="bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/9;">
                                            {!! \App\Helpers\VideoHelper::generateEmbedHtml($examQuestion->question->video_url, '100%', '100%') !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- خيارات الإجابة -->
                            <div class="space-y-3" id="answer-options-{{ $index }}">
                                @if($examQuestion->question->type == 'multiple_choice')
                                    @foreach($exam->randomize_options ? $examQuestion->question->shuffled_options : $examQuestion->question->options as $optionIndex => $option)
                                        <label class="flex items-center p-4 bg-gray-700 hover:bg-gray-600 rounded-lg cursor-pointer transition-colors">
                                            <input type="radio" 
                                                   name="answer_{{ $examQuestion->question->id }}" 
                                                   value="{{ $option }}"
                                                   class="w-5 h-5 text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500"
                                                   onchange="saveAnswer({{ $examQuestion->question->id }}, '{{ $option }}')">
                                            <span class="mr-3 text-white">{{ $option }}</span>
                                        </label>
                                    @endforeach

                                @elseif($examQuestion->question->type == 'true_false')
                                    <label class="flex items-center p-4 bg-gray-700 hover:bg-gray-600 rounded-lg cursor-pointer transition-colors">
                                        <input type="radio" 
                                               name="answer_{{ $examQuestion->question->id }}" 
                                               value="صح"
                                               class="w-5 h-5 text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500"
                                               onchange="saveAnswer({{ $examQuestion->question->id }}, 'صح')">
                                        <span class="mr-3 text-white">صح</span>
                                    </label>
                                    <label class="flex items-center p-4 bg-gray-700 hover:bg-gray-600 rounded-lg cursor-pointer transition-colors">
                                        <input type="radio" 
                                               name="answer_{{ $examQuestion->question->id }}" 
                                               value="خطأ"
                                               class="w-5 h-5 text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500"
                                               onchange="saveAnswer({{ $examQuestion->question->id }}, 'خطأ')">
                                        <span class="mr-3 text-white">خطأ</span>
                                    </label>

                                @elseif($examQuestion->question->type == 'fill_blank')
                                    <input type="text" 
                                           id="answer_{{ $examQuestion->question->id }}"
                                           placeholder="اكتب إجابتك هنا..."
                                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           onchange="saveAnswer({{ $examQuestion->question->id }}, this.value)">

                                @elseif($examQuestion->question->type == 'short_answer' || $examQuestion->question->type == 'essay')
                                    <textarea id="answer_{{ $examQuestion->question->id }}"
                                              rows="{{ $examQuestion->question->type == 'essay' ? 6 : 3 }}"
                                              placeholder="اكتب إجابتك هنا..."
                                              class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              onchange="saveAnswer({{ $examQuestion->question->id }}, this.value)"></textarea>
                                @endif
                            </div>

                            <!-- أزرار التنقل -->
                            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-700">
                                <button onclick="previousQuestion()" 
                                        id="prev-btn"
                                        class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg font-medium transition-colors {{ $index == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $index == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-arrow-right ml-2"></i>
                                    السابق
                                </button>

                                <div class="text-center">
                                    <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                             style="width: {{ (($index + 1) / $questions->count()) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-400">{{ $index + 1 }} من {{ $questions->count() }}</span>
                                </div>

                                <button onclick="nextQuestion()" 
                                        id="next-btn"
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                    التالي
                                    <i class="fas fa-arrow-left mr-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- نافذة تأكيد التسليم -->
    <div id="submitModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800 border-gray-600">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-900">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-white mt-4">تأكيد تسليم الامتحان</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-300">
                        هل أنت متأكد من تسليم الامتحان؟ لن تتمكن من تعديل إجاباتك بعد التسليم.
                    </p>
                    <div class="mt-4 p-3 bg-blue-900 rounded border border-blue-700">
                        <div class="text-sm text-blue-200">
                            <div>الأسئلة المجابة: <span id="answered-count">0</span> من {{ $questions->count() }}</div>
                            <div>الوقت المتبقي: <span id="submit-timer">--:--</span></div>
                        </div>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="submitExam()" 
                            class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-green-700 transition-colors">
                        تسليم
                    </button>
                    <button onclick="closeSubmitModal()" 
                            class="px-4 py-2 bg-gray-600 text-white text-base font-medium rounded-md w-24 hover:bg-gray-500 transition-colors">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- تحذير تبديل التبويب -->
    <div id="tabSwitchWarning" class="hidden fixed inset-0 bg-red-900 bg-opacity-90 overflow-y-auto h-full w-full z-50">
        <div class="relative top-1/2 transform -translate-y-1/2 mx-auto p-8 w-96 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-600 mb-4">
                <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">تحذير!</h3>
            <p class="text-red-100 mb-6">
                تم رصد تبديل التبويب. هذا مخالف لقواعد الامتحان.
            </p>
            <div id="warning-message" class="text-yellow-300 font-medium mb-6"></div>
            <button onclick="acknowledgeWarning()" 
                    class="bg-white text-red-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors">
                فهمت، أعود للامتحان
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentQuestion = 0;
let totalQuestions = {{ $questions->count() }};
let examId = {{ $exam->id }};
let attemptId = {{ $attempt->id }};
let timeRemaining = {{ $attempt->remaining_time }};
let answers = {};
let timerInterval;
let tabSwitchCount = 0;
let examEnded = false;

// تهيئة الامتحان
document.addEventListener('DOMContentLoaded', function() {
    setupExamProtection();
    startTimer();
    loadSavedAnswers();
    
    // منع العودة للخلف
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        if (!examEnded) {
            history.go(1);
            showTabSwitchWarning('محاولة العودة للخلف ممنوعة أثناء الامتحان');
        }
    };
});

// إعداد حماية الامتحان
function setupExamProtection() {
    // تم إزالة منع النقر بالزر الأيمن

    // منع اختصارات لوحة المفاتيح
    document.addEventListener('keydown', function(e) {
        // منع Print Screen وF12 وCtrl+Shift+I
        if (e.key === 'PrintScreen' || e.key === 'F12' || 
            (e.ctrlKey && e.shiftKey && e.key === 'I') ||
            (e.ctrlKey && e.key === 'u') ||
            (e.ctrlKey && e.key === 's')) {
            e.preventDefault();
            showTabSwitchWarning('هذا الإجراء ممنوع أثناء الامتحان');
            return false;
        }
    });

    // مراقبة تغيير النافذة
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && !examEnded) {
            logTabSwitch();
        }
    });

    window.addEventListener('blur', function() {
        if (!examEnded) {
            logTabSwitch();
        }
    });

    // منع إغلاق النافذة
    window.addEventListener('beforeunload', function(e) {
        if (!examEnded) {
            e.preventDefault();
            e.returnValue = 'هل تريد مغادرة الامتحان؟ سيتم تسليم إجاباتك الحالية.';
            return e.returnValue;
        }
    });
}

// بدء العداد التنازلي
function startTimer() {
    updateTimerDisplay();
    
    timerInterval = setInterval(function() {
        timeRemaining--;
        updateTimerDisplay();
        
        if (timeRemaining <= 0) {
            autoSubmitExam();
        }
    }, 1000);
}

function updateTimerDisplay() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    const timerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    document.getElementById('timer').textContent = timerText;
    document.getElementById('submit-timer').textContent = timerText;
    
    // تغيير لون العداد عند اقتراب انتهاء الوقت
    const timer = document.getElementById('timer');
    if (timeRemaining <= 300) { // 5 دقائق
        timer.className = 'text-2xl font-bold text-red-400';
    } else if (timeRemaining <= 600) { // 10 دقائق
        timer.className = 'text-2xl font-bold text-yellow-400';
    }
}

// الانتقال بين الأسئلة
function goToQuestion(index) {
    // إخفاء السؤال الحالي
    document.getElementById(`question-${currentQuestion}`).classList.add('hidden');
    document.getElementById(`question-nav-${currentQuestion}`).classList.remove('bg-blue-600', 'text-white');
    document.getElementById(`question-nav-${currentQuestion}`).classList.add('bg-gray-700', 'text-gray-300');
    
    // إظهار السؤال الجديد
    currentQuestion = index;
    document.getElementById(`question-${currentQuestion}`).classList.remove('hidden');
    document.getElementById(`question-nav-${currentQuestion}`).classList.remove('bg-gray-700', 'text-gray-300');
    document.getElementById(`question-nav-${currentQuestion}`).classList.add('bg-blue-600', 'text-white');
    
    // تحديث أزرار التنقل
    document.getElementById('prev-btn').disabled = (currentQuestion === 0);
    document.getElementById('prev-btn').className = currentQuestion === 0 ? 
        'px-6 py-2 bg-gray-600 text-white rounded-lg font-medium opacity-50 cursor-not-allowed' :
        'px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg font-medium transition-colors';
        
    document.getElementById('next-btn').textContent = currentQuestion === totalQuestions - 1 ? 'إنهاء' : 'التالي';
}

function nextQuestion() {
    if (currentQuestion < totalQuestions - 1) {
        goToQuestion(currentQuestion + 1);
    } else {
        confirmSubmit();
    }
}

function previousQuestion() {
    if (currentQuestion > 0) {
        goToQuestion(currentQuestion - 1);
    }
}

// حفظ الإجابة
function saveAnswer(questionId, answer) {
    answers[questionId] = answer;
    
    // تحديث حالة السؤال في القائمة الجانبية
    const statusIndicator = document.getElementById(`question-status-${currentQuestion}`);
    statusIndicator.className = 'w-4 h-4 rounded-full bg-green-500';
    
    // إرسال الإجابة للخادم
    fetch(`{{ route('student.exams.save-answer', [$exam, $attempt]) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            question_id: questionId,
            answer: answer
        })
    }).catch(error => {
        console.error('Error saving answer:', error);
    });
    
    updateProgress();
}

function updateProgress() {
    const answeredCount = Object.keys(answers).length;
    document.getElementById('progress-text').textContent = `${answeredCount} / ${totalQuestions}`;
    document.getElementById('answered-count').textContent = answeredCount;
}

function loadSavedAnswers() {
    // تحميل الإجابات المحفوظة من المحاولة
    @if($attempt->answers)
        const savedAnswers = @json($attempt->answers);
        for (let questionId in savedAnswers) {
            answers[questionId] = savedAnswers[questionId];
            
            // تحديث واجهة المستخدم
            const answerInput = document.querySelector(`[name="answer_${questionId}"][value="${savedAnswers[questionId]}"]`) ||
                               document.getElementById(`answer_${questionId}`);
            
            if (answerInput) {
                if (answerInput.type === 'radio') {
                    answerInput.checked = true;
                } else {
                    answerInput.value = savedAnswers[questionId];
                }
            }
        }
        updateProgress();
    @endif
}

// تسجيل تبديل التبويب
function logTabSwitch() {
    tabSwitchCount++;
    
    fetch(`{{ route('student.exams.tab-switch', [$exam, $attempt]) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.exam_ended) {
            examEnded = true;
            clearInterval(timerInterval);
            alert(data.message);
            window.location.href = '{{ route("student.exams.index") }}';
        } else if (data.warning) {
            showTabSwitchWarning(data.message);
        }
    })
    .catch(error => {
        console.error('Error logging tab switch:', error);
    });
}

function showTabSwitchWarning(message) {
    document.getElementById('warning-message').textContent = message;
    document.getElementById('tabSwitchWarning').classList.remove('hidden');
}

function acknowledgeWarning() {
    document.getElementById('tabSwitchWarning').classList.add('hidden');
}

// تأكيد التسليم
function confirmSubmit() {
    updateProgress();
    document.getElementById('submitModal').classList.remove('hidden');
}

function closeSubmitModal() {
    document.getElementById('submitModal').classList.add('hidden');
}

function submitExam() {
    examEnded = true;
    clearInterval(timerInterval);
    
    // إرسال نموذج التسليم
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("student.exams.submit", [$exam, $attempt]) }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    document.body.appendChild(form);
    form.submit();
}

function autoSubmitExam() {
    examEnded = true;
    clearInterval(timerInterval);
    
    alert('انتهى الوقت المحدد للامتحان. سيتم تسليم إجاباتك تلقائياً.');
    
    // تسليم تلقائي
    fetch(`{{ route('student.exams.submit', [$exam, $attempt]) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '{{ route("student.exams.index") }}';
        }
    })
    .catch(error => {
        console.error('Error auto-submitting exam:', error);
        window.location.href = '{{ route("student.exams.index") }}';
    });
}

// منع التلاعب
Object.defineProperty(console, 'log', {
    value: function() {
        logTabSwitch();
    }
});
</script>

<style>
/* إخفاء شريط التمرير وحماية إضافية */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #374151;
}

::-webkit-scrollbar-thumb {
    background: #6b7280;
    border-radius: 3px;
}

/* منع التحديد */
* {
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
    -webkit-user-drag: none !important;
}

/* السماح بالتحديد في حقول الإدخال فقط */
input, textarea {
    -webkit-user-select: text !important;
    -moz-user-select: text !important;
    -ms-user-select: text !important;
    user-select: text !important;
}

/* منع الطباعة */
@media print {
    body { display: none !important; }
}
</style>
@endpush
@endsection

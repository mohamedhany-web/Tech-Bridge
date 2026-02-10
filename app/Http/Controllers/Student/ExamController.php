<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * عرض قائمة الامتحانات المتاحة للطالب
     */
    public function index()
    {
        $user = Auth::user();
        
        // الحصول على الامتحانات من الكورسات المفعلة للطالب
        $availableExams = Exam::whereIn('advanced_course_id', $user->activeCourses()->pluck('advanced_courses.id'))
                             ->available()
                             ->with(['course.academicSubject', 'lesson'])
                             ->orderBy('created_at', 'desc')
                             ->get();

        // إضافة معلومات المحاولات لكل امتحان
        $availableExams->each(function($exam) use ($user) {
            $exam->user_attempts = $exam->attempts()->where('user_id', $user->id)->count();
            $exam->can_attempt = $exam->canAttempt($user->id);
            $exam->last_attempt = $exam->getLastAttempt($user->id);
            $exam->best_score = $exam->getBestScore($user->id);
        });

        return view('student.exams.index', compact('availableExams'));
    }

    /**
     * عرض تفاصيل الامتحان قبل البدء
     */
    public function show(Exam $exam)
    {
        $user = Auth::user();

        // التحقق من إمكانية الوصول للامتحان
        if (!$user->isEnrolledIn($exam->advanced_course_id)) {
            return redirect()->route('my-courses.index')
                ->with('error', 'غير مصرح لك بالوصول لهذا الامتحان');
        }

        if (!$exam->isAvailable()) {
            return redirect()->route('student.exams.index')
                ->with('error', 'الامتحان غير متاح حالياً');
        }

        if (!$exam->canAttempt($user->id)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'لقد استنفدت عدد المحاولات المسموحة');
        }

        $exam->load(['course.academicSubject', 'lesson']);
        
        // معلومات المحاولات السابقة
        $previousAttempts = $exam->attempts()
                               ->where('user_id', $user->id)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('student.exams.show', compact('exam', 'previousAttempts'));
    }

    /**
     * بدء الامتحان
     */
    public function start(Exam $exam)
    {
        $user = Auth::user();

        // التحقق من الصلاحيات
        if (!$user->isEnrolledIn($exam->advanced_course_id) || !$exam->canAttempt($user->id)) {
            return redirect()->route('student.exams.index')
                ->with('error', 'غير مصرح لك ببدء هذا الامتحان');
        }

        // التحقق من عدم وجود محاولة جارية
        $activeAttempt = $exam->attempts()
                            ->where('user_id', $user->id)
                            ->where('status', 'in_progress')
                            ->first();

        if ($activeAttempt) {
            return redirect()->route('student.exams.take', [$exam, $activeAttempt]);
        }

        // إنشاء محاولة جديدة
        $attempt = ExamAttempt::create([
            'exam_id' => $exam->id,
            'user_id' => $user->id,
            'started_at' => now(),
            'status' => 'in_progress',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'answers' => [],
            'tab_switches' => 0,
            'suspicious_activities' => [],
        ]);

        return redirect()->route('student.exams.take', [$exam, $attempt]);
    }

    /**
     * أداء الامتحان
     */
    public function take(Exam $exam, ExamAttempt $attempt)
    {
        $user = Auth::user();

        // التحقق من الصلاحيات
        if ($attempt->user_id !== $user->id || $attempt->exam_id !== $exam->id) {
            return redirect()->route('student.exams.index')
                ->with('error', 'غير مصرح لك بالوصول لهذه المحاولة');
        }

        // التحقق من حالة المحاولة
        if ($attempt->status !== 'in_progress') {
            return redirect()->route('student.exams.result', [$exam, $attempt]);
        }

        // التحقق من انتهاء الوقت
        if ($attempt->isTimeExpired()) {
            return $this->autoSubmit($exam, $attempt);
        }

        $exam->load(['examQuestions.question.category']);

        // ترتيب الأسئلة
        $questions = $exam->examQuestions;
        if ($exam->randomize_questions) {
            $questions = $questions->shuffle();
        }

        return view('student.exams.take', compact('exam', 'attempt', 'questions'));
    }

    /**
     * حفظ إجابة
     */
    public function saveAnswer(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->status !== 'in_progress') {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        if ($attempt->isTimeExpired()) {
            return response()->json(['error' => 'انتهى الوقت المحدد'], 410);
        }

        $answers = $attempt->answers ?? [];
        $answers[$request->question_id] = $request->answer;

        $attempt->update(['answers' => $answers]);

        return response()->json(['success' => true, 'message' => 'تم حفظ الإجابة']);
    }

    /**
     * تسليم الامتحان
     */
    public function submit(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->status !== 'in_progress') {
            return redirect()->route('student.exams.index')
                ->with('error', 'غير مصرح لك بتسليم هذا الامتحان');
        }

        return $this->completeAttempt($exam, $attempt, false);
    }

    /**
     * تسليم تلقائي عند انتهاء الوقت
     */
    public function autoSubmit(Exam $exam, ExamAttempt $attempt)
    {
        return $this->completeAttempt($exam, $attempt, true);
    }

    /**
     * إكمال المحاولة وحساب النتيجة
     */
    private function completeAttempt(Exam $exam, ExamAttempt $attempt, $autoSubmitted = false)
    {
        $timeTaken = now()->diffInSeconds($attempt->started_at);

        $attempt->update([
            'status' => 'completed',
            'submitted_at' => now(),
            'time_taken' => $timeTaken,
            'auto_submitted' => $autoSubmitted,
        ]);

        // حساب النتيجة
        $attempt->calculateScore();

        if ($exam->show_results_immediately) {
            return redirect()->route('student.exams.result', [$exam, $attempt]);
        }

        return redirect()->route('student.exams.index')
            ->with('success', 'تم تسليم الامتحان بنجاح. ستظهر النتيجة لاحقاً.');
    }

    /**
     * عرض نتيجة الامتحان
     */
    public function result(Exam $exam, ExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id) {
            return redirect()->route('student.exams.index')
                ->with('error', 'غير مصرح لك بعرض هذه النتيجة');
        }

        if (!$exam->show_results_immediately && $attempt->status === 'completed') {
            return redirect()->route('student.exams.index')
                ->with('info', 'ستظهر النتيجة لاحقاً');
        }

        $attempt->load(['exam.examQuestions.question']);

        return view('student.exams.result', compact('exam', 'attempt'));
    }

    /**
     * تسجيل تبديل التبويب
     */
    public function logTabSwitch(Exam $exam, ExamAttempt $attempt)
    {
        $user = Auth::user();

        if ($attempt->user_id !== $user->id || $attempt->status !== 'in_progress') {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $attempt->incrementTabSwitches();

        // إنهاء الامتحان إذا كان منع تبديل التبويبات مفعل
        if ($exam->prevent_tab_switch && $attempt->tab_switches >= 3) {
            $this->completeAttempt($exam, $attempt, true);
            return response()->json([
                'exam_ended' => true,
                'message' => 'تم إنهاء الامتحان بسبب تبديل التبويبات المتكرر'
            ]);
        }

        return response()->json([
            'warning' => true,
            'tab_switches' => $attempt->tab_switches,
            'message' => 'تحذير: تم رصد تبديل التبويب. المحاولة رقم ' . $attempt->tab_switches
        ]);
    }
}

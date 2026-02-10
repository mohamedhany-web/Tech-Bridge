<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCourseController extends Controller
{
    /**
     * عرض الكورسات المفعلة للطالب
     */
    public function index()
    {
        $user = Auth::user();
        
        // الكورسات المفعلة للطالب
        $activeCourses = $user->activeCourses()
            ->with(['academicYear', 'academicSubject', 'teacher', 'lessons'])
            ->paginate(12);

        // إحصائيات
        $stats = [
            'total_active' => $user->activeCourses()->count(),
            'total_completed' => $user->courseEnrollments()->where('status', 'completed')->count(),
            'total_hours' => $user->activeCourses()->sum('duration_hours'),
            'avg_progress' => $this->calculateAverageProgress($user),
        ];

        return view('student.my-courses.index', compact('activeCourses', 'stats'));
    }

    /**
     * عرض تفاصيل الكورس المفعل
     */
    public function show($courseId)
    {
        $user = Auth::user();
        
        // التحقق من أن الطالب مسجل في الكورس
        $course = $user->activeCourses()
            ->with([
                'academicYear', 
                'academicSubject', 
                'teacher', 
                'lessons.progress' => function($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
                'lectures' => function($query) {
                    $query->orderBy('scheduled_at', 'desc');
                },
                'lectures.lesson',
                'lectures.instructor'
            ])
            ->findOrFail($courseId);

        // حساب التقدم
        $totalLessons = $course->lessons->count();
        $completedLessons = $course->lessons->filter(function($lesson) {
            return $lesson->progress->isNotEmpty() && $lesson->progress->first()->is_completed;
        })->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0;

        // تجميع المحاضرات حسب الدرس
        $lecturesByLesson = $course->lectures->groupBy('course_lesson_id');

        return view('student.my-courses.show', compact('course', 'progress', 'totalLessons', 'completedLessons', 'lecturesByLesson'));
    }

    /**
     * عرض تفاصيل المحاضرة للطالب (رابط الدخول، التسجيل، الوصف، ملاحظات المدرب)
     */
    public function showLecture($courseId, $lectureId)
    {
        $user = Auth::user();

        $course = $user->activeCourses()
            ->with(['academicYear', 'academicSubject', 'teacher'])
            ->findOrFail($courseId);

        $lecture = $course->lectures()
            ->with(['lesson', 'instructor'])
            ->findOrFail($lectureId);

        return view('student.my-courses.lecture-show', compact('course', 'lecture'));
    }

    /**
     * عرض الدرس في واجهة محمية
     */
    public function watchLesson($courseId, $lessonId)
    {
        $user = Auth::user();
        
        // التحقق من أن الطالب مسجل في الكورس
        $course = $user->activeCourses()->findOrFail($courseId);
        $lesson = $course->lessons()->findOrFail($lessonId);
        
        // التحقق من أن الدرس نشط
        if (!$lesson->is_active) {
            return redirect()->route('my-courses.show', $course)
                ->with('error', 'هذا الدرس غير متاح حالياً');
        }
        
        // التحقق من ترتيب الدروس (لا يمكن مشاهدة درس قبل إكمال السابق)
        $previousLessons = $course->lessons()
            ->where('order', '<', $lesson->order)
            ->where('is_active', true)
            ->get();
            
        foreach ($previousLessons as $prevLesson) {
            $prevProgress = \App\Models\LessonProgress::where('user_id', $user->id)
                ->where('course_lesson_id', $prevLesson->id)
                ->first();
                
            if (!$prevProgress || !$prevProgress->is_completed) {
                return redirect()->route('my-courses.show', $course)
                    ->with('error', 'يجب إكمال الدروس السابقة أولاً');
            }
        }
        
        return view('student.my-courses.lesson-viewer', compact('course', 'lesson'));
    }

    /**
     * حساب متوسط التقدم
     */
    private function calculateAverageProgress($user)
    {
        $enrollments = $user->courseEnrollments()->where('status', 'active')->get();
        if ($enrollments->isEmpty()) return 0;
        
        $totalProgress = $enrollments->sum('progress');
        return round($totalProgress / $enrollments->count(), 1);
    }

    /**
     * تحديث تقدم الدرس
     */
    public function updateLessonProgress(Request $request, $courseId, $lessonId)
    {
        $user = Auth::user();
        
        // التحقق من أن الطالب مسجل في الكورس
        $course = $user->activeCourses()->findOrFail($courseId);
        $lesson = $course->lessons()->findOrFail($lessonId);

        $watchTime = $request->input('watch_time', 0);
        $progressPercent = $request->input('progress_percent', 0);
        $isCompleted = $request->boolean('completed') || $progressPercent >= 90;

        // تحديث أو إنشاء تقدم الدرس
        $progress = \App\Models\LessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_lesson_id' => $lessonId
            ],
            [
                'is_completed' => $isCompleted,
                'completed_at' => $isCompleted ? now() : null,
                'watch_time' => $watchTime
            ]
        );

        // تحديث التقدم الإجمالي للكورس
        $this->updateCourseProgress($user->id, $courseId);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث التقدم بنجاح',
            'progress' => $progress,
            'course_progress' => $this->getCourseProgress($user->id, $courseId)
        ]);
    }

    /**
     * الحصول على تقدم الكورس
     */
    private function getCourseProgress($userId, $courseId)
    {
        $course = \App\Models\AdvancedCourse::findOrFail($courseId);
        $totalLessons = $course->lessons()->where('is_active', true)->count();
        
        if ($totalLessons === 0) return 0;

        $completedLessons = \App\Models\LessonProgress::where('user_id', $userId)
            ->whereIn('course_lesson_id', $course->lessons()->where('is_active', true)->pluck('id'))
            ->where('is_completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    /**
     * تحديث التقدم الإجمالي للكورس
     */
    private function updateCourseProgress($userId, $courseId)
    {
        $course = \App\Models\AdvancedCourse::findOrFail($courseId);
        $totalLessons = $course->lessons()->count();
        
        if ($totalLessons > 0) {
            $completedLessons = \App\Models\LessonProgress::where('user_id', $userId)
                ->whereIn('course_lesson_id', $course->lessons()->pluck('id'))
                ->where('is_completed', true)
                ->count();

            $progressPercentage = round(($completedLessons / $totalLessons) * 100, 2);

            // تحديث التقدم في جدول التسجيلات
            \App\Models\StudentCourseEnrollment::where('user_id', $userId)
                ->where('advanced_course_id', $courseId)
                ->update(['progress' => $progressPercentage]);
        }
    }
}

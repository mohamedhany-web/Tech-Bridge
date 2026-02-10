<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\AdvancedCourse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Assignment::with(['course', 'lesson', 'teacher'])
            ->withCount('submissions');
        
        // فلترة حسب الكورس
        if ($request->filled('course_id')) {
            $query->where(function($q) use ($request) {
                $q->where('advanced_course_id', $request->course_id)
                  ->orWhere('course_id', $request->course_id);
            });
        }
        
        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $assignments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        $stats = [
            'total' => Assignment::count(),
            'published' => Assignment::where('status', 'published')->count(),
            'draft' => Assignment::where('status', 'draft')->count(),
            'archived' => Assignment::where('status', 'archived')->count(),
            'total_submissions' => AssignmentSubmission::count(),
        ];
        
        return view('admin.assignments.index', compact('assignments', 'courses', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        return view('admin.assignments.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'advanced_course_id' => 'required|exists:advanced_courses,id',
            'lesson_id' => 'nullable|exists:course_lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'required|integer|min:1|max:1000',
            'allow_late_submission' => 'boolean',
            'status' => 'required|in:draft,published,archived',
        ], [
            'advanced_course_id.required' => 'يجب اختيار الكورس',
            'advanced_course_id.exists' => 'الكورس المحدد غير موجود',
            'title.required' => 'عنوان الواجب مطلوب',
            'max_score.min' => 'الحد الأدنى للدرجة هو 1',
            'max_score.max' => 'الحد الأقصى للدرجة هو 1000',
        ]);
        
        // التحقق من أن الدرس يخص الكورس إذا تم تحديده
        if ($validated['lesson_id']) {
            $lesson = \App\Models\CourseLesson::where('id', $validated['lesson_id'])
                ->where('advanced_course_id', $validated['advanced_course_id'])
                ->firstOrFail();
        }
        
        $validated['teacher_id'] = auth()->id();
        $validated['allow_late_submission'] = $request->has('allow_late_submission');
        
        $assignment = Assignment::create($validated);
        
        return redirect()->route('admin.assignments.show', $assignment)
            ->with('success', 'تم إنشاء الواجب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        $assignment->load(['course', 'lesson', 'teacher', 'submissions.student']);
        
        // جلب الطلاب المسجلين في الكورس
        $courseId = $assignment->advanced_course_id ?? $assignment->course_id;
        $enrollments = \App\Models\StudentCourseEnrollment::where('advanced_course_id', $courseId)
            ->where('status', 'active')
            ->with('user')
            ->get();
        
        // جلب التسليمات
        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->with(['student', 'grader'])
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);
        
        // إحصائيات
        $submissionStats = [
            'total' => $submissions->total(),
            'submitted' => AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('status', 'submitted')->count(),
            'graded' => AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('status', 'graded')->count(),
            'returned' => AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('status', 'returned')->count(),
        ];
        
        return view('admin.assignments.show', compact('assignment', 'enrollments', 'submissions', 'submissionStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        $courseId = $assignment->advanced_course_id ?? $assignment->course_id;
        $lessons = \App\Models\CourseLesson::where('advanced_course_id', $courseId)
            ->orderBy('order')
            ->get();
        
        return view('admin.assignments.edit', compact('assignment', 'courses', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'advanced_course_id' => 'required|exists:advanced_courses,id',
            'lesson_id' => 'nullable|exists:course_lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'required|integer|min:1|max:1000',
            'allow_late_submission' => 'boolean',
            'status' => 'required|in:draft,published,archived',
        ]);
        
        // التحقق من أن الدرس يخص الكورس إذا تم تحديده
        if ($validated['lesson_id']) {
            $lesson = \App\Models\CourseLesson::where('id', $validated['lesson_id'])
                ->where('advanced_course_id', $validated['advanced_course_id'])
                ->firstOrFail();
        }
        
        $validated['allow_late_submission'] = $request->has('allow_late_submission');
        
        $assignment->update($validated);
        
        return redirect()->route('admin.assignments.show', $assignment)
            ->with('success', 'تم تحديث الواجب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        
        return redirect()->route('admin.assignments.index')
            ->with('success', 'تم حذف الواجب بنجاح');
    }

    /**
     * عرض تسليمات الواجب
     */
    public function submissions(Assignment $assignment)
    {
        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->with(['student', 'grader'])
            ->orderBy('submitted_at', 'desc')
            ->paginate(20);
        
        return view('admin.assignments.submissions', compact('assignment', 'submissions'));
    }

    /**
     * تقييم تسليم واجب
     */
    public function grade(Request $request, Assignment $assignment, AssignmentSubmission $submission)
    {
        // التحقق من أن التسليم يخص هذا الواجب
        if ($submission->assignment_id !== $assignment->id) {
            abort(404, 'التسليم غير موجود');
        }
        
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string',
            'status' => 'required|in:submitted,graded,returned',
        ]);
        
        $validated['graded_by'] = auth()->id();
        $validated['graded_at'] = now();
        
        $submission->update($validated);
        
        return back()->with('success', 'تم تقييم التسليم بنجاح');
    }
}

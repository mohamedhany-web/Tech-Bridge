<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\AdvancedCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $instructor = Auth::user();
        
        // جلب الكورسات التي تم تعيينها لهذا المدرس
        $query = AdvancedCourse::where('instructor_id', $instructor->id)
            ->with(['academicYear', 'academicSubject'])
            ->withCount(['lessons', 'enrollments']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(15);

        // إحصائيات
        $stats = [
            'total' => AdvancedCourse::where('instructor_id', $instructor->id)->count(),
            'active' => AdvancedCourse::where('instructor_id', $instructor->id)->where('is_active', true)->count(),
            'inactive' => AdvancedCourse::where('instructor_id', $instructor->id)->where('is_active', false)->count(),
            'total_students' => \App\Models\StudentCourseEnrollment::whereHas('course', function($q) use ($instructor) {
                $q->where('instructor_id', $instructor->id);
            })->where('status', 'active')->count(),
        ];

        return view('instructor.courses.index', compact('courses', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $instructor = Auth::user();
        
        $course = AdvancedCourse::where('instructor_id', $instructor->id)
            ->with(['academicYear', 'academicSubject', 'instructor', 'lessons'])
            ->withCount(['lessons', 'enrollments'])
            ->findOrFail($id);

        // الطلاب المسجلين
        $enrollments = \App\Models\StudentCourseEnrollment::where('advanced_course_id', $course->id)
            ->with('user')
            ->where('status', 'active')
            ->latest()
            ->paginate(20);

        return view('instructor.courses.show', compact('course', 'enrollments'));
    }
}

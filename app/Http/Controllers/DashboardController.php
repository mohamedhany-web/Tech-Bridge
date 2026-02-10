<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Order;
use App\Models\AdvancedCourse;
use App\Models\ContactMessage;
use App\Models\LectureAssignment;
use App\Models\Exam;
use App\Models\Certificate;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/login')->with('error', 'يجب تسجيل الدخول أولاً');
        }
        
        // إعادة توليد Session ID لمنع Session Fixation
        $request->session()->regenerate();
        
        // التحقق من أن المستخدم نشط
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'حسابك غير نشط. يرجى التواصل مع الإدارة.');
        }
        
        // التحقق من وجود دور للمستخدم
        if (!$user->role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'دور المستخدم غير محدد. يرجى التواصل مع الإدارة.');
        }
        
        // دعم الأدوار القديمة والجديدة للتوافق
        $role = strtolower(trim($user->role));
        
        switch ($role) {
            case 'super_admin':
            case 'admin': // للتوافق مع الأدوار القديمة
                return $this->adminDashboard();
            case 'instructor':
            case 'teacher': // للتوافق مع الأدوار القديمة
                return $this->instructorDashboard();
            case 'student':
                return $this->studentDashboard();
            default:
                // إذا كان الدور غير معروف، نعيد إلى الصفحة الرئيسية مع رسالة خطأ
                Auth::logout();
                return redirect('/login')->with('error', 'دور المستخدم غير صالح: ' . $role . '. يرجى التواصل مع الإدارة.');
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::whereIn('role', ['student'])->count(),
            'total_instructors' => User::whereIn('role', ['instructor', 'teacher'])->count(),
            'total_courses' => \App\Models\AdvancedCourse::count(),
            'total_subjects' => \App\Models\AcademicSubject::count(),
            // إحصائيات المحاسبة
            'total_revenue' => \App\Models\Payment::where('status', 'completed')->sum('amount'),
            'pending_invoices' => \App\Models\Invoice::where('status', 'pending')->count(),
            'overdue_invoices' => \App\Models\Invoice::where('status', 'overdue')->count(),
            'total_enrollments' => \App\Models\StudentCourseEnrollment::where('status', 'active')->count(),
            'active_coupons' => \App\Models\Coupon::where('is_active', true)->count(),
            'monthly_revenue' => \App\Models\Payment::where('status', 'completed')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
        ];

        $recent_users = User::latest()->take(5)->get();
        
        // جلب الكورسات مع العلاقات بشكل آمن
        $recent_courses = \App\Models\AdvancedCourse::with(['academicSubject'])
            ->latest()
            ->take(5)
            ->get();
            
        // الفواتير المعلقة
        $pending_invoices = \App\Models\Invoice::where('status', 'pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // المدفوعات الأخيرة
        $recent_payments = \App\Models\Payment::where('status', 'completed')
            ->with(['user', 'invoice'])
            ->latest()
            ->take(5)
            ->get();

        $activeUsersCount = User::where('is_active', true)->count();
        $latestActiveUser = User::where('is_active', true)->latest()->first();

        $activeCoursesCount = AdvancedCourse::where('is_active', true)->count();
        $latestActiveCourse = AdvancedCourse::where('is_active', true)->latest()->first();

        $pendingInvoicesCount = \App\Models\Invoice::where('status', 'pending')->count();
        $latestPendingInvoice = \App\Models\Invoice::where('status', 'pending')->latest()->first();

        $newMessagesCount = ContactMessage::new()->count();
        $latestNewMessage = ContactMessage::new()->latest()->first();

        $quickActions = [
            [
                'title' => 'المستخدمون النشطون',
                'count' => $activeUsersCount,
                'meta' => $activeUsersCount > 0
                    ? 'آخر تسجيل: ' . optional(optional($latestActiveUser)->created_at)->diffForHumans()
                    : 'لا يوجد مستخدمون نشطون',
                'icon' => 'fas fa-users',
                'background' => 'from-sky-100 to-sky-50',
                'icon_background' => 'from-sky-500 to-sky-600',
                'cta' => 'عرض المستخدمين',
                'route' => route('admin.users'),
            ],
            [
                'title' => 'الكورسات النشطة',
                'count' => $activeCoursesCount,
                'meta' => $activeCoursesCount > 0
                    ? 'آخر تحديث: ' . optional(optional($latestActiveCourse)->updated_at ?? optional($latestActiveCourse)->created_at)->diffForHumans()
                    : 'لا توجد كورسات نشطة',
                'icon' => 'fas fa-book-open',
                'background' => 'from-emerald-100 to-green-50',
                'icon_background' => 'from-emerald-500 to-green-600',
                'cta' => 'إدارة الكورسات',
                'route' => route('admin.advanced-courses.index'),
            ],
            [
                'title' => 'فواتير معلقة',
                'count' => $pendingInvoicesCount,
                'meta' => $pendingInvoicesCount > 0
                    ? 'آخر فاتورة: ' . optional(optional($latestPendingInvoice)->created_at)->diffForHumans()
                    : 'لا توجد فواتير معلقة',
                'icon' => 'fas fa-file-invoice-dollar',
                'background' => 'from-amber-100 to-orange-50',
                'icon_background' => 'from-amber-500 to-orange-600',
                'cta' => 'مراجعة الفواتير',
                'route' => route('admin.invoices.index', ['status' => 'pending']),
            ],
            [
                'title' => 'رسائل جديدة',
                'count' => $newMessagesCount,
                'meta' => $newMessagesCount > 0
                    ? 'آخر رسالة: ' . optional(optional($latestNewMessage)->created_at)->diffForHumans()
                    : 'لا توجد رسائل جديدة',
                'icon' => 'fas fa-envelope-open-text',
                'background' => 'from-indigo-100 to-purple-50',
                'icon_background' => 'from-indigo-500 to-purple-600',
                'cta' => 'عرض الرسائل',
                'route' => route('admin.contact-messages.index'),
            ],
        ];

        return view('dashboard.admin', compact('stats', 'recent_users', 'recent_courses', 'pending_invoices', 'recent_payments', 'quickActions'));
    }

    private function instructorDashboard()
    {
        $user = Auth::user();
        
        try {
            // الكورسات
            $myCoursesQuery = \App\Models\AdvancedCourse::where('instructor_id', $user->id);
            $my_courses = $myCoursesQuery
                ->with(['academicSubject', 'academicYear'])
                ->withCount(['enrollments as active_students_count' => function($query) {
                    $query->where('status', 'active');
                }])
                ->latest()
                ->take(5)
                ->get();

            // إحصائيات حقيقية
            $stats = [
                'my_courses' => $myCoursesQuery->count(),
                'total_students' => \App\Models\StudentCourseEnrollment::whereHas('course', function($q) use ($user) {
                    $q->where('instructor_id', $user->id);
                })->where('status', 'active')->distinct('user_id')->count(),
                'my_classrooms' => Classroom::where('teacher_id', $user->id)->count(),
                'total_lectures' => \App\Models\Lecture::where('instructor_id', $user->id)->count(),
                'upcoming_lectures' => \App\Models\Lecture::where('instructor_id', $user->id)
                    ->where('status', 'scheduled')
                    ->where('scheduled_at', '>=', now())
                    ->count(),
                'total_assignments' => \App\Models\Assignment::where('teacher_id', $user->id)->count(),
                'pending_submissions' => \App\Models\AssignmentSubmission::whereHas('assignment', function($q) use ($user) {
                    $q->where('teacher_id', $user->id);
                })->whereNull('graded_at')->count(),
                'total_exams' => \App\Models\Exam::where('creator_id', $user->id)->count(),
                'total_groups' => \App\Models\Group::whereHas('course', function($q) use ($user) {
                    $q->where('instructor_id', $user->id);
                })->count(),
            ];

            // المحاضرات القادمة
            $upcoming_lectures = \App\Models\Lecture::where('instructor_id', $user->id)
                ->where('status', 'scheduled')
                ->where('scheduled_at', '>=', now())
                ->with(['course', 'lesson'])
                ->orderBy('scheduled_at', 'asc')
                ->take(5)
                ->get();

            // الواجبات المعلقة (تسليمات تحتاج تقييم)
            $pending_assignments = \App\Models\AssignmentSubmission::whereHas('assignment', function($q) use ($user) {
                    $q->where('teacher_id', $user->id);
                })
                ->whereNull('graded_at')
                ->with(['assignment', 'student'])
                ->latest()
                ->take(5)
                ->get();

            // المجموعات
            $my_groups = \App\Models\Group::whereHas('course', function($q) use ($user) {
                    $q->where('instructor_id', $user->id);
                })
                ->with(['course', 'members'])
                ->latest()
                ->take(5)
                ->get();
                
            $my_classrooms = Classroom::where('teacher_id', $user->id)
                ->with('students')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.instructor', compact(
                'stats', 
                'my_courses', 
                'my_classrooms',
                'upcoming_lectures',
                'pending_assignments',
                'my_groups'
            ));
        } catch (\Exception $e) {
            // في حالة وجود خطأ، نعيد لوحة تحكم بسيطة
            \Log::error('Instructor Dashboard Error: ' . $e->getMessage());
            $stats = [
                'my_courses' => 0,
                'total_students' => 0,
                'my_classrooms' => 0,
                'total_lectures' => 0,
                'upcoming_lectures' => 0,
                'total_assignments' => 0,
                'pending_submissions' => 0,
                'total_exams' => 0,
                'total_groups' => 0,
            ];
            $my_courses = collect();
            $my_classrooms = collect();
            $upcoming_lectures = collect();
            $pending_assignments = collect();
            $my_groups = collect();
            
            return view('dashboard.instructor', compact(
                'stats', 
                'my_courses', 
                'my_classrooms',
                'upcoming_lectures',
                'pending_assignments',
                'my_groups'
            ));
        }
    }

    private function studentDashboard()
    {
        $user = Auth::user();
        
        $activeCourses = $user->activeCourses()
            ->with(['academicYear', 'academicSubject', 'teacher'])
            ->get();

        $activeCourseIds = $activeCourses->pluck('id')->filter()->unique()->values();

        // تحميل بيانات التسجيلات لضمان توفر التقدم
        $enrollments = $user->courseEnrollments()
            ->whereIn('advanced_course_id', $activeCourseIds)
            ->whereIn('status', ['active', 'completed'])
            ->get()
            ->keyBy('advanced_course_id');

        $activeCourses->each(function ($course) use ($enrollments) {
            if ($enrollment = $enrollments->get($course->id)) {
                $course->setRelation('enrollment', $enrollment);

                if ($course->pivot) {
                    $course->pivot->progress = (float) ($course->pivot->progress ?? $enrollment->progress ?? 0);
                }
            }
        });

        $recentOrders = Order::where('user_id', $user->id)
            ->with(['course.academicYear', 'course.academicSubject'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'active_courses' => $activeCourses->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_courses' => $user->courseEnrollments()->where('status', 'completed')->count(),
            'total_progress' => $this->calculateOverallProgress($user),
            'total_learning_hours' => $activeCourseIds->isEmpty()
                ? 0
                : (int) AdvancedCourse::whereIn('id', $activeCourseIds)->sum('duration_hours'),
            'average_score' => round($user->getAverageScore(), 1),
            'completed_exams' => $user->getCompletedExamsCount(),
        ];

        $upcomingAssignments = LectureAssignment::with(['lecture.course.academicSubject'])
            ->whereHas('lecture', function ($query) use ($activeCourseIds) {
                $query->whereIn('course_id', $activeCourseIds);
            })
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhereNotIn('status', ['archived']);
            })
            ->where(function ($query) {
                $query->whereNull('due_date')
                    ->orWhere('due_date', '>=', now()->startOfDay());
            })
            ->get()
            ->sortBy(function ($assignment) {
                return $assignment->due_date ?? now()->addYear();
            })
            ->values()
            ->take(5);

        $upcomingExams = Exam::with(['course.academicSubject'])
            ->whereIn('advanced_course_id', $activeCourseIds)
            ->where('is_active', true)
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('end_time')
                    ->orWhere('end_time', '>=', now());
            })
            ->get()
            ->sortBy(function ($exam) {
                if ($exam->start_time) {
                    return $exam->start_time;
                }

                if ($exam->start_date) {
                    return $exam->start_date->startOfDay();
                }

                return $exam->created_at ?? now();
            })
            ->values()
            ->take(5);

        $recentExamAttempts = $user->examAttempts()
            ->with(['exam.course'])
            ->latest()
            ->take(5)
            ->get();

        $recentCertificates = Certificate::where('user_id', $user->id)
            ->with('course')
            ->orderByDesc('issued_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view(
            'dashboard.student',
            compact(
                'stats',
                'activeCourses',
                'recentOrders',
                'upcomingAssignments',
                'upcomingExams',
                'recentExamAttempts',
                'recentCertificates'
            )
        );
    }

    private function calculateOverallProgress($user)
    {
        $enrollments = $user->courseEnrollments()
            ->whereIn('status', ['active', 'completed'])
            ->get();
        if ($enrollments->isEmpty()) return 0;
        
        $totalProgress = $enrollments->reduce(function ($carry, $enrollment) {
            return $carry + (float) ($enrollment->progress ?? 0);
        }, 0);

        return round($totalProgress / $enrollments->count(), 1);
    }

}

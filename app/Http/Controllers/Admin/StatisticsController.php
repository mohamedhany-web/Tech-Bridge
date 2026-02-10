<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\AcademicSubject;
use App\Models\AdvancedCourse;
use App\Models\CourseEnrollment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * عرض لوحة الإحصائيات
     */
    public function index()
    {
        // إحصائيات عامة
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::whereIn('role', ['instructor', 'teacher'])->count();
        $totalTeachers = $totalInstructors; // نفس الشيء (teacher = instructor)
        $totalAcademicYears = AcademicYear::count();
        $totalSubjects = AcademicSubject::count();
        $totalCourses = AdvancedCourse::count();
        $totalEnrollments = CourseEnrollment::count();

        // إحصائيات المستخدمين الجدد (آخر 30 يوم)
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        
        // إحصائيات التسجيلات الجديدة (آخر 30 يوم)
        $newEnrollmentsThisMonth = CourseEnrollment::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // إحصائيات النشاط اليومي (آخر 7 أيام)
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $dailyActivity = ActivityLog::select(
                    DB::raw("strftime('%Y-%m-%d', created_at) as date"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $dailyActivity = ActivityLog::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // أكثر الكورسات تسجيلاً
        $popularCourses = AdvancedCourse::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(5)
            ->get();

        // توزيع المستخدمين حسب الدور
        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        // إحصائيات السنوات الدراسية
        $academicYearsStats = AcademicYear::withCount(['academicSubjects'])
            ->with(['academicSubjects'])
            ->get();
        
        // إضافة عدد الكورسات لكل سنة يدوياً (0 لأن العلاقة لم تعد موجودة)
        $academicYearsStats->each(function($year) {
            $year->courses_count = 0;
            $year->academicSubjects->each(function($subject) {
                $subject->advanced_courses_count = 0;
            });
        });

        // النشاطات الأخيرة
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.statistics.index', compact(
            'totalUsers',
            'totalStudents', 
            'totalInstructors',
            'totalTeachers',
            'totalAcademicYears',
            'totalSubjects',
            'totalCourses',
            'totalEnrollments',
            'newUsersThisMonth',
            'newEnrollmentsThisMonth',
            'dailyActivity',
            'popularCourses',
            'usersByRole',
            'academicYearsStats',
            'recentActivities'
        ));
    }

    /**
     * إحصائيات المستخدمين
     */
    public function users()
    {
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $usersPerMonth = User::select(
                    DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                    DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
        } else {
            $usersPerMonth = User::select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
        }

        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();

        return view('admin.statistics.users', compact('usersPerMonth', 'usersByRole'));
    }

    /**
     * إحصائيات الكورسات
     */
    public function courses()
    {
        $coursesStats = AdvancedCourse::withCount('enrollments')
            ->with(['academicSubject', 'academicYear'])
            ->get();

        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            $enrollmentsPerMonth = CourseEnrollment::select(
                    DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                    DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
        } else {
            $enrollmentsPerMonth = CourseEnrollment::select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
        }

        return view('admin.statistics.courses', compact('coursesStats', 'enrollmentsPerMonth'));
    }
}










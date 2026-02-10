<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

// الصفحة الرئيسية (Home) - welcome.blade.php
Route::get('/', function () {
    $academicYears = \App\Models\AcademicYear::where('is_active', true)
        ->withCount('advancedCourses')
        ->orderBy('order')
        ->get();
    
    return view('welcome', compact('academicYears'));
})->name('home');

// Route لعرض الملفات من storage (بديل للرابط الرمزي على الاستضافة)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    // التحقق من وجود الملف
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    // التحقق من أن الملف ضمن المجلد العام فقط (أمان)
    $realPath = realpath($fullPath);
    $storagePath = realpath(storage_path('app/public'));
    
    if (strpos($realPath, $storagePath) !== 0) {
        abort(403, 'Access denied');
    }
    
    // تحديد نوع الملف
    $mimeType = mime_content_type($fullPath);
    
    return response()->file($fullPath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000', // كاش لمدة سنة
    ]);
})->where('path', '.*')->name('storage.file');

// الصفحات العامة
Route::get('/about', [\App\Http\Controllers\Public\PageController::class, 'about'])->name('public.about');
Route::get('/faq', [\App\Http\Controllers\Public\PageController::class, 'faq'])->name('public.faq');
Route::get('/terms', [\App\Http\Controllers\Public\PageController::class, 'terms'])->name('public.terms');
Route::get('/privacy', [\App\Http\Controllers\Public\PageController::class, 'privacy'])->name('public.privacy');
Route::get('/pricing', [\App\Http\Controllers\Public\PageController::class, 'pricing'])->name('public.pricing');
Route::get('/team', [\App\Http\Controllers\Public\PageController::class, 'team'])->name('public.team');
Route::get('/certificates', [\App\Http\Controllers\Public\PageController::class, 'certificates'])->name('public.certificates');
Route::get('/help', [\App\Http\Controllers\Public\PageController::class, 'help'])->name('public.help');
Route::get('/refund', [\App\Http\Controllers\Public\PageController::class, 'refund'])->name('public.refund');
Route::get('/testimonials', [\App\Http\Controllers\Public\PageController::class, 'testimonials'])->name('public.testimonials');
Route::get('/events', [\App\Http\Controllers\Public\PageController::class, 'events'])->name('public.events');
Route::get('/partners', [\App\Http\Controllers\Public\PageController::class, 'partners'])->name('public.partners');

// المدونة
Route::get('/blog', [\App\Http\Controllers\Public\BlogController::class, 'index'])->name('public.blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\Public\BlogController::class, 'show'])->name('public.blog.show');

// التواصل
Route::get('/contact', [\App\Http\Controllers\Public\ContactController::class, 'index'])->name('public.contact');
Route::post('/contact', [\App\Http\Controllers\Public\ContactController::class, 'store'])->name('public.contact.store');

// معرض الصور والفيديوهات
Route::get('/media', [\App\Http\Controllers\Public\MediaController::class, 'index'])->name('public.media.index');
Route::get('/media/{media}', [\App\Http\Controllers\Public\MediaController::class, 'show'])->name('public.media.show');

// صفحة الكورسات العامة
Route::get('/courses', function () {
    $coursesQuery = \App\Models\AdvancedCourse::where('is_active', true);
    
    // جلب الكورسات مع العلاقات
    $coursesCollection = $coursesQuery
        ->with(['academicSubject', 'academicYear'])
        ->withCount('lessons')
        ->orderBy('is_featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
    
    // تحويل البيانات إلى array
    $courses = $coursesCollection->map(function ($course) {
        return [
            'id' => $course->id,
            'title' => $course->title ?? 'بدون عنوان',
            'description' => $course->description ?? '',
            'level' => $course->level ?? 'beginner',
            'price' => (float)($course->price ?? 0),
            'duration_hours' => (int)($course->duration_hours ?? 0),
            'is_featured' => (bool)($course->is_featured ?? false),
            'lessons_count' => (int)($course->lessons_count ?? 0),
            'academic_subject' => $course->academicSubject ? [
                'name' => $course->academicSubject->name ?? 'غير محدد'
            ] : null,
        ];
    })->values()->toArray();
    
    // جلب الباقات النشطة
    $packages = \App\Models\Package::active()
        ->with(['courses' => function($query) {
            $query->where('is_active', true);
        }])
        ->withCount('courses')
        ->orderBy('is_featured', 'desc')
        ->orderBy('is_popular', 'desc')
        ->orderBy('order')
        ->get();
    
    return view('courses', compact('courses', 'packages'));
})->name('public.courses');

// صفحة تفاصيل الكورس العامة
Route::get('/course/{id}', function ($id) {
    $course = \App\Models\AdvancedCourse::where('id', $id)
        ->where('is_active', true)
        ->with(['academicSubject', 'academicYear'])
        ->withCount('lessons')
        ->firstOrFail();
    
    // كورسات ذات صلة
    $relatedCourses = \App\Models\AdvancedCourse::where('is_active', true)
        ->where('id', '!=', $course->id)
        ->where(function($query) use ($course) {
            $query->where('level', $course->level)
                  ->orWhere('academic_subject_id', $course->academic_subject_id)
                  ->orWhere('is_featured', true);
        })
        ->with(['academicSubject'])
        ->withCount('lessons')
        ->limit(3)
        ->get();
    
    return view('course-show', compact('course', 'relatedCourses'));
})->name('public.course.show');

// صفحة تفاصيل الباقة
Route::get('/package/{slug}', function ($slug) {
    $package = \App\Models\Package::where('slug', $slug)
        ->where('is_active', true)
        ->with(['courses' => function($query) {
            $query->where('is_active', true)
                  ->with(['academicSubject', 'academicYear'])
                  ->withCount('lessons');
        }])
        ->firstOrFail();
    
    // باقات ذات صلة
    $relatedPackages = \App\Models\Package::where('is_active', true)
        ->where('id', '!=', $package->id)
        ->withCount('courses')
        ->limit(3)
        ->get();
    
    return view('package-show', compact('package', 'relatedPackages'));
})->name('public.package.show');

// مسارات المصادقة - محمية بـ Rate Limiting
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    // Rate Limiting: 5 محاولات كل دقيقة
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Rate Limiting: 3 محاولات كل ساعة
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,60');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// مسارات لوحة التحكم - محمية بـ authentication
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // مسارات الطلاب
    Route::get('/academic-years', [\App\Http\Controllers\Student\AcademicYearController::class, 'index'])->name('academic-years');
    Route::get('/academic-years/{academicYear}/subjects', [\App\Http\Controllers\Student\AcademicYearController::class, 'subjects'])->name('academic-years.subjects');
    Route::get('/subjects/{academicSubject}/courses', [\App\Http\Controllers\Student\SubjectController::class, 'courses'])->name('subjects.courses');
    Route::get('/courses/{advancedCourse}', [\App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
    
    // كورساتي المفعلة
    Route::get('/my-courses', [\App\Http\Controllers\Student\MyCourseController::class, 'index'])->name('my-courses.index');
    Route::get('/my-courses/{course}', [\App\Http\Controllers\Student\MyCourseController::class, 'show'])->name('my-courses.show');
    Route::get('/my-courses/{course}/lectures/{lecture}', [\App\Http\Controllers\Student\MyCourseController::class, 'showLecture'])->name('my-courses.lectures.show');
    Route::get('/my-courses/{course}/lessons/{lesson}/watch', [\App\Http\Controllers\Student\MyCourseController::class, 'watchLesson'])
        ->middleware(\App\Http\Middleware\VideoProtectionMiddleware::class)
        ->name('my-courses.lesson.watch');
    Route::post('/my-courses/{course}/lessons/{lesson}/progress', [\App\Http\Controllers\Student\MyCourseController::class, 'updateLessonProgress'])->name('my-courses.lesson.progress');
    
    // الإحالات
    Route::get('/referrals', [\App\Http\Controllers\Student\ReferralController::class, 'index'])->name('referrals.index');
    Route::post('/referrals/copy-link', [\App\Http\Controllers\Student\ReferralController::class, 'copyLink'])->name('referrals.copy-link');
    
    // API للتحقق من الكوبون
    Route::post('/api/validate-coupon', [\App\Http\Controllers\Student\CouponController::class, 'validateCoupon'])->name('api.validate-coupon');
    
    // API للدروس
    Route::get('/api/lessons/{lesson}', function(\App\Models\CourseLesson $lesson) {
        // التحقق من أن المستخدم مسجل في الكورس
        $user = auth()->user();
        if (!$user->isEnrolledIn($lesson->advanced_course_id)) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }
        
        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'content' => $lesson->content,
            'type' => $lesson->type,
            'video_url' => $lesson->video_url,
            'duration_minutes' => $lesson->duration_minutes,
            'attachments' => $lesson->attachments ? json_decode($lesson->attachments, true) : null
        ]);
    });

    // نظام الطلبات
    Route::post('/courses/{advancedCourse}/order', [\App\Http\Controllers\Student\OrderController::class, 'store'])->name('courses.order');
    Route::get('/orders', [\App\Http\Controllers\Student\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Student\OrderController::class, 'show'])->name('orders.show');
    
    // امتحانات الطلاب
    Route::prefix('exams')->name('student.exams.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Student\ExamController::class, 'index'])->name('index');
        Route::get('/{exam}', [\App\Http\Controllers\Student\ExamController::class, 'show'])->name('show');
        Route::post('/{exam}/start', [\App\Http\Controllers\Student\ExamController::class, 'start'])->name('start');
        Route::get('/{exam}/attempts/{attempt}/take', [\App\Http\Controllers\Student\ExamController::class, 'take'])
            ->middleware(\App\Http\Middleware\VideoProtectionMiddleware::class)
            ->name('take');
        Route::post('/{exam}/attempts/{attempt}/save-answer', [\App\Http\Controllers\Student\ExamController::class, 'saveAnswer'])->name('save-answer');
        Route::post('/{exam}/attempts/{attempt}/submit', [\App\Http\Controllers\Student\ExamController::class, 'submit'])->name('submit');
        Route::get('/{exam}/attempts/{attempt}/result', [\App\Http\Controllers\Student\ExamController::class, 'result'])->name('result');
        Route::post('/{exam}/attempts/{attempt}/tab-switch', [\App\Http\Controllers\Student\ExamController::class, 'logTabSwitch'])->name('tab-switch');
    });

    // صفحات الطلاب
    Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [\App\Http\Controllers\Student\SettingsController::class, 'index'])->name('settings');
    Route::get('/notifications', [\App\Http\Controllers\Student\NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/{notification}', [\App\Http\Controllers\Student\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{notification}/mark-read', [\App\Http\Controllers\Student\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Student\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\Student\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/cleanup', [\App\Http\Controllers\Student\NotificationController::class, 'cleanup'])->name('notifications.cleanup');
    Route::get('/api/notifications/unread-count', [\App\Http\Controllers\Student\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/api/notifications/recent', [\App\Http\Controllers\Student\NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::get('/calendar', [\App\Http\Controllers\Student\CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/create', [\App\Http\Controllers\Student\CalendarController::class, 'create'])->name('calendar.create');
    Route::post('/calendar', [\App\Http\Controllers\Student\CalendarController::class, 'store'])->name('calendar.store');
    Route::get('/calendar/{event}/edit', [\App\Http\Controllers\Student\CalendarController::class, 'edit'])->name('calendar.edit');
    Route::put('/calendar/{event}', [\App\Http\Controllers\Student\CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/{event}', [\App\Http\Controllers\Student\CalendarController::class, 'destroy'])->name('calendar.destroy');
    
    // مسارات الإدارة - محمية بصلاحيات الإدارة
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        
        // إدارة المستخدمين
        Route::get('/users', [\App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [\App\Http\Controllers\Admin\AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('users.delete');
        
        // إدارة السنوات الدراسية
        Route::resource('academic-years', \App\Http\Controllers\Admin\AcademicYearController::class);
        Route::post('/academic-years/{academicYear}/toggle-status', [\App\Http\Controllers\Admin\AcademicYearController::class, 'toggleStatus'])->name('academic-years.toggle-status');
        Route::post('/academic-years/reorder', [\App\Http\Controllers\Admin\AcademicYearController::class, 'reorder'])->name('academic-years.reorder');

        // إدارة المواد الدراسية
        // إدارة الكورسات المتطورة
        Route::resource('advanced-courses', \App\Http\Controllers\Admin\AdvancedCourseController::class);
        Route::post('/advanced-courses/{advancedCourse}/activate-student', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'activateStudent'])->name('advanced-courses.activate-student');
        Route::get('/advanced-courses/{advancedCourse}/students', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'students'])->name('advanced-courses.students');
        Route::post('/advanced-courses/{advancedCourse}/toggle-status', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'toggleStatus'])->name('advanced-courses.toggle-status');
        Route::post('/advanced-courses/{advancedCourse}/toggle-featured', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'toggleFeatured'])->name('advanced-courses.toggle-featured');
        Route::get('/advanced-courses/{advancedCourse}/orders', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'orders'])->name('advanced-courses.orders');
        Route::get('/advanced-courses/{advancedCourse}/statistics', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'statistics'])->name('advanced-courses.statistics');
        Route::post('/advanced-courses/{advancedCourse}/duplicate', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'duplicate'])->name('advanced-courses.duplicate');
        Route::get('/get-subjects-by-year', [\App\Http\Controllers\Admin\AdvancedCourseController::class, 'getSubjectsByYear'])->name('advanced-courses.get-subjects-by-year');
        Route::get('/courses/{course}/lessons-list', function(\App\Models\AdvancedCourse $course) {
            return response()->json($course->lessons()->active()->select('id', 'title')->get());
        });

        // إدارة دروس الكورسات
        Route::prefix('courses/{course}/lessons')->name('courses.lessons.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\CourseLessonController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\CourseLessonController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\CourseLessonController::class, 'store'])->name('store');
            Route::get('/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'show'])->name('show');
            Route::get('/{lesson}/edit', [\App\Http\Controllers\Admin\CourseLessonController::class, 'edit'])->name('edit');
            Route::put('/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'update'])->name('update');
            Route::delete('/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'destroy'])->name('destroy');
            Route::post('/{lesson}/toggle-status', [\App\Http\Controllers\Admin\CourseLessonController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/reorder', [\App\Http\Controllers\Admin\CourseLessonController::class, 'reorder'])->name('reorder');
        });

        // إدارة بنك الأسئلة
        Route::prefix('question-bank')->name('question-bank.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\QuestionBankController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\QuestionBankController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\QuestionBankController::class, 'store'])->name('store');
            Route::get('/{question}', [\App\Http\Controllers\Admin\QuestionBankController::class, 'show'])->name('show');
            Route::get('/{question}/edit', [\App\Http\Controllers\Admin\QuestionBankController::class, 'edit'])->name('edit');
            Route::put('/{question}', [\App\Http\Controllers\Admin\QuestionBankController::class, 'update'])->name('update');
            Route::delete('/{question}', [\App\Http\Controllers\Admin\QuestionBankController::class, 'destroy'])->name('destroy');
            Route::post('/{question}/duplicate', [\App\Http\Controllers\Admin\QuestionBankController::class, 'duplicate'])->name('duplicate');
            Route::post('/export', [\App\Http\Controllers\Admin\QuestionBankController::class, 'export'])->name('export');
            Route::post('/import', [\App\Http\Controllers\Admin\QuestionBankController::class, 'import'])->name('import');
        });

        // إدارة تصنيفات الأسئلة
        Route::prefix('question-categories')->name('question-categories.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'store'])->name('store');
            Route::get('/{questionCategory}', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'show'])->name('show');
            Route::get('/{questionCategory}/edit', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'edit'])->name('edit');
            Route::put('/{questionCategory}', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'update'])->name('update');
            Route::delete('/{questionCategory}', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'destroy'])->name('destroy');
            Route::post('/reorder', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'reorder'])->name('reorder');
            Route::get('/subjects-by-year/{year}', [\App\Http\Controllers\Admin\QuestionCategoryController::class, 'getSubjectsByYear'])->name('subjects-by-year');
        });

        // إدارة الامتحانات
        Route::prefix('exams')->name('exams.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ExamController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\ExamController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ExamController::class, 'store'])->name('store');
            Route::get('/{exam}', [\App\Http\Controllers\Admin\ExamController::class, 'show'])->name('show');
            Route::get('/{exam}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'edit'])->name('edit');
            Route::put('/{exam}', [\App\Http\Controllers\Admin\ExamController::class, 'update'])->name('update');
            Route::delete('/{exam}', [\App\Http\Controllers\Admin\ExamController::class, 'destroy'])->name('destroy');
            Route::get('/{exam}/questions', [\App\Http\Controllers\Admin\ExamController::class, 'manageQuestions'])->name('questions.manage');
            Route::post('/{exam}/questions', [\App\Http\Controllers\Admin\ExamController::class, 'addQuestion'])->name('questions.add');
            Route::delete('/{exam}/questions/{examQuestion}', [\App\Http\Controllers\Admin\ExamController::class, 'removeQuestion'])->name('questions.remove');
            Route::post('/{exam}/questions/reorder', [\App\Http\Controllers\Admin\ExamController::class, 'reorderQuestions'])->name('questions.reorder');
            Route::post('/{exam}/toggle-publish', [\App\Http\Controllers\Admin\ExamController::class, 'togglePublish'])->name('toggle-publish');
            Route::post('/{exam}/toggle-status', [\App\Http\Controllers\Admin\ExamController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/{exam}/statistics', [\App\Http\Controllers\Admin\ExamController::class, 'statistics'])->name('statistics');
            Route::get('/{exam}/preview', [\App\Http\Controllers\Admin\ExamController::class, 'preview'])->name('preview');
            Route::post('/{exam}/duplicate', [\App\Http\Controllers\Admin\ExamController::class, 'duplicate'])->name('duplicate');
        });

        // إدارة المواد الدراسية القديمة
        Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);

        // إدارة الكورسات القديمة
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

        // سجل النشاطات
        Route::get('/activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log');
        Route::get('/activity-log/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-log.show');
        Route::post('/activity-log/clear', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity-log.destroy');

        // الإحصائيات
        Route::get('/statistics', [\App\Http\Controllers\Admin\StatisticsController::class, 'index'])->name('statistics.index');
        Route::get('/statistics/users', [\App\Http\Controllers\Admin\StatisticsController::class, 'users'])->name('statistics.users');
        Route::get('/statistics/courses', [\App\Http\Controllers\Admin\StatisticsController::class, 'courses'])->name('statistics.courses');

        // إدارة الطلبات
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/approve', [\App\Http\Controllers\Admin\OrderController::class, 'approve'])->name('orders.approve');
        Route::post('/orders/{order}/reject', [\App\Http\Controllers\Admin\OrderController::class, 'reject'])->name('orders.reject');

        // إدارة الصلاحيات والأدوار
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::post('/roles/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
        // Route::post('/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'updateRoles'])->name('users.update-roles');
        
        // إدارة صلاحيات المستخدمين
        Route::get('/user-permissions', [\App\Http\Controllers\Admin\UserPermissionController::class, 'index'])->name('user-permissions.index');
        Route::get('/user-permissions/{user}', [\App\Http\Controllers\Admin\UserPermissionController::class, 'show'])->name('user-permissions.show');
        Route::put('/user-permissions/{user}', [\App\Http\Controllers\Admin\UserPermissionController::class, 'update'])->name('user-permissions.update');
        Route::post('/user-permissions/{user}/attach', [\App\Http\Controllers\Admin\UserPermissionController::class, 'attachPermission'])->name('user-permissions.attach');
        Route::post('/user-permissions/{user}/detach', [\App\Http\Controllers\Admin\UserPermissionController::class, 'detachPermission'])->name('user-permissions.detach');

        // إدارة المحافظ الذكية
        Route::resource('wallets', \App\Http\Controllers\Admin\WalletController::class);
        Route::get('/wallets/{wallet}/transactions', [\App\Http\Controllers\Admin\WalletController::class, 'transactions'])->name('wallets.transactions');
        Route::get('/wallets/{wallet}/reports', [\App\Http\Controllers\Admin\WalletController::class, 'reports'])->name('wallets.reports');
        Route::post('/wallets/{wallet}/generate-report', [\App\Http\Controllers\Admin\WalletController::class, 'generateReport'])->name('wallets.generate-report');

        // إدارة المحاضرات والجروبات
        Route::resource('lectures', \App\Http\Controllers\Admin\LectureController::class);
        Route::post('/lectures/{lecture}/sync-teams-attendance', [\App\Http\Controllers\Admin\LectureController::class, 'syncTeamsAttendance'])->name('lectures.sync-teams-attendance');
        Route::resource('groups', \App\Http\Controllers\Admin\GroupController::class);
        Route::post('/groups/{group}/members', [\App\Http\Controllers\Admin\GroupController::class, 'addMember'])->name('groups.add-member');
        Route::delete('/groups/{group}/members/{member}', [\App\Http\Controllers\Admin\GroupController::class, 'removeMember'])->name('groups.remove-member');

        // إدارة الواجبات والمشاريع
        Route::resource('assignments', \App\Http\Controllers\Admin\AssignmentController::class);
        Route::get('/assignments/{assignment}/submissions', [\App\Http\Controllers\Admin\AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::post('/assignments/{assignment}/grade/{submission}', [\App\Http\Controllers\Admin\AssignmentController::class, 'grade'])->name('assignments.grade');

        // إدارة المهام
        Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class);
        Route::post('/tasks/{task}/complete', [\App\Http\Controllers\Admin\TaskController::class, 'complete'])->name('tasks.complete');
        Route::post('/tasks/{task}/comments', [\App\Http\Controllers\Admin\TaskController::class, 'addComment'])->name('tasks.add-comment');

        // إدارة الصفحات الخارجية
        Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class);
        Route::resource('contact-messages', \App\Http\Controllers\Admin\ContactMessageController::class);
        Route::post('/contact-messages/{contactMessage}/mark-as-read', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-as-read');
        Route::post('/contact-messages/{contactMessage}/mark-as-unread', [\App\Http\Controllers\Admin\ContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-as-unread');
        
        // إدارة الأسعار والباقات
        Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
        Route::post('/packages/{course}/update-price', [\App\Http\Controllers\Admin\PackageController::class, 'updatePrice'])->name('packages.update-price');
        Route::post('/packages/bulk-update', [\App\Http\Controllers\Admin\PackageController::class, 'updateBulkPrices'])->name('packages.bulk-update');

        // إدارة الإشعارات - معطلة مؤقتاً
        /*
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('store');
            Route::get('/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('show');
            Route::delete('/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('destroy');
            Route::post('/quick-send', [\App\Http\Controllers\Admin\NotificationController::class, 'quickSend'])->name('quick-send');
            Route::get('/target-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getTargetCount'])->name('target-count');
            Route::post('/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::post('/cleanup', [\App\Http\Controllers\Admin\NotificationController::class, 'cleanup'])->name('cleanup');
            Route::get('/statistics', [\App\Http\Controllers\Admin\NotificationController::class, 'statistics'])->name('statistics');
        });
        */

        // إدارة تسجيل الطلاب في الكورسات
        Route::prefix('enrollments')->name('enrollments.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'store'])->name('store');
            Route::get('/{enrollment}', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'show'])->name('show');
            Route::post('/{enrollment}/activate', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'activate'])->name('activate');
            Route::post('/{enrollment}/deactivate', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'deactivate'])->name('deactivate');
            Route::post('/{enrollment}/update-progress', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'updateProgress'])->name('update-progress');
            Route::post('/{enrollment}/update-notes', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'updateNotes'])->name('update-notes');
            Route::delete('/{enrollment}', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'destroy'])->name('destroy');
            Route::get('/search/by-phone', [\App\Http\Controllers\Admin\StudentEnrollmentController::class, 'searchStudentByPhone'])->name('search-by-phone');
        });

        // إدارة الرسائل والتقارير (الروابط الثابتة قبل {message} لتجنب أخذها كـ id)
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\MessagesController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\MessagesController::class, 'create'])->name('create');
            Route::post('/send-single', [\App\Http\Controllers\Admin\MessagesController::class, 'sendSingle'])->name('send-single');
            Route::post('/send-bulk', [\App\Http\Controllers\Admin\MessagesController::class, 'sendBulk'])->name('send-bulk');

            Route::get('/monthly-reports', [\App\Http\Controllers\Admin\MessagesController::class, 'monthlyReports'])->name('monthly-reports');
            Route::post('/generate-monthly-reports', [\App\Http\Controllers\Admin\MessagesController::class, 'generateMonthlyReports'])->name('generate-monthly-reports');

            Route::get('/templates', [\App\Http\Controllers\Admin\MessagesController::class, 'templates'])->name('templates');
            Route::post('/templates', [\App\Http\Controllers\Admin\MessagesController::class, 'storeTemplate'])->name('templates.store');
            Route::delete('/templates/{template}', [\App\Http\Controllers\Admin\MessagesController::class, 'destroyTemplate'])->name('templates.destroy');

            Route::get('/settings', [\App\Http\Controllers\Admin\WhatsAppSettingsController::class, 'settings'])->name('settings');
            Route::post('/save-api-settings', [\App\Http\Controllers\Admin\WhatsAppSettingsController::class, 'saveApiSettings'])->name('save-api-settings');
            Route::post('/test-api', [\App\Http\Controllers\Admin\WhatsAppSettingsController::class, 'testApi'])->name('test-api');

            Route::get('/{message}', [\App\Http\Controllers\Admin\MessagesController::class, 'show'])->name('show');
            Route::post('/{message}/resend', [\App\Http\Controllers\Admin\MessagesController::class, 'resend'])->name('resend');
            Route::delete('/{message}', [\App\Http\Controllers\Admin\MessagesController::class, 'destroy'])->name('destroy');
        });

        // إدارة المحاسبة
        Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
        Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);
        Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class);
        Route::resource('wallets', \App\Http\Controllers\Admin\WalletController::class);
        Route::resource('expenses', \App\Http\Controllers\Admin\ExpenseController::class)->except(['destroy']);
        Route::post('/expenses/{expense}/approve', [\App\Http\Controllers\Admin\ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::post('/expenses/{expense}/reject', [\App\Http\Controllers\Admin\ExpenseController::class, 'reject'])->name('expenses.reject');
        Route::delete('/expenses/{expense}', [\App\Http\Controllers\Admin\ExpenseController::class, 'destroy'])->name('expenses.destroy');
        Route::resource('subscriptions', \App\Http\Controllers\Admin\SubscriptionController::class);
        Route::get('/accounting/reports', [\App\Http\Controllers\Admin\AccountingReportsController::class, 'index'])->name('accounting.reports');
        Route::get('/accounting/reports/export', [\App\Http\Controllers\Admin\AccountingReportsController::class, 'export'])->name('accounting.reports.export');
        Route::prefix('installments')->name('installments.')->group(function () {
            Route::resource('plans', \App\Http\Controllers\Admin\InstallmentPlanController::class);
            Route::resource('agreements', \App\Http\Controllers\Admin\InstallmentAgreementController::class);
            Route::post('/payments/{installmentPayment}/mark', [\App\Http\Controllers\Admin\InstallmentAgreementController::class, 'markPayment'])->name('payments.mark');
        });

        // إدارة التسويق
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
        // إدارة برامج الإحالات
        Route::resource('referral-programs', \App\Http\Controllers\Admin\ReferralProgramController::class);
        
        // إدارة الإحالات
        Route::prefix('referrals')->name('referrals.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('index');
            Route::get('/{referral}', [\App\Http\Controllers\Admin\ReferralController::class, 'show'])->name('show');
        });
        Route::prefix('loyalty')->name('loyalty.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LoyaltyController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\Admin\LoyaltyController::class, 'store'])->name('store');
            Route::get('/{loyaltyProgram}', [\App\Http\Controllers\Admin\LoyaltyController::class, 'show'])->name('show');
            Route::put('/{loyaltyProgram}', [\App\Http\Controllers\Admin\LoyaltyController::class, 'update'])->name('update');
        });

        // إدارة الشهادات والإنجازات
        Route::resource('certificates', \App\Http\Controllers\Admin\CertificateController::class);
        Route::resource('achievements', \App\Http\Controllers\Admin\AchievementController::class);
        Route::resource('badges', \App\Http\Controllers\Admin\BadgeController::class);
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);

        // إدارة المحاضرات
        Route::resource('lectures', \App\Http\Controllers\Admin\LectureController::class);
        Route::get('/lectures/course/{course}', [\App\Http\Controllers\Admin\LectureController::class, 'index'])->name('lectures.by-course');

        // إدارة الحضور
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('index');
            Route::get('/lecture/{lecture}', [\App\Http\Controllers\Admin\AttendanceController::class, 'showLectureAttendance'])->name('lecture');
            Route::post('/lecture/{lecture}/upload-teams', [\App\Http\Controllers\Admin\AttendanceController::class, 'uploadTeamsFile'])->name('upload-teams');
        });

        // إدارة المجموعات
        Route::resource('groups', \App\Http\Controllers\Admin\GroupController::class);

        // إدارة الأداء
        Route::prefix('performance')->name('performance.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('index');
            Route::post('/clear-cache', [\App\Http\Controllers\Admin\PerformanceController::class, 'clearCache'])->name('clear-cache');
            Route::post('/optimize-cache', [\App\Http\Controllers\Admin\PerformanceController::class, 'optimizeCache'])->name('optimize-cache');
            Route::post('/clear-temp-files', [\App\Http\Controllers\Admin\PerformanceController::class, 'clearTempFiles'])->name('clear-temp-files');
            Route::post('/optimize-database', [\App\Http\Controllers\Admin\PerformanceController::class, 'optimizeDatabase'])->name('optimize-database');
        });

    });

    // المهام (للجميع)
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);

    // مسارات الطلاب
    Route::prefix('student')->name('student.')->group(function () {
        Route::resource('invoices', \App\Http\Controllers\Student\InvoiceController::class)->only(['index', 'show']);
        Route::resource('wallet', \App\Http\Controllers\Student\WalletController::class)->only(['index', 'show']);
        Route::resource('certificates', \App\Http\Controllers\Student\CertificateController::class)->only(['index', 'show']);
        Route::resource('achievements', \App\Http\Controllers\Student\AchievementController::class)->only(['index', 'show']);
        Route::resource('assignments', \App\Http\Controllers\Student\AssignmentController::class)->only(['index', 'show']);
        Route::post('/assignments/{assignment}/submit', [\App\Http\Controllers\Student\AssignmentController::class, 'submit'])->name('assignments.submit');
        Route::resource('tasks', \App\Http\Controllers\Student\TaskController::class);
    });

    // مسارات المدرسين
    Route::prefix('instructor')->name('instructor.')->middleware(['auth', 'role:instructor|teacher'])->group(function () {
        Route::resource('courses', \App\Http\Controllers\Instructor\CourseController::class)->only(['index', 'show']);
        Route::resource('lectures', \App\Http\Controllers\Instructor\LectureController::class);
        Route::post('/lectures/{lecture}/sync-teams-attendance', [\App\Http\Controllers\Instructor\LectureController::class, 'syncTeamsAttendance'])->name('lectures.sync-teams-attendance');
        Route::post('/lectures/{lecture}/update-attendance', [\App\Http\Controllers\Instructor\LectureController::class, 'updateAttendance'])->name('lectures.update-attendance');
        Route::post('/lectures/{lecture}/update-status', [\App\Http\Controllers\Instructor\LectureController::class, 'updateStatus'])->name('lectures.update-status');
        Route::resource('groups', \App\Http\Controllers\Instructor\GroupController::class);
        Route::post('/groups/{group}/add-member', [\App\Http\Controllers\Instructor\GroupController::class, 'addMember'])->name('groups.add-member');
        Route::delete('/groups/{group}/remove-member', [\App\Http\Controllers\Instructor\GroupController::class, 'removeMember'])->name('groups.remove-member');
        Route::resource('assignments', \App\Http\Controllers\Instructor\AssignmentController::class);
        Route::get('/assignments/{assignment}/submissions', [\App\Http\Controllers\Instructor\AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::post('/assignments/{assignment}/grade/{submission}', [\App\Http\Controllers\Instructor\AssignmentController::class, 'grade'])->name('assignments.grade');
        Route::resource('exams', \App\Http\Controllers\Instructor\ExamController::class);
        Route::get('/question-banks', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'index'])->name('question-banks.index');
        Route::get('/question-banks/create', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'create'])->name('question-banks.create');
        Route::post('/question-banks', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'store'])->name('question-banks.store');
        Route::get('/question-banks/{questionBank}', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'show'])->name('question-banks.show');
        Route::get('/question-banks/{questionBank}/questions/create', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'createQuestion'])->name('question-banks.questions.create');
        Route::post('/question-banks/{questionBank}/questions', [\App\Http\Controllers\Instructor\QuestionBankController::class, 'storeQuestion'])->name('question-banks.questions.store');
        Route::get('/courses/{course}/lessons-list', function (\App\Models\AdvancedCourse $course) {
            if ($course->instructor_id !== auth()->id()) {
                return response()->json([]);
            }
            return response()->json($course->lessons()->orderBy('order')->select('id', 'title')->get());
        })->name('courses.lessons-list');
        Route::get('/attendance', [\App\Http\Controllers\Instructor\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/lecture/{lecture}', [\App\Http\Controllers\Instructor\AttendanceController::class, 'showLecture'])->name('attendance.lecture');
        Route::resource('tasks', \App\Http\Controllers\Instructor\TaskController::class);
    });
});
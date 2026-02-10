<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\QuestionBank;
use App\Models\ActivityLog;
use App\Models\VideoWatch;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // التأكد من أن المستخدم هو إداري
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                return redirect('/dashboard')->with('error', 'غير مسموح لك بالوصول لهذه الصفحة');
            }
            return $next($request);
        });
    }

    /**
     * لوحة التحكم الرئيسية للإدارة
     */
    public function dashboard()
    {
        $now = now();
        $currentPeriodStart = $now->copy()->startOfMonth();
        $currentPeriodEnd = $now;
        $previousPeriodStart = $now->copy()->subMonth()->startOfMonth();
        $previousPeriodEnd = $now->copy()->subMonth()->endOfMonth();

        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'total_courses' => \App\Models\AdvancedCourse::count(),
            'published_courses' => \App\Models\AdvancedCourse::where('is_active', true)->count(),
            'total_subjects' => \App\Models\AcademicSubject::count(),
            'total_exams' => \App\Models\AdvancedExam::count(),
            'total_question_banks' => \App\Models\QuestionBank::count(),
            'active_students' => User::where('role', 'student')
                                   ->where('is_active', true)
                                   ->whereHas('courseEnrollments')
                                   ->count(),
            // إحصائيات المحاسبة
            'total_revenue' => \App\Models\Payment::where('status', 'completed')->sum('amount') ?? 0,
            'pending_invoices' => \App\Models\Invoice::where('status', 'pending')->count() ?? 0,
            'overdue_invoices' => \App\Models\Invoice::where('status', 'overdue')->count() ?? 0,
            'total_enrollments' => \App\Models\StudentCourseEnrollment::where('status', 'active')->count() ?? 0,
            'monthly_revenue' => \App\Models\Payment::where('status', 'completed')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount') ?? 0,
            // إحصائيات المحافظ
            'wallets' => \App\Models\Wallet::where('is_active', true)->get(),
            'total_wallet_balance' => \App\Models\Wallet::where('is_active', true)->sum('balance') ?? 0,
            'recent_activities' => ActivityLog::with('user')
                                            ->latest()
                                            ->take(10)
                                            ->get(),
            'recent_exam_attempts' => ExamAttempt::with(['exam', 'student'])
                                                ->where('status', 'submitted')
                                                ->latest()
                                                ->take(10)
                                                ->get(),
            'video_watch_stats' => VideoWatch::selectRaw('COUNT(*) as total_watches, AVG(progress_percentage) as avg_progress')
                                            ->first(),
        ];

        // إحصائيات شهرية
        $monthlyStats = [
            'new_users_this_month' => User::whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
            'exams_this_month' => Exam::whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
            'course_enrollments_this_month' => \App\Models\StudentCourseEnrollment::whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
        ];

        // مقارنات شهرية
        $monthlyComparisons = [
            'new_users' => $this->calculateChange(
                $monthlyStats['new_users_this_month'],
                User::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'new_students' => $this->calculateChange(
                User::where('role', 'student')->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
                User::where('role', 'student')->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'new_instructors' => $this->calculateChange(
                User::where('role', 'instructor')->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
                User::where('role', 'instructor')->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'new_courses' => $this->calculateChange(
                \App\Models\AdvancedCourse::whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
                \App\Models\AdvancedCourse::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'active_enrollments' => $this->calculateChange(
                \App\Models\StudentCourseEnrollment::where('status', 'active')->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
                \App\Models\StudentCourseEnrollment::where('status', 'active')->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
            'monthly_revenue' => $this->calculateChange(
                $stats['monthly_revenue'],
                \App\Models\Payment::where('status', 'completed')
                    ->whereBetween('paid_at', [$previousPeriodStart, $previousPeriodEnd])
                    ->sum('amount') ?? 0
            ),
            'pending_invoices' => $this->calculateChange(
                \App\Models\Invoice::where('status', 'pending')->whereBetween('created_at', [$currentPeriodStart, $currentPeriodEnd])->count(),
                \App\Models\Invoice::where('status', 'pending')->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count()
            ),
        ];

        $metrics = [
            'users' => [
                'total' => $stats['total_users'],
                'new_this_month' => $monthlyStats['new_users_this_month'],
                'trend' => $monthlyComparisons['new_users'],
            ],
            'students' => [
                'total' => $stats['total_students'],
                'new_this_month' => $monthlyComparisons['new_students']['current'],
                'trend' => $monthlyComparisons['new_students'],
            ],
            'instructors' => [
                'total' => $stats['total_instructors'],
                'new_this_month' => $monthlyComparisons['new_instructors']['current'],
                'trend' => $monthlyComparisons['new_instructors'],
            ],
            'courses' => [
                'total' => $stats['total_courses'],
                'new_this_month' => $monthlyComparisons['new_courses']['current'],
                'trend' => $monthlyComparisons['new_courses'],
            ],
            'enrollments' => [
                'total' => $stats['total_enrollments'],
                'new_this_month' => $monthlyComparisons['active_enrollments']['current'],
                'trend' => $monthlyComparisons['active_enrollments'],
            ],
            'monthly_revenue' => [
                'current' => $stats['monthly_revenue'],
                'trend' => $monthlyComparisons['monthly_revenue'],
            ],
            'pending_invoices' => [
                'total' => $stats['pending_invoices'],
                'new_this_month' => $monthlyComparisons['pending_invoices']['current'],
                'trend' => $monthlyComparisons['pending_invoices'],
            ],
        ];

        // آخر المستخدمين
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

        // بيانات نشاط المستخدمين - أسبوعي
        $driver = DB::getDriverName();
        $weeklyActivity = collect();
        if ($driver === 'sqlite') {
            $weeklyActivity = ActivityLog::select(
                    DB::raw("strftime('%Y-%m-%d', created_at) as date"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $weeklyActivity = ActivityLog::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // بيانات نشاط المستخدمين - شهري (آخر 12 شهر)
        $monthlyActivity = collect();
        if ($driver === 'sqlite') {
            $monthlyActivity = ActivityLog::select(
                    DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                    DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        } else {
            $monthlyActivity = ActivityLog::select(
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        }

        $pendingInvoicesSummary = \App\Models\Invoice::selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as amount')
            ->where('status', 'pending')
            ->first();

        $overdueInvoicesSummary = \App\Models\Invoice::selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as amount')
            ->where('status', 'overdue')
            ->first();

        $pendingOrdersSummary = \App\Models\Order::selectRaw('COUNT(*) as count, COALESCE(SUM(amount), 0) as amount')
            ->where('status', 'pending')
            ->first();

        $inactiveStudentsCount = User::where('role', 'student')->where('is_active', false)->count();
        $inactiveStudentLatest = User::where('role', 'student')->where('is_active', false)->latest()->first();

        $pendingInstallmentsSummary = \App\Models\InstallmentAgreement::selectRaw('COUNT(*) as count, COALESCE(SUM(total_amount), 0) as amount')
            ->whereIn('status', ['pending', 'awaiting_approval'])
            ->first();

        $quickActions = [
            [
                'title' => 'فواتير معلقة',
                'count' => (int) ($pendingInvoicesSummary->count ?? 0),
                'meta' => 'إجمالي ' . number_format($pendingInvoicesSummary->amount ?? 0, 2) . ' ج.م',
                'icon' => 'fas fa-file-invoice-dollar',
                'background' => 'from-amber-100 to-orange-50',
                'icon_background' => 'from-amber-500 to-orange-600',
                'count_class' => 'text-amber-700 dark:text-amber-300',
                'meta_class' => 'text-amber-600 dark:text-amber-300',
                'cta' => 'مراجعة الفواتير',
                'route' => route('admin.invoices.index', ['status' => 'pending']),
            ],
            [
                'title' => 'فواتير متأخرة',
                'count' => (int) ($overdueInvoicesSummary->count ?? 0),
                'meta' => 'قيمة ' . number_format($overdueInvoicesSummary->amount ?? 0, 2) . ' ج.م',
                'icon' => 'fas fa-exclamation-triangle',
                'background' => 'from-rose-100 to-red-50',
                'icon_background' => 'from-rose-500 to-red-600',
                'count_class' => 'text-rose-700 dark:text-rose-300',
                'meta_class' => 'text-rose-600 dark:text-rose-300',
                'cta' => 'معالجة المتأخرة',
                'route' => route('admin.invoices.index', ['status' => 'overdue']),
            ],
            [
                'title' => 'طلبات في الانتظار',
                'count' => (int) ($pendingOrdersSummary->count ?? 0),
                'meta' => 'قيمة ' . number_format($pendingOrdersSummary->amount ?? 0, 2) . ' ج.م',
                'icon' => 'fas fa-shopping-bag',
                'background' => 'from-sky-100 to-slate-50',
                'icon_background' => 'from-sky-500 to-slate-600',
                'count_class' => 'text-sky-700 dark:text-sky-300',
                'meta_class' => 'text-sky-600 dark:text-sky-300',
                'cta' => 'مراجعة الطلبات',
                'route' => route('admin.orders.index', ['status' => 'pending']),
            ],
            [
                'title' => 'طلاب يحتاجون التفعيل',
                'count' => (int) $inactiveStudentsCount,
                'meta' => $inactiveStudentsCount > 0
                    ? 'آخر تسجيل: ' . (optional(optional($inactiveStudentLatest)->created_at)->diffForHumans() ?? 'غير متوفر')
                    : 'كل الحسابات مفعلة',
                'icon' => 'fas fa-user-clock',
                'background' => 'from-slate-100 to-gray-50',
                'icon_background' => 'from-gray-500 to-slate-600',
                'count_class' => 'text-slate-700 dark:text-slate-300',
                'meta_class' => 'text-slate-500 dark:text-slate-300',
                'cta' => 'إدارة الطلاب',
                'route' => route('admin.users.index', ['role' => 'student', 'status' => 0]),
            ],
            [
                'title' => 'اتفاقيات تقسيط معلقة',
                'count' => (int) ($pendingInstallmentsSummary->count ?? 0),
                'meta' => 'قيمة ' . number_format($pendingInstallmentsSummary->amount ?? 0, 2) . ' ج.م',
                'icon' => 'fas fa-hand-holding-usd',
                'background' => 'from-emerald-100 to-green-50',
                'icon_background' => 'from-emerald-500 to-green-600',
                'count_class' => 'text-emerald-700 dark:text-emerald-300',
                'meta_class' => 'text-emerald-600 dark:text-emerald-300',
                'cta' => 'مراجعة الاتفاقيات',
                'route' => route('admin.installments.agreements.index', ['status' => 'pending']),
            ],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'monthlyStats',
            'metrics',
            'recent_users',
            'recent_courses',
            'pending_invoices',
            'recent_payments',
            'weeklyActivity',
            'monthlyActivity',
            'quickActions',
            'weeklyActivity',
            'monthlyActivity'
        ));
    }

    /**
     * إدارة المستخدمين
     */
    public function users(Request $request)
    {
        $query = User::query();

        // فلترة حسب الدور - مع دعم الأدوار القديمة والجديدة لجميع الأدوار
        if ($request->has('role') && !empty($request->role)) {
            $role = trim($request->role);
            
            // تحويل الأدوار القديمة إلى الجديدة للبحث
            $roleMapping = [
                'admin' => ['super_admin'], // admin القديم أصبح super_admin
                'teacher' => ['instructor'], // teacher القديم أصبح instructor
                'super_admin' => ['super_admin'],
                'instructor' => ['instructor'], // مدرب = instructor فقط
                'student' => ['student'],
                'parent' => ['parent'],
            ];
            
            if (isset($roleMapping[$role]) && !empty($roleMapping[$role])) {
                $rolesToSearch = $roleMapping[$role];
                if (count($rolesToSearch) === 1) {
                    // إذا كان عنصر واحد فقط، استخدم where بدلاً من whereIn
                    $query->where('role', $rolesToSearch[0]);
                } else {
                    $query->whereIn('role', $rolesToSearch);
                }
            } elseif (!empty($role)) {
                // إذا لم يكن في المصفوفة، البحث مباشرة
                $query->where('role', $role);
            }
        }

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        // البحث
        if ($request->has('search') && $request->search !== null && trim($request->search) !== '') {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * إنشاء مستخدم جديد
     */
    public function createUser()
    {
        return view('admin.users.create', [
            'countryCodes' => config('country_codes.list', []),
        ]);
    }

    /**
     * حفظ مستخدم جديد
     */
    public function storeUser(Request $request)
    {
        try {
            $countryKeys = array_keys(config('country_codes.list', []));
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'country_code' => 'required|string|in:' . implode(',', $countryKeys),
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:8',
                'role' => 'required|in:super_admin,admin,instructor,teacher,student,parent',
                'is_active' => 'required|boolean',
            ], [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'أدخل بريداً إلكترونياً صحيحاً',
                'email.unique' => 'البريد الإلكتروني مستخدم مسبقاً',
                'country_code.required' => 'كود الدولة مطلوب',
                'country_code.in' => 'كود الدولة غير صحيح',
                'phone.required' => 'رقم الهاتف مطلوب',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
                'role.required' => 'الدور مطلوب',
            ]);

            $countries = config('country_codes.list', []);
            $countryKey = $request->country_code;
            $phoneDigits = preg_replace('/\D/', '', $request->phone ?? '');
            $code = $countries[$countryKey]['code'] ?? '';
            $fullPhone = $code . $phoneDigits;

            if ($request->filled('phone') && isset($countries[$countryKey])) {
                $country = $countries[$countryKey];
                $validator->after(function ($v) use ($country, $request, $fullPhone) {
                    if (!preg_match($country['regex'], $request->phone)) {
                        $v->errors()->add('phone', 'رقم الهاتف غير صحيح لـ ' . $country['name'] . '. مثال: ' . $country['placeholder']);
                    }
                    if (User::where('phone', $fullPhone)->exists()) {
                        $v->errors()->add('phone', 'رقم الهاتف مستخدم مسبقاً');
                    }
                });
            }

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $existingUser = User::where('phone', $fullPhone)
                ->orWhere('email', $request->email)
                ->first();

            if ($existingUser) {
                return redirect()->route('admin.users')->with('success', 'المستخدم موجود بالفعل في النظام.');
            }

            // تحويل الأدوار القديمة إلى الجديدة
            $roleMapping = [
                'admin' => 'super_admin',
                'teacher' => 'instructor',
            ];
            
            $userRole = $request->role;
            if (isset($roleMapping[$userRole])) {
                $userRole = $roleMapping[$userRole];
            }
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $fullPhone,
                'password' => Hash::make($request->password),
                'role' => $userRole,
                'is_active' => $request->is_active,
                'bio' => $request->bio,
            ]);

            // تفعيل الصلاحيات تلقائياً حسب الدور (مدرب = كل صلاحيات المدرب في السايدبار فوراً)
            if ($userRole === 'instructor') {
                $user->assignRole('instructor');
                $instructorPermissionIds = Permission::where(function ($q) {
                    $q->where('name', 'like', 'instructor.%')
                        ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
                })->pluck('id');
                $user->directPermissions()->sync($instructorPermissionIds);
            } elseif ($userRole === 'student') {
                $user->assignRole('student');
                $studentPermissionIds = Permission::where(function ($q) {
                    $q->where('name', 'like', 'student.%')
                        ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
                })->pluck('id');
                $user->directPermissions()->sync($studentPermissionIds);
            }

            // حفظ البيانات الجديدة بعد الإنشاء (إزالة البيانات الحساسة)
            $newValues = $user->only(['name', 'email', 'phone', 'role', 'is_active', 'bio']);

            // تسجيل النشاط في الخلفية (مع معالجة الأخطاء - لا نوقف العملية إذا فشل)
            try {
                // التحقق من وجود الجدول والأعمدة المطلوبة
                if (\Schema::hasTable('activity_logs')) {
                    $logData = [
                        'user_id' => Auth::id(),
                        'action' => 'user_created',
                        'model_type' => 'User',
                        'model_id' => $user->id,
                        'old_values' => null,
                        'new_values' => json_encode($newValues),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    
                    // إضافة session_id فقط إذا كان العمود موجوداً
                    if (\Schema::hasColumn('activity_logs', 'session_id') && session()->isStarted()) {
                        try {
                            $logData['session_id'] = session()->getId();
                        } catch (\Exception $e) {
                            // تجاهل خطأ session
                        }
                    }
                    
                    \DB::table('activity_logs')->insert($logData);
                }
            } catch (\Exception $logError) {
                // تسجيل الخطأ ولكن لا نوقف العملية - الإنشاء تم بنجاح
                \Log::warning('فشل في تسجيل نشاط إنشاء المستخدم: ' . $logError->getMessage());
            }

            return redirect()->route('admin.users')->with('success', 'تم إنشاء المستخدم بنجاح');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // معالجة أخطاء قاعدة البيانات (مثل duplicate entry)
            if (str_contains($e->getMessage(), 'Duplicate entry') || str_contains($e->getMessage(), 'UNIQUE constraint')) {
                return redirect()->route('admin.users')->with('success', 'المستخدم موجود بالفعل في النظام.');
            }
            
            \Log::error('خطأ في إنشاء المستخدم: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء المستخدم. يرجى المحاولة مرة أخرى.'])->withInput();
            
        } catch (\Exception $e) {
            \Log::error('خطأ غير متوقع في إنشاء المستخدم: ' . $e->getMessage());
            return back()->withErrors(['error' => 'حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.'])->withInput();
        }
    }

    /**
     * عرض نموذج تعديل المستخدم
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'bio' => $user->bio,
        ]);
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // حفظ البيانات القديمة قبل التحديث (إزالة البيانات الحساسة)
            $oldValues = $user->only(['name', 'email', 'phone', 'role', 'is_active', 'bio']);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'phone' => 'required|string|unique:users,phone,' . $id,
                'role' => 'required|in:super_admin,admin,instructor,teacher,student,parent',
                'is_active' => 'required|boolean',
            ]);
            
            // تحويل الأدوار القديمة إلى الجديدة
            $roleMapping = [
                'admin' => 'super_admin',
                'teacher' => 'instructor',
            ];
            
            $requestRole = $request->role;
            if (isset($roleMapping[$requestRole])) {
                $requestRole = $roleMapping[$requestRole];
            }

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $requestRole,
                'is_active' => $request->is_active,
                'bio' => $request->bio,
            ];

            if ($request->password) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            // مزامنة الأدوار والصلاحيات عند تغيير دور المستخدم
            $this->syncUserRoleAndPermissions($user->fresh(), $requestRole);

            // حفظ البيانات الجديدة بعد التحديث (إزالة البيانات الحساسة)
            $newValues = $user->fresh()->only(['name', 'email', 'phone', 'role', 'is_active', 'bio']);

            // تسجيل النشاط في الخلفية (مع معالجة الأخطاء - لا نوقف العملية إذا فشل)
            try {
                // التحقق من وجود الجدول والأعمدة المطلوبة
                if (\Schema::hasTable('activity_logs')) {
                    $logData = [
                        'user_id' => Auth::id(),
                        'action' => 'user_updated',
                        'model_type' => 'User',
                        'model_id' => $user->id,
                        'old_values' => json_encode($oldValues),
                        'new_values' => json_encode($newValues),
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    
                    // إضافة session_id فقط إذا كان العمود موجوداً
                    if (\Schema::hasColumn('activity_logs', 'session_id') && session()->isStarted()) {
                        try {
                            $logData['session_id'] = session()->getId();
                        } catch (\Exception $e) {
                            // تجاهل خطأ session
                        }
                    }
                    
                    \DB::table('activity_logs')->insert($logData);
                }
            } catch (\Exception $logError) {
                // تسجيل الخطأ ولكن لا نوقف العملية - التحديث تم بنجاح
                \Log::warning('فشل في تسجيل نشاط تحديث المستخدم: ' . $logError->getMessage());
            }

            return back()->with('success', 'تم تحديث بيانات المستخدم بنجاح');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'المستخدم غير موجود');
            
        } catch (\Exception $e) {
            \Log::error('خطأ في تحديث المستخدم: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'حدث خطأ أثناء تحديث بيانات المستخدم')->withInput();
        }
    }

    /**
     * مزامنة دور المستخدم والصلاحيات (عند إنشاء أو تحديث المستخدم)
     * يضمن فصل صلاحيات المدرب عن الأدمن والطالب.
     */
    protected function syncUserRoleAndPermissions(User $user, string $role): void
    {
        $user->roles()->detach();

        if ($role === 'instructor') {
            $user->assignRole('instructor');
            $instructorPermissionIds = Permission::where(function ($q) {
                $q->where('name', 'like', 'instructor.%')
                    ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
            })->pluck('id');
            $user->directPermissions()->sync($instructorPermissionIds);
        } elseif ($role === 'student') {
            $user->assignRole('student');
            $studentPermissionIds = Permission::where(function ($q) {
                $q->where('name', 'like', 'student.%')
                    ->orWhereIn('name', ['view.dashboard', 'view.calendar']);
            })->pluck('id');
            $user->directPermissions()->sync($studentPermissionIds);
        } else {
            // super_admin / admin / parent: لا دور من جدول الأدوار، والصلاحيات من isAdmin() أو صلاحيات مخصصة
            $user->directPermissions()->sync([]);
        }
    }

    /**
     * حذف مستخدم
     */
    public function deleteUser($id)
    {
        $isAjaxRequest = request()->expectsJson() || request()->wantsJson() || request()->ajax();
        
        try {
            $user = User::findOrFail($id);
            
            // منع حذف المدير الحالي
            if ($user->id === Auth::id()) {
                if ($isAjaxRequest) {
                    return response()->json(['success' => false, 'message' => 'لا يمكنك حذف حسابك الخاص'], 400);
                }
                return back()->with('error', 'لا يمكنك حذف حسابك الخاص');
            }

            // حفظ البيانات قبل الحذف
            $oldValues = $user->only(['name', 'email', 'phone', 'role', 'is_active', 'bio']);
            $userId = $user->id;
            
            // حذف المستخدم
            $user->delete();

            // تسجيل النشاط في الخلفية (مع معالجة الأخطاء - لا نوقف العملية إذا فشل)
            // استخدام DB facade مباشرة لتجنب أي مشاكل مع Model events
            try {
                // التحقق من وجود الجدول والأعمدة المطلوبة
                if (\Schema::hasTable('activity_logs')) {
                    $logData = [
                        'user_id' => Auth::id(),
                        'action' => 'user_deleted',
                        'model_type' => 'User',
                        'model_id' => $userId,
                        'old_values' => json_encode($oldValues),
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    
                    // إضافة session_id فقط إذا كان العمود موجوداً
                    if (\Schema::hasColumn('activity_logs', 'session_id') && session()->isStarted()) {
                        try {
                            $logData['session_id'] = session()->getId();
                        } catch (\Exception $e) {
                            // تجاهل خطأ session
                        }
                    }
                    
                    \DB::table('activity_logs')->insert($logData);
                }
            } catch (\Exception $logError) {
                // تسجيل الخطأ ولكن لا نوقف العملية - الحذف تم بنجاح
                \Log::warning('فشل في تسجيل نشاط حذف المستخدم: ' . $logError->getMessage());
            }

            // إرجاع JSON response للطلبات AJAX - التأكد من عدم وجود output قبل الـ response
            if ($isAjaxRequest) {
                // تنظيف أي output buffer قد يكون موجوداً
                if (ob_get_level() > 0) {
                    ob_clean();
                }
                
                return response()->json([
                    'success' => true, 
                    'message' => 'تم حذف المستخدم بنجاح'
                ], 200, [
                    'Content-Type' => 'application/json; charset=utf-8'
                ]);
            }

            return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($isAjaxRequest) {
                // تنظيف أي output buffer قد يكون موجوداً
                if (ob_get_level() > 0) {
                    ob_clean();
                }
                
                return response()->json([
                    'success' => false, 
                    'message' => 'المستخدم غير موجود'
                ], 404, [
                    'Content-Type' => 'application/json; charset=utf-8'
                ]);
            }
            return redirect()->route('admin.users')->with('error', 'المستخدم غير موجود');
            
        } catch (\Exception $e) {
            \Log::error('خطأ في حذف المستخدم: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // التحقق من أن المستخدم تم حذفه بالفعل (حتى لو حدث خطأ بعد ذلك)
            $userExists = \DB::table('users')->where('id', $id)->exists();
            
            if ($isAjaxRequest) {
                // تنظيف أي output buffer قد يكون موجوداً
                if (ob_get_level() > 0) {
                    ob_clean();
                }
                
                // إذا تم حذف المستخدم بالفعل، نعتبر العملية ناجحة
                if (!$userExists) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'تم حذف المستخدم بنجاح'
                    ], 200, [
                        'Content-Type' => 'application/json; charset=utf-8'
                    ]);
                }
                
                return response()->json([
                    'success' => false, 
                    'message' => 'حدث خطأ أثناء حذف المستخدم'
                ], 500, [
                    'Content-Type' => 'application/json; charset=utf-8'
                ]);
            }
            
            // إذا تم حذف المستخدم بالفعل، نعتبر العملية ناجحة
            if (!$userExists) {
                return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح');
            }
            
            return redirect()->route('admin.users')->with('error', 'حدث خطأ أثناء حذف المستخدم');
        }
    }

    /**
     * إدارة الكورسات
     */
    public function courses()
    {
        $courses = Course::with(['subject', 'teacher', 'enrollments'])
                        ->withCount('enrollments')
                        ->latest()
                        ->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * تفعيل/إلغاء تفعيل كورس
     */
    public function toggleCourseStatus($id)
    {
        $course = Course::findOrFail($id);
        $oldStatus = $course->status;
        
        $course->update([
            'status' => $course->status === 'published' ? 'draft' : 'published'
        ]);

        // تسجيل النشاط
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'course_status_changed',
            'model_type' => 'Course',
            'model_id' => $course->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $course->status],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'تم تغيير حالة الكورس بنجاح');
    }

    /**
     * عرض سجل النشاطات
     */
    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user');

        // فلترة حسب المستخدم
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // فلترة حسب النشاط
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // فلترة حسب التاريخ
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->latest()->paginate(25);
        $users = User::select('id', 'name')->get();

        return view('admin.activity-log', compact('activities', 'users'));
    }

    /**
     * إحصائيات المنصة
     */
    public function statistics()
    {
        $stats = [
            'users_by_month' => $this->getUsersByMonth(),
            
            'courses_by_subject' => Course::join('subjects', 'courses.subject_id', '=', 'subjects.id')
                                         ->selectRaw('subjects.name, COUNT(*) as count')
                                         ->groupBy('subjects.id', 'subjects.name')
                                         ->get(),
            
            'exam_performance' => ExamAttempt::selectRaw('AVG(score) as avg_score, COUNT(*) as total_attempts')
                                           ->where('status', 'submitted')
                                           ->first(),
            
            'video_engagement' => VideoWatch::selectRaw('AVG(progress_percentage) as avg_progress, COUNT(*) as total_watches')
                                          ->first(),
        ];

        return view('admin.statistics', compact('stats'));
    }

    /**
     * الحصول على إحصائيات المستخدمين حسب الشهر (متوافق مع SQLite و MySQL)
     */
    private function getUsersByMonth()
    {
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            return User::select(
                    DB::raw("CAST(strftime('%Y', created_at) AS INTEGER) as year"),
                    DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->take(12)
                ->get();
        } else {
            return User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->take(12)
                ->get();
        }
    }

    private function calculateChange($current, $previous): array
    {
        $current = (float) $current;
        $previous = (float) $previous;
        $difference = $current - $previous;
        $percent = $previous > 0
            ? round(($difference / $previous) * 100, 1)
            : ($current > 0 ? 100.0 : 0.0);

        return [
            'current' => $current,
            'previous' => $previous,
            'difference' => $difference,
            'percent' => $percent,
        ];
    }
}
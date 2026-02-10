<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'parent_id',
        'is_active',
        'bio',
        'profile_image',
        'birth_date',
        'address',
        'academic_year_id',
        'last_login_at',
        'referral_code',
        'referred_by',
        'referred_at',
        'total_referrals',
        'completed_referrals',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'referred_at' => 'datetime',
        ];
    }

    /**
     * علاقة مع ولي الأمر
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * علاقة مع الأطفال (للوالدين)
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * علاقة مع السنة الدراسية
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * علاقة مع تسجيلات الكورسات
     */
    public function courseEnrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::class, 'user_id');
    }

    /**
     * علاقة مع محاولات الامتحان
     */
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * علاقة مع التقارير كطالب
     */
    public function studentReports()
    {
        return $this->hasMany(StudentReport::class, 'student_id');
    }

    /**
     * علاقة مع التقارير كولي أمر
     */
    public function parentReports()
    {
        return $this->hasMany(StudentReport::class, 'parent_id');
    }

    /**
     * علاقة مع رسائل الواتساب
     */
    public function whatsappMessages()
    {
        return $this->hasMany(WhatsAppMessage::class);
    }

    /**
     * علاقة مع الإشعارات المخصصة (تجاوز Laravel's built-in)
     */
    public function customNotifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * تجاوز علاقة notifications الافتراضية
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    /**
     * علاقة مع محفظة المستخدم المالية
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * التحقق من كون المستخدم طالب
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * التحقق من كون المستخدم مدرب
     */
    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    /**
     * التحقق من كون المستخدم مدير عام
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * التحقق من كون المستخدم إداري (للتوافق مع الكود القديم)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * التحقق من كون المستخدم مدرب (للتوافق مع الكود القديم)
     */
    public function isTeacher(): bool
    {
        return $this->role === 'instructor';
    }

    /**
     * التحقق من كون المستخدم ولي أمر (للتوافق مع الكود القديم - تم إزالة هذا الدور)
     * هذا method للتوافق فقط - سيُعيد دائماً false
     */
    public function isParent(): bool
    {
        return false; // تم إزالة دور ولي الأمر
    }

    /**
     * scope للطلاب
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /**
     * scope للمدربين
     */
    public function scopeInstructors($query)
    {
        return $query->where('role', 'instructor');
    }

    /**
     * scope للمدربين (للتوافق مع الكود القديم)
     */
    public function scopeTeachers($query)
    {
        return $query->where('role', 'instructor');
    }

    /**
     * scope للمستخدمين النشطين
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * الحصول على الكورسات النشطة للطالب
     */
    public function activeCourses()
    {
        return $this->belongsToMany(AdvancedCourse::class, 'student_course_enrollments', 'user_id', 'advanced_course_id')
                    ->withPivot(['status', 'progress', 'enrolled_at', 'activated_at'])
                    ->where('student_course_enrollments.status', 'active')
                    ->orderByDesc('student_course_enrollments.activated_at')
                    ->orderByDesc('student_course_enrollments.created_at');
    }

    /**
     * التحقق من التسجيل في كورس
     */
    public function isEnrolledIn($courseId): bool
    {
        return $this->courseEnrollments()
                    ->where('advanced_course_id', $courseId)
                    ->where('status', 'active')
                    ->exists();
    }

    /**
     * الحصول على تسجيل الكورس
     */
    public function getCourseEnrollment($courseId)
    {
        return $this->courseEnrollments()
                    ->where('advanced_course_id', $courseId)
                    ->first();
    }

    /**
     * الحصول على آخر تقرير شهري
     */
    public function getLastMonthlyReport()
    {
        return $this->studentReports()
                    ->where('report_type', 'monthly')
                    ->latest()
                    ->first();
    }

    /**
     * الحصول على متوسط الدرجات
     */
    public function getAverageScore()
    {
        return $this->examAttempts()
                    ->where('status', 'completed')
                    ->avg('percentage') ?? 0;
    }

    /**
     * الحصول على عدد الامتحانات المكتملة
     */
    public function getCompletedExamsCount()
    {
        return $this->examAttempts()
                    ->where('status', 'completed')
                    ->count();
    }

    /**
     * تحديث آخر دخول بدون تفعيل Observers
     */
    public function updateLastLogin()
    {
        // استخدام DB مباشرة لتجنب أي مشاكل
        \DB::table('users')
            ->where('id', $this->id)
            ->update(['last_login_at' => now(), 'updated_at' => now()]);
    }

    /**
     * العلاقة مع الأدوار (نظام الصلاحيات المخصص)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * الحصول على جميع الصلاحيات للمستخدم (من الأدوار)
     */
    public function permissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');
    }

    /**
     * التحقق من وجود صلاحية معينة (من الأدوار أو المباشرة)
     */
    public function hasPermission($permissionName)
    {
        // إذا كان admin، يعيد true دائماً
        if ($this->isAdmin()) {
            return true;
        }

        // التحقق من الصلاحيات المباشرة
        if ($this->directPermissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        // التحقق من الصلاحيات من الأدوار
        return $this->roles()->whereHas('permissions', function($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }

    /**
     * التحقق من وجود أي صلاحية من القائمة
     */
    public function hasAnyPermission(...$permissionNames): bool
    {
        foreach ($permissionNames as $name) {
            if ($this->hasPermission($name)) {
                return true;
            }
        }
        return false;
    }

    /**
     * التحقق من وجود دور معين
     */
    public function hasRole($roleName)
    {
        // التحقق من الدور الأساسي
        if (strtolower($this->role) === strtolower($roleName)) {
            return true;
        }

        // التحقق من الأدوار المخصصة
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * إضافة دور للمستخدم
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role && !$this->hasRole($role->name)) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * إزالة دور من المستخدم
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * العلاقة المباشرة مع الصلاحيات (بدون أدوار)
     */
    public function directPermissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    /**
     * الحصول على جميع الصلاحيات (من الأدوار + المباشرة)
     */
    public function getAllPermissions()
    {
        $rolePermissions = $this->roles()->with('permissions')->get()
            ->pluck('permissions')->flatten()->unique('id');
        
        $directPermissions = $this->directPermissions;
        
        return $rolePermissions->merge($directPermissions)->unique('id');
    }

    /**
     * التحقق من وجود صلاحية معينة (من الأدوار أو المباشرة)
     */
    public function hasPermissionDirect($permissionName)
    {
        // إذا كان admin، يعيد true دائماً
        if ($this->isAdmin()) {
            return true;
        }

        // التحقق من الصلاحيات المباشرة
        if ($this->directPermissions()->where('name', $permissionName)->exists()) {
            return true;
        }

        // التحقق من الصلاحيات من الأدوار
        return $this->roles()->whereHas('permissions', function($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }

    /**
     * علاقة مع الإحالات (كمحيل)
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * علاقة مع الإحالة (كمحال)
     */
    public function referral()
    {
        return $this->hasOne(Referral::class, 'referred_id');
    }

    /**
     * علاقة مع المستخدم الذي أحاله
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * علاقة مع المستخدمين المحالين
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subjects()
    {
        return $this->hasMany(AcademicSubject::class);
    }

    public function academicSubjects()
    {
        return $this->hasMany(AcademicSubject::class);
    }

    /** كورسات المسار (مرتبطة مباشرة عبر academic_year_id) */
    public function advancedCourses()
    {
        return $this->hasMany(AdvancedCourse::class);
    }

    // للتوافق مع الكود الذي يعتمد على المواد
    // يمكن الوصول للكورسات من خلال المواد الدراسية: $year->academicSubjects->flatMap->advancedCourses
    public function getAdvancedCoursesAttribute()
    {
        if (!$this->relationLoaded('academicSubjects')) {
            $this->load('academicSubjects.advancedCourses');
        }
        return $this->academicSubjects->flatMap->advancedCourses;
    }

    // Alias للتوافق مع الكود القديم
    // يعيد query builder للكورسات المرتبطة بالمواد الدراسية لهذه السنة
    // ملاحظة: إذا كان academic_subject_id غير موجود، سيعيد query فارغ
    public function courses()
    {
        // التحقق من وجود العمود أولاً
        if (!Schema::hasColumn('advanced_courses', 'academic_subject_id')) {
            // إذا لم يكن موجوداً، نعيد query فارغ
            return AdvancedCourse::where('id', '<', 0);
    }

        $subjectIds = $this->academicSubjects()->pluck('id')->toArray();
        if (empty($subjectIds)) {
            return AdvancedCourse::where('id', '<', 0);
        }
        return AdvancedCourse::whereIn('academic_subject_id', $subjectIds);
    }

    public function questionCategories()
    {
        return $this->hasMany(QuestionCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getActiveSubjectsCountAttribute()
    {
        return $this->subjects()->active()->count();
    }

    public function getActiveCoursesCountAttribute()
    {
        return $this->academicSubjects->sum(function($subject) {
            return $subject->advancedCourses()->active()->count();
        });
    }
}
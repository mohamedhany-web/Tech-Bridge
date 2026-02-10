<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'name',
        'code',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
        'skills',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'skills' => 'array',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // تم إزالة العلاقة المباشرة مع advanced_courses لأن academic_subject_id تم إزالته
    // الكورسات لم تعد مرتبطة مباشرة بالمواد الدراسية
    public function courses()
    {
        // إرجاع query فارغ لأن العلاقة لم تعد موجودة
        return AdvancedCourse::where('id', '<', 0);
    }

    public function advancedCourses()
    {
        // إرجاع query فارغ لأن العلاقة لم تعد موجودة
        return AdvancedCourse::where('id', '<', 0);
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

    public function getActiveCoursesCountAttribute()
    {
        // إرجاع 0 لأن العلاقة لم تعد موجودة
        return 0;
    }

    public function getFullNameAttribute()
    {
        return $this->academicYear->name . ' - ' . $this->name;
    }
}
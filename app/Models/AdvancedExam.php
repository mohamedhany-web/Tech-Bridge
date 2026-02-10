<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvancedExam extends Model
{
    protected $table = 'exams';
    
    protected $fillable = [
        'advanced_course_id',
        'course_lesson_id',
        'title',
        'description',
        'instructions',
        'total_marks',
        'passing_marks',
        'duration_minutes',
        'attempts_allowed',
        'randomize_questions',
        'randomize_options',
        'show_results_immediately',
        'show_correct_answers',
        'show_explanations',
        'allow_review',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
        'show_results_immediately' => 'boolean',
        'show_correct_answers' => 'boolean',
        'show_explanations' => 'boolean',
        'allow_review' => 'boolean',
        'is_active' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * علاقة مع الكورس
     */
    public function advancedCourse()
    {
        return $this->belongsTo(AdvancedCourse::class, 'advanced_course_id');
    }

    /**
     * علاقة مع الكورس (alias للتوافق)
     */
    public function course()
    {
        return $this->advancedCourse();
    }

    /**
     * علاقة مع الدرس
     */
    public function lesson()
    {
        return $this->belongsTo(CourseLesson::class, 'course_lesson_id');
    }

    /**
     * علاقة مع الأسئلة
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'exam_id', 'question_id')
                    ->withPivot(['order', 'points'])
                    ->orderBy('exam_questions.order');
    }

    /**
     * علاقة مع محاولات الامتحان
     */
    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_all_day',
        'type',
        'priority',
        'color',
        'location',
        'notes',
        'created_by',
        'visibility',
        'academic_year_id',
        'academic_subject_id',
        'advanced_course_id',
        'has_reminder',
        'reminder_minutes',
        'email_reminder',
        'status',
        'is_recurring',
        'recurrence_type',
        'recurrence_interval',
        'recurrence_end_date',
        'has_grade',
        'max_grade',
        'grading_criteria',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'recurrence_end_date' => 'date',
        'is_all_day' => 'boolean',
        'has_reminder' => 'boolean',
        'email_reminder' => 'boolean',
        'is_recurring' => 'boolean',
        'max_grade' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeVisibleToUser($query, $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('created_by', $user->id)
                ->orWhere('visibility', 'public');
        });
    }

    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('start_date', $year)
            ->whereMonth('start_date', $month);
    }

    public function scopeUpcoming($query, $limit = 10)
    {
        return $query->where('start_date', '>=', now())
            ->whereIn('status', ['scheduled', 'postponed'])
            ->orderBy('start_date')
            ->limit($limit);
    }

    public static function typeLabels(): array
    {
        return [
            'exam' => 'امتحان',
            'lesson' => 'درس',
            'assignment' => 'واجب',
            'meeting' => 'اجتماع',
            'holiday' => 'إجازة',
            'deadline' => 'آخر موعد',
            'review' => 'مراجعة',
            'personal' => 'شخصي',
            'system' => 'نظام',
        ];
    }

    public static function colorMap(): array
    {
        return [
            'exam' => '#ef4444',
            'lesson' => '#3b82f6',
            'assignment' => '#8b5cf6',
            'meeting' => '#f59e0b',
            'holiday' => '#10b981',
            'deadline' => '#ec4899',
            'review' => '#22c55e',
            'personal' => '#6366f1',
            'system' => '#64748b',
        ];
    }
}

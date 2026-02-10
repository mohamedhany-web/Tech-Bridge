<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_number',
        'user_id',
        'course_id',
        'course_name',
        'certificate_type',
        'issue_date',
        'expiry_date',
        'template',
        'pdf_path',
        'verification_code',
        'metadata',
        'is_verified',
        'is_public',
        'title',
        'description',
        'status',
        'issued_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'issued_at' => 'date',
        'expiry_date' => 'date',
        'metadata' => 'array',
        'is_verified' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(AdvancedCourse::class, 'course_id');
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }
}

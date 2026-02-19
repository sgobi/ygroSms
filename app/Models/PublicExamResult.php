<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PublicExamResult extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'exam_type',
        'exam_year',
        'index_number',
        'result_sheet_path',
        'notes',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(PublicExamResultSubject::class);
    }

    // Grade colour helper
    public static function gradeColor(string $grade): string
    {
        return match ($grade) {
            'A'  => 'success',
            'B'  => 'primary',
            'C'  => 'info',
            'S'  => 'warning',
            'W'  => 'danger',
            default => 'secondary',
        };
    }
}

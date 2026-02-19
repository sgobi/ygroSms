<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    protected $fillable = [
        'student_id', 'subject_id', 'academic_year_id',
        'term', 'grade', 'marks', 'grade_letter', 'remarks',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
        'term' => 'integer',
        'grade' => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public static function computeGradeLetter(float $marks): string
    {
        return match(true) {
            $marks >= 75 => 'A',
            $marks >= 65 => 'B',
            $marks >= 55 => 'C',
            $marks >= 35 => 'S',
            default => 'W',
        };
    }
}

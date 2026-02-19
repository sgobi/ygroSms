<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSchoolHistory extends Model
{
    protected $fillable = ['student_id', 'school_id', 'from_year', 'to_year'];

    protected $casts = [
        'from_year' => 'integer',
        'to_year' => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}

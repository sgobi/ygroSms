<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = ['name', 'grade_from', 'grade_to', 'stream_id', 'is_optional'];

    protected $casts = [
        'grade_from' => 'integer',
        'grade_to' => 'integer',
        'is_optional' => 'boolean',
    ];

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function studentSubjects(): HasMany
    {
        return $this->hasMany(StudentSubject::class);
    }

    public function isAvailableForGrade(int $grade): bool
    {
        return $grade >= $this->grade_from && $grade <= $this->grade_to;
    }
}

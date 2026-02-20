<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['year', 'is_active'];

    protected $casts = [
        'year' => 'integer',
        'is_active' => 'boolean',
    ];

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(StudentProductDistribution::class);
    }

    public function studentSubjects(): HasMany
    {
        return $this->hasMany(StudentSubject::class);
    }

    public function schoolHistories(): HasMany
    {
        return $this->hasMany(StudentSchoolHistory::class);
    }
}

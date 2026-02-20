<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'admission_number', 'dob', 'gender', 'address', 'parent_name',
        'contact', 'medical_emergency_name', 'medical_emergency_contact',
        'gn_division', 'gs_division', 'admission_year', 'ol_index', 'al_index',
        'current_grade', 'stream_id', 'photo', 'donor_id', 'caregiver_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_year' => 'integer',
        'current_grade' => 'integer',
    ];

    public static function getGnDivisions()
    {
        return GnDivision::orderBy('name')->pluck('name');
    }

    public static function getGsDivisions()
    {
        return GsDivision::orderBy('name')->pluck('name');
    }

    // Relationships
    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function schoolHistories(): HasMany
    {
        return $this->hasMany(StudentSchoolHistory::class)->orderBy('from_year');
    }

    public function currentSchool()
    {
        return $this->hasOne(StudentSchoolHistory::class)->whereNull('to_year')->with('school');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(StudentSubject::class);
    }


    public function distributions(): HasMany
    {
        return $this->hasMany(StudentProductDistribution::class);
    }

    public function publicExamEntries(): HasMany
    {
        return $this->hasMany(StudentPublicExam::class)->with('publicExam');
    }

    public function disciplinaryRecords(): HasMany
    {
        return $this->hasMany(DisciplinaryRecord::class)->orderByDesc('academic_year_id')->orderByDesc('month');
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function caregiver(): BelongsTo
    {
        return $this->belongsTo(Caregiver::class);
    }

    // Helpers
    public function getGradeGroupAttribute(): string
    {
        if ($this->current_grade <= 5) return 'Primary (1-5)';
        if ($this->current_grade <= 11) return 'O/L (6-11)';
        return 'A/L (12-13)';
    }

    public function isAL(): bool
    {
        return $this->current_grade >= 12;
    }

    public function isOL(): bool
    {
        return $this->current_grade >= 6 && $this->current_grade <= 11;
    }
}

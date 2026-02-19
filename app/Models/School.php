<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'contact', 'principal_name'];

    public function studentSchoolHistories(): HasMany
    {
        return $this->hasMany(StudentSchoolHistory::class);
    }

    public function currentStudents()
    {
        return $this->hasManyThrough(Student::class, StudentSchoolHistory::class, 'school_id', 'id', 'id', 'student_id')
            ->whereNull('student_school_histories.to_year');
    }
}

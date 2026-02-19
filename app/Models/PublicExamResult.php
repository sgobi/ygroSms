<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_public_exam_id',
        'subject_id',
        'grade',
    ];

    public function studentPublicExam()
    {
        return $this->belongsTo(StudentPublicExam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

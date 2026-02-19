<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPublicExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'public_exam_id',
        'index_number',
        'result_file_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function publicExam()
    {
        return $this->belongsTo(PublicExam::class);
    }

    public function results()
    {
        return $this->hasMany(PublicExamResult::class);
    }
}

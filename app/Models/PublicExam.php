<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublicExam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'exam_date',
        'description',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    public function studentPublicExams()
    {
        return $this->hasMany(StudentPublicExam::class);
    }
}

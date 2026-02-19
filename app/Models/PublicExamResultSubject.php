<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicExamResultSubject extends Model
{
    protected $fillable = ['public_exam_result_id', 'subject_name', 'grade'];

    public function result(): BelongsTo
    {
        return $this->belongsTo(PublicExamResult::class, 'public_exam_result_id');
    }
}

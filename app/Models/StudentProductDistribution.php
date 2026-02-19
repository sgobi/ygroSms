<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProductDistribution extends Model
{
    protected $fillable = [
        'student_id', 'product_id', 'academic_year_id',
        'quantity', 'unit_price', 'date_given', 'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'date_given' => 'date',
        'quantity' => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }
}

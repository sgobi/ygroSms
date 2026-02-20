<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisciplinaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'meeting_calendar_id',
        'month',
        'meeting_participated',
        'bill_submitted',
        'status',
    ];

    protected $casts = [
        'month' => 'integer',
        'meeting_participated' => 'boolean',
        'bill_submitted' => 'boolean',
    ];

    /**
     * Boot the model to handle auto-calculation of status.
     * 
     * Business Logic:
     * - Bill submission is ALWAYS required.
     * - If month exists in Meeting Calendar: meeting_participated required.
     * - Status = 'Good' only if all required conditions are met, otherwise 'Warning'.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($record) {
            // Bill is always required
            if (!$record->bill_submitted) {
                $record->status = 'Warning';
                return;
            }

            // Check if there is a meeting defined for this month/year
            // We use the linked meeting_calendar_id
            if ($record->meeting_calendar_id) {
                if (!$record->meeting_participated) {
                    $record->status = 'Warning';
                } else {
                    $record->status = 'Good';
                }
            } else {
                // No meeting defined for this month, only bill matters
                $record->status = 'Good';
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function meetingCalendar(): BelongsTo
    {
        return $this->belongsTo(MeetingCalendar::class);
    }

    /**
     * Helper to get month name.
     */
    public function getMonthNameAttribute(): string
    {
        return date('F', mktime(0, 0, 0, $this->month, 10));
    }
}

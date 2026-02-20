<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingCalendar extends Model
{
    protected $fillable = [
        'meeting_title',
        'meeting_date',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function disciplinaryRecords(): HasMany
    {
        return $this->hasMany(DisciplinaryRecord::class);
    }

    /**
     * Get the month number from the meeting date.
     */
    public function getMonthAttribute(): int
    {
        return (int) $this->meeting_date->format('n');
    }

    /**
     * Get the year from the meeting date.
     */
    public function getYearAttribute(): int
    {
        return (int) $this->meeting_date->format('Y');
    }

    /**
     * Helper to get month name.
     */
    public function getMonthNameAttribute(): string
    {
        return $this->meeting_date->format('F');
    }
}

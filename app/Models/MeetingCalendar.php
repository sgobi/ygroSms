<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingCalendar extends Model
{
    protected $fillable = [
        'year',
        'month',
        'meeting_title',
        'meeting_date',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'meeting_date' => 'date',
    ];

    public function disciplinaryRecords(): HasMany
    {
        return $this->hasMany(DisciplinaryRecord::class);
    }

    /**
     * Helper to get month name.
     */
    public function getMonthNameAttribute(): string
    {
        return date('F', mktime(0, 0, 0, $this->month, 10));
    }
}

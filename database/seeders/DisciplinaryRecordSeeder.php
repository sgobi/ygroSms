<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\DisciplinaryRecord;
use App\Models\Student;
use App\Models\MeetingCalendar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DisciplinaryRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DisciplinaryRecord::truncate();
        MeetingCalendar::truncate();
        Schema::enableForeignKeyConstraints();

        $activeYear = AcademicYear::where('is_active', true)->first();
        if (!$activeYear) return;

        // Create some Meeting Calendar entries with specific dates
        // Jan: Meeting
        $m1 = MeetingCalendar::create([
            'meeting_title' => 'Initial Parent Meet',
            'meeting_date' => $activeYear->year . '-01-15',
        ]);
        
        // Mar: Meeting
        $m2 = MeetingCalendar::create([
            'meeting_title' => 'Quarterly Review',
            'meeting_date' => $activeYear->year . '-03-20',
        ]);

        $students = Student::limit(5)->get();

        foreach ($students as $student) {
            // Month 1 (Jan): Meeting + Bill -> Good
            DisciplinaryRecord::create([
                'student_id' => $student->id,
                'academic_year_id' => $activeYear->id,
                'month' => 1,
                'meeting_calendar_id' => $m1->id,
                'meeting_participated' => true,
                'bill_submitted' => true,
            ]);

            // Month 2 (Feb): No Meeting + Bill -> Good (No mandatory meeting in calendar)
            DisciplinaryRecord::create([
                'student_id' => $student->id,
                'academic_year_id' => $activeYear->id,
                'month' => 2,
                'meeting_calendar_id' => null,
                'meeting_participated' => false,
                'bill_submitted' => true,
            ]);

            // Month 3 (Mar): Meeting + No Participation -> Warning
            DisciplinaryRecord::create([
                'student_id' => $student->id,
                'academic_year_id' => $activeYear->id,
                'month' => 3,
                'meeting_calendar_id' => $m2->id,
                'meeting_participated' => false,
                'bill_submitted' => true,
            ]);

            // Month 4 (Apr): No Meeting + No Bill -> Warning (Missing bill)
            DisciplinaryRecord::create([
                'student_id' => $student->id,
                'academic_year_id' => $activeYear->id,
                'month' => 4,
                'meeting_calendar_id' => null,
                'meeting_participated' => false,
                'bill_submitted' => false,
            ]);
        }
    }
}

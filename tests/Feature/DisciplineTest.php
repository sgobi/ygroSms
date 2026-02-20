<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\DisciplinaryRecord;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
        AcademicYear::factory()->create(['is_active' => true, 'year' => 2026]);
    }

    public function test_status_auto_calculation_logic(): void
    {
        $student = Student::factory()->create();
        $year = AcademicYear::first();

        // 1. Meeting ✅, Bill ✅ -> Good
        $good = DisciplinaryRecord::create([
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 1,
            'meeting_participated' => true,
            'bill_submitted' => true,
        ]);
        $this->assertEquals('Good', $good->status);

        // 2. Meeting ✅, Bill ❌ -> Pending Bill
        $pb = DisciplinaryRecord::create([
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 2,
            'meeting_participated' => true,
            'bill_submitted' => false,
        ]);
        $this->assertEquals('Pending Bill', $pb->status);

        // 3. Meeting ❌, Bill ✅ -> No Meeting
        $nm = DisciplinaryRecord::create([
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 3,
            'meeting_participated' => false,
            'bill_submitted' => true,
        ]);
        $this->assertEquals('No Meeting', $nm->status);

        // 4. Meeting ❌, Bill ❌ -> Warning
        $warn = DisciplinaryRecord::create([
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 4,
            'meeting_participated' => false,
            'bill_submitted' => false,
        ]);
        $this->assertEquals('Warning', $warn->status);
    }

    public function test_duplicate_month_validation(): void
    {
        $student = Student::factory()->create();
        $year = AcademicYear::first();

        DisciplinaryRecord::create([
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 1,
            'meeting_participated' => true,
            'bill_submitted' => true,
        ]);

        // Attempting to store another record for same student/year/month should fail validation
        $response = $this->post(route('discipline.store'), [
            'student_id' => $student->id,
            'academic_year_id' => $year->id,
            'month' => 1,
            'meeting_participated' => true,
            'bill_submitted' => true,
        ]);

        $response->assertSessionHasErrors(['month']);
        $this->assertEquals(1, DisciplinaryRecord::count());
    }
}

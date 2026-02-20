<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DisciplinaryRecord>
 */
class DisciplinaryRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'academic_year_id' => AcademicYear::factory(),
            'month' => fake()->numberBetween(1, 12),
            'meeting_participated' => fake()->boolean(),
            'meeting_month' => fake()->numberBetween(1, 12),
            'bill_submitted' => fake()->boolean(),
            'bill_month' => fake()->numberBetween(1, 12),
        ];
    }
}

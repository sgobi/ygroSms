<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Product;
use App\Models\StudentProductDistribution;
use App\Models\AcademicYear;
use App\Models\Subject;
use Carbon\Carbon;

class ExtendedDataSeeder extends Seeder
{
    public function run(): void
    {
        $years = AcademicYear::whereIn('year', [2024, 2025, 2026])->get()->keyBy('year');
        $students = Student::all();
        $products = Product::all();

        foreach ($students as $student) {
            $grade        = $student->current_grade;

            // Get subjects applicable to this student
            $subjectQuery = Subject::where('grade_from', '<=', $grade)
                ->where('grade_to', '>=', $grade);

            if ($student->stream_id) {
                $subjectQuery->where(function ($q) use ($student) {
                    $q->where('stream_id', $student->stream_id)->orWhereNull('stream_id');
                });
            } else {
                $subjectQuery->whereNull('stream_id');
            }

            $subjects = $subjectQuery->get();
            if ($subjects->isEmpty()) continue;

            // ---- MARKS for 2024, 2025, 2026 ----
            foreach ([2024, 2025, 2026] as $yr) {
                $year = $years[$yr] ?? null;
                if (!$year) continue;

                foreach ([1, 2, 3] as $term) {
                    foreach ($subjects as $subject) {
                        // Slightly vary scores by year to look realistic
                        $base  = rand(42, 94);
                        $score = min(100, max(35, $base + ($yr - 2024) * rand(-3, 5)));

                        Mark::updateOrCreate(
                            [
                                'student_id'       => $student->id,
                                'subject_id'       => $subject->id,
                                'academic_year_id' => $year->id,
                                'term'             => $term,
                            ],
                            [
                                'grade'        => $grade,
                                'marks'        => $score,
                                'grade_letter' => Mark::computeGradeLetter($score),
                                'remarks'      => match(true) {
                                    $score >= 75 => 'Excellent',
                                    $score >= 60 => 'Good',
                                    $score >= 50 => 'Satisfactory',
                                    default      => 'Needs improvement',
                                },
                            ]
                        );
                    }
                }
            }

            // ---- DISTRIBUTIONS for 2024, 2025, 2026 ----
            if ($products->isEmpty()) continue;

            foreach ([2024, 2025, 2026] as $yr) {
                $year = $years[$yr] ?? null;
                if (!$year) continue;

                // 1–3 random products per year per student
                $selected = $products->shuffle()->take(rand(1, 3));
                foreach ($selected as $product) {
                    StudentProductDistribution::firstOrCreate(
                        [
                            'student_id'       => $student->id,
                            'product_id'       => $product->id,
                            'academic_year_id' => $year->id,
                        ],
                        [
                            'quantity'   => rand(1, 2),
                            'unit_price' => $product->price,
                            'date_given' => Carbon::create($yr, rand(1, 11), rand(1, 28)),
                            'notes'      => "Annual welfare – $yr",
                        ]
                    );
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicExam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentPublicExam;
use App\Models\PublicExamResult;
use Carbon\Carbon;

class PublicExamSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------
        // G.C.E. O/L 2023
        // ------------------------------------
        $olExam = PublicExam::firstOrCreate(
            ['name' => 'G.C.E. O/L 2023'],
            ['exam_date' => '2023-12-10', 'description' => 'General Certificate of Education (Ordinary Level) Examination']
        );

        $olSubjects = ['Mathematics', 'Science', 'English', 'Tamil / Sinhala', 'Religion', 'History', 'Information Technology', 'Art', 'Health & Physical Education'];
        $olSubjectModels = Subject::whereIn('name', $olSubjects)->get();

        // Find O/L students (Grades 10, 11) - in 2023 they would be 2023-2009= ~14-16 years old. But let's just pick existing students in Gr 10-11.
        $olStudents = Student::whereBetween('current_grade', [10, 11])->take(5)->get();

        foreach ($olStudents as $student) {
            $entry = StudentPublicExam::firstOrCreate(
                ['student_id' => $student->id, 'public_exam_id' => $olExam->id],
                ['index_number' => 'OL-' . rand(10000, 99999)]
            );

            // Assign grades
            foreach ($olSubjectModels as $sub) {
                PublicExamResult::firstOrCreate(
                    ['student_public_exam_id' => $entry->id, 'subject_id' => $sub->id],
                    ['grade' => $this->randomGrade()]
                );
            }
        }

        // ------------------------------------
        // G.C.E. A/L 2023
        // ------------------------------------
        $alExam = PublicExam::firstOrCreate(
            ['name' => 'G.C.E. A/L 2023'],
            ['exam_date' => '2023-08-15', 'description' => 'General Certificate of Education (Advanced Level) Examination']
        );

        // A/L Logic: Find students in relevant streams.
        $alStudents = Student::where('current_grade', '>=', 12)->get();
        
        foreach ($alStudents as $student) {
            $streamSubjects = [];
            // Map stream to basic subjects (simplified)
            // Ideally we check Subject::where('stream_id', $student->stream_id)
            if ($student->stream_id) {
                $streamSubjects = Subject::where('stream_id', $student->stream_id)->take(3)->get();
            } else {
                continue; // Skip if no stream
            }

            // General English & GIT are common? Let's just create stream subjects for now.
            if ($streamSubjects->isEmpty()) continue;

            $entry = StudentPublicExam::firstOrCreate(
                ['student_id' => $student->id, 'public_exam_id' => $alExam->id],
                ['index_number' => 'AL-' . rand(2000000, 9999999)]
            );

            foreach ($streamSubjects as $sub) {
                PublicExamResult::firstOrCreate(
                    ['student_public_exam_id' => $entry->id, 'subject_id' => $sub->id],
                    ['grade' => $this->randomGrade()]
                );
            }
        }
    }

    private function randomGrade()
    {
        $grades = ['A', 'B', 'C', 'S', 'W'];
        return $grades[array_rand($grades)];
    }
}

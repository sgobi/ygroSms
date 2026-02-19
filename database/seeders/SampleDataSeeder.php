<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Product;
use App\Models\StudentProductDistribution;
use App\Models\StudentSchoolHistory;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\Stream;
use App\Models\Subject;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        $prevYear   = AcademicYear::where('year', $activeYear->year - 1)->first();

        $schools = School::all();
        $scienceStream  = Stream::where('name', 'Science')->first();
        $commerceStream = Stream::where('name', 'Commerce')->first();
        $artsStream     = Stream::where('name', 'Arts')->first();

        // -------------------------------------------------------
        // STUDENTS
        // -------------------------------------------------------
        $students = [
            // Primary
            ['name' => 'Kaviya Nandakumar',    'gender' => 'Female', 'dob' => '2016-03-12', 'current_grade' => 3,  'stream_id' => null,              'admission_year' => 2022, 'contact' => '0771234501', 'address' => '12, Temple Road, Jaffna'],
            ['name' => 'Aarav Sureshkumar',     'gender' => 'Male',   'dob' => '2015-07-22', 'current_grade' => 4,  'stream_id' => null,              'admission_year' => 2021, 'contact' => '0771234502', 'address' => '34, Point Pedro Rd, Jaffna'],
            ['name' => 'Thilaga Raveendran',    'gender' => 'Female', 'dob' => '2014-11-05', 'current_grade' => 5,  'stream_id' => null,              'admission_year' => 2021, 'contact' => '0771234503', 'address' => '56, Nallur Lane, Jaffna'],
            // O/L
            ['name' => 'Sanjay Arulraj',        'gender' => 'Male',   'dob' => '2012-04-18', 'current_grade' => 8,  'stream_id' => null,              'admission_year' => 2018, 'contact' => '0771234504', 'address' => '78, KKS Road, Jaffna'],
            ['name' => 'Niroshini Balendran',   'gender' => 'Female', 'dob' => '2011-09-30', 'current_grade' => 9,  'stream_id' => null,              'admission_year' => 2017, 'contact' => '0771234505', 'address' => '90, Inuvil South, Jaffna'],
            ['name' => 'Priyanka Sivaraj',      'gender' => 'Female', 'dob' => '2010-02-14', 'current_grade' => 10, 'stream_id' => null,              'admission_year' => 2016, 'contact' => '0771234506', 'address' => '11, Kopay Rd, Jaffna'],
            ['name' => 'Mathavan Krishnan',     'gender' => 'Male',   'dob' => '2009-06-25', 'current_grade' => 11, 'stream_id' => null,              'admission_year' => 2015, 'contact' => '0771234507', 'address' => '22, Hospital Rd, Jaffna'],
            // A/L Science
            ['name' => 'Anushiya Selvakumar',   'gender' => 'Female', 'dob' => '2008-01-10', 'current_grade' => 12, 'stream_id' => $scienceStream?->id, 'admission_year' => 2020, 'contact' => '0771234508', 'address' => '33, Chundikuli, Jaffna', 'ol_index' => 'OL23456'],
            ['name' => 'Karthik Murugesan',     'gender' => 'Male',   'dob' => '2007-08-03', 'current_grade' => 13, 'stream_id' => $scienceStream?->id, 'admission_year' => 2019, 'contact' => '0771234509', 'address' => '44, Stanley Rd, Jaffna', 'ol_index' => 'OL23457', 'al_index' => 'AL34567'],
            // A/L Commerce
            ['name' => 'Shalini Tharmalingam',  'gender' => 'Female', 'dob' => '2008-05-17', 'current_grade' => 12, 'stream_id' => $commerceStream?->id,'admission_year' => 2020, 'contact' => '0771234510', 'address' => '55, Colombo St, Jaffna', 'ol_index' => 'OL23458'],
            ['name' => 'Vikram Kanagasabai',    'gender' => 'Male',   'dob' => '2007-12-29', 'current_grade' => 13, 'stream_id' => $commerceStream?->id,'admission_year' => 2019, 'contact' => '0771234511', 'address' => '66, Navaly Rd, Jaffna', 'ol_index' => 'OL23459', 'al_index' => 'AL34568'],
            // A/L Arts
            ['name' => 'Deepika Rasalingam',    'gender' => 'Female', 'dob' => '2008-03-22', 'current_grade' => 12, 'stream_id' => $artsStream?->id,    'admission_year' => 2020, 'contact' => '0771234512', 'address' => '77, Manipay Rd, Jaffna', 'ol_index' => 'OL23460'],
        ];

        $createdStudents = [];
        foreach ($students as $data) {
            $s = Student::firstOrCreate(
                ['name' => $data['name'], 'admission_year' => $data['admission_year']],
                array_merge($data, ['parent_name' => 'Parent of ' . explode(' ', $data['name'])[0]])
            );
            $createdStudents[] = $s;

            // School history
            if ($schools->isNotEmpty() && !$s->schoolHistories()->exists()) {
                StudentSchoolHistory::create([
                    'student_id'  => $s->id,
                    'school_id'   => $schools->random()->id,
                    'from_year'   => $data['admission_year'],
                    'to_year'     => null,
                ]);
            }
        }

        // -------------------------------------------------------
        // PRODUCTS (Welfare items)
        // -------------------------------------------------------
        $productData = [
            ['name' => 'School Bag',        'description' => 'Standard school backpack',    'price' => 1200.00],
            ['name' => 'Stationery Kit',    'description' => 'Pens, pencils, ruler set',    'price' => 350.00],
            ['name' => 'Uniform Set',       'description' => 'Full school uniform',          'price' => 2800.00],
            ['name' => 'Geometry Box',      'description' => 'Compass and geometry set',     'price' => 450.00],
            ['name' => 'Science Kit',       'description' => 'Basic lab equipment set',      'price' => 1800.00],
            ['name' => 'Exercise Books',    'description' => 'Pack of 10 notebooks',         'price' => 280.00],
        ];

        $products = [];
        foreach ($productData as $pd) {
            $products[] = Product::firstOrCreate(['name' => $pd['name']], $pd);
        }

        // -------------------------------------------------------
        // MARKS — for each student, add marks for Year & Terms
        // -------------------------------------------------------
        foreach ($createdStudents as $student) {
            $grade = $student->current_grade;

            // Get subjects applicable to this student
            $query = Subject::where('grade_from', '<=', $grade)->where('grade_to', '>=', $grade);
            if ($student->stream_id) {
                $query->where(function ($q) use ($student) {
                    $q->where('stream_id', $student->stream_id)->orWhereNull('stream_id');
                });
            } else {
                $query->whereNull('stream_id');
            }
            $subjects = $query->get();
            if ($subjects->isEmpty()) continue;

            foreach ([$activeYear, $prevYear] as $year) {
                if (!$year) continue;
                foreach ([1, 2, 3] as $term) {
                    foreach ($subjects->take(5) as $subject) {
                        $score = rand(40, 98);
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
                                'remarks'      => $score >= 75 ? 'Well done' : ($score >= 50 ? 'Good effort' : 'Needs improvement'),
                            ]
                        );
                    }
                }
            }
        }

        // -------------------------------------------------------
        // WELFARE DISTRIBUTIONS — random products for each student
        // -------------------------------------------------------
        foreach ($createdStudents as $student) {
            // 2–4 distributions per student
            $count = rand(2, 4);
            $shuffled = collect($products)->shuffle()->take($count);
            foreach ($shuffled as $product) {
                $year = collect([$activeYear, $prevYear])->random();
                if (!$year) continue;
                StudentProductDistribution::firstOrCreate(
                    [
                        'student_id'       => $student->id,
                        'product_id'       => $product->id,
                        'academic_year_id' => $year->id,
                    ],
                    [
                        'quantity'    => rand(1, 3),
                        'unit_price'  => $product->price,
                        'date_given'  => Carbon::create($year->year, rand(1, 12), rand(1, 28)),
                        'notes'       => 'Welfare distribution',
                    ]
                );
            }
        }
    }
}

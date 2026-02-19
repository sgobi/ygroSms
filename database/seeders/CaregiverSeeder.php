<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caregiver;
use App\Models\Student;

class CaregiverSeeder extends Seeder
{
    public function run(): void
    {
        $caregivers = [
            ['title' => 'Mr', 'name' => 'S. R. Perera', 'relationship_to_student' => 'Father', 'mobile' => '0771234567', 'occupation' => 'Teacher', 'address' => '12, Temple Rd, Jaffna'],
            ['title' => 'Mrs', 'name' => 'K. Selvi', 'relationship_to_student' => 'Mother', 'mobile' => '0779876543', 'occupation' => 'Housewife', 'address' => '34, Main St, Jaffna'],
            ['title' => 'Mr', 'name' => 'A. Kumar', 'relationship_to_student' => 'Guardian', 'mobile' => '0714567890', 'occupation' => 'Merchant', 'address' => '56, Station Rd, Jaffna'],
            ['title' => 'Mrs', 'name' => 'R. Devi', 'relationship_to_student' => 'Grandmother', 'mobile' => '0765432109', 'occupation' => 'Retired', 'address' => '78, Beach Rd, Jaffna'],
            ['title' => 'Mr', 'name' => 'T. Siva', 'relationship_to_student' => 'Uncle', 'mobile' => '0756789012', 'occupation' => 'Driver', 'address' => '90, Hospital Rd, Jaffna'],
            ['title' => 'Dr', 'name' => 'V. Rajan', 'relationship_to_student' => 'Father', 'mobile' => '0771122334', 'occupation' => 'Doctor', 'address' => '11, Park Lane, Jaffna'],
            ['title' => 'Mrs', 'name' => 'P. Luxmi', 'relationship_to_student' => 'Mother', 'mobile' => '0722233445', 'occupation' => 'Nurse', 'address' => '22, School Ln, Jaffna'],
            ['title' => 'Rev', 'name' => 'J. Thomas', 'relationship_to_student' => 'Guardian', 'mobile' => '0753344556', 'occupation' => 'Clergy', 'address' => '33, Church Rd, Jaffna'],
        ];

        foreach ($caregivers as $data) {
            Caregiver::firstOrCreate(
                ['name' => $data['name'], 'mobile' => $data['mobile']],
                $data
            );
        }

        // Assign caregivers to students who don't have one
        $students = Student::whereNull('caregiver_id')->get();
        $allCaregivers = Caregiver::all();

        if ($allCaregivers->isNotEmpty()) {
            foreach ($students as $student) {
                $student->update([
                    'caregiver_id' => $allCaregivers->random()->id
                ]);
            }
        }
    }
}

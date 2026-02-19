<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donor;
use App\Models\Student;

class DonorSeeder extends Seeder
{
    public function run(): void
    {
        $donors = [
            [
                'title' => 'Mr',
                'name' => 'John Doe',
                'address' => '123 Global Way, London',
                'phone' => '+44 20 7123 4567',
                'email' => 'john.doe@example.com',
            ],
            [
                'title' => 'Mrs',
                'name' => 'Jane Smith',
                'address' => '456 Charity Lane, New York',
                'phone' => '+1 212 555 0199',
                'email' => 'jane.smith@example.org',
            ],
            [
                'title' => 'Dr',
                'name' => 'Robert Brown',
                'address' => '789 Foundation St, Sydney',
                'phone' => '+61 2 9876 5432',
                'email' => 'r.brown@aid.com',
            ],
            [
                'title' => 'Ms',
                'name' => 'Sarah Wilson',
                'address' => '321 Hope Blvd, Toronto',
                'phone' => '+1 416 555 0123',
                'email' => 'sarah.w@hope.ca',
            ],
        ];

        foreach ($donors as $data) {
            Donor::firstOrCreate(['email' => $data['email']], $data);
        }

        // Assign some donors to students
        $students = Student::all();
        $allDonors = Donor::all();

        if ($allDonors->isNotEmpty() && $students->isNotEmpty()) {
            foreach ($students as $student) {
                // Randomly assign a donor to some students (e.g. 50% chance)
                if (rand(0, 1) === 1) {
                    $student->update([
                        'donor_id' => $allDonors->random()->id
                    ]);
                }
            }
        }
    }
}

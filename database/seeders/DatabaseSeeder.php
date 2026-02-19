<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\Stream;
use App\Models\Subject;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@ygro.lk'],
            [
                'name' => 'Y GRO Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        // Academic years 2010–2026
        $currentYear = 2026;
        for ($y = 2010; $y <= $currentYear; $y++) {
            AcademicYear::firstOrCreate(
                ['year' => $y],
                ['is_active' => $y === $currentYear]
            );
        }

        // Schools
        $schools = [
            ['name' => "St. Patrick's College", 'address' => 'Jaffna', 'contact' => '0212220001'],
            ['name' => 'Jaffna Central College',  'address' => 'Jaffna', 'contact' => '0212220002'],
            ['name' => 'Vembadi Girls High School','address' => 'Jaffna', 'contact' => '0212220003'],
            ['name' => 'Hartley College',          'address' => 'Point Pedro', 'contact' => '0212220004'],
            ['name' => 'Chundikuli Girls College', 'address' => 'Jaffna', 'contact' => '0212220005'],
        ];
        foreach ($schools as $school) {
            School::firstOrCreate(['name' => $school['name']], $school);
        }

        // Streams
        $streams = [
            ['name' => 'Science',    'description' => 'Biology, Physics, Chemistry'],
            ['name' => 'Commerce',   'description' => 'Accounting, Business Studies, Economics'],
            ['name' => 'Arts',       'description' => 'History, Geography, Political Science'],
            ['name' => 'Technology', 'description' => 'Engineering Technology, IT, Science for Technology'],
        ];
        $streamMap = [];
        foreach ($streams as $s) {
            $stream = Stream::firstOrCreate(['name' => $s['name']], $s);
            $streamMap[$s['name']] = $stream->id;
        }

        // Helper closure – avoids NULL = NULL comparison issue in firstOrCreate
        $makeSubject = function (string $name, int $gradeFrom, int $gradeTo, int $streamId = null, bool $optional = false) {
            $q = Subject::where('name', $name)->where('grade_from', $gradeFrom);
            $streamId === null ? $q->whereNull('stream_id') : $q->where('stream_id', $streamId);
            if (!$q->exists()) {
                Subject::create([
                    'name'        => $name,
                    'grade_from'  => $gradeFrom,
                    'grade_to'    => $gradeTo,
                    'stream_id'   => $streamId,
                    'is_optional' => $optional,
                ]);
            }
        };

        // Primary (Grade 1–5)
        foreach (['Sinhala / Tamil','English','Mathematics','Science','Social Studies','Religion','Art','Music','Physical Education'] as $s) {
            $makeSubject($s, 1, 5);
        }

        // O/L Core (Grade 6–11)
        foreach (['First Language','Second Language','English','Mathematics','Science','History','Religion'] as $s) {
            $makeSubject($s, 6, 11);
        }

        // O/L Optional (Grade 6–11)
        foreach (['Art','Music','Health & Physical Education','Information Technology','Commerce','Agriculture'] as $s) {
            $makeSubject($s, 6, 11, null, true);
        }

        // A/L Science (Grade 12–13)
        foreach (['Physics','Chemistry','Biology','Combined Maths','ICT (Science)'] as $s) {
            $makeSubject($s, 12, 13, $streamMap['Science']);
        }

        // A/L Commerce (Grade 12–13)
        foreach (['Accounting','Business Studies','Economics','Business Statistics'] as $s) {
            $makeSubject($s, 12, 13, $streamMap['Commerce']);
        }

        // A/L Arts (Grade 12–13)
        foreach (['History','Geography','Political Science','Logic','Literature'] as $s) {
            $makeSubject($s, 12, 13, $streamMap['Arts']);
        }

        // A/L Technology (Grade 12–13)
        foreach (['Engineering Technology','Science for Technology','Information Technology'] as $s) {
            $makeSubject($s, 12, 13, $streamMap['Technology']);
        }

        // Common A/L (all streams)
        foreach (['General English','General Knowledge'] as $s) {
            $makeSubject($s, 12, 13);
        }

        // Run other seeders
        $this->call([
            DivisionSeeder::class,
            SampleDataSeeder::class,
            CaregiverSeeder::class,
            DonorSeeder::class,
            PublicExamSeeder::class,
            ExtendedDataSeeder::class,
        ]);
    }
}

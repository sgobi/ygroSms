<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gnDivisions = [
            'Gampaha', 'Yakkala', 'Miriswatta', 'Bemmulla', 'Ganemulla',
            'Kadawatha', 'Kiribathgoda', 'Kelaniya', 'Ragama', 'Wattala',
            'Ja-Ela', 'Kandana', 'Negombo', 'Katunayake', 'Minuwangoda',
            'Veyangoda', 'Nittambuwa', 'Pasyala', 'Meerigama', 'Divulapitiya'
        ];

        foreach ($gnDivisions as $gn) {
            \App\Models\GnDivision::firstOrCreate(['name' => $gn]);
        }

        $gsDivisions = [
            'Gampaha', 'Dompe', 'Mahara', 'Biyagama', 'Kelaniya',
            'Ja-Ela', 'Wattala', 'Negombo', 'Katana', 'Minuwangoda',
            'Mirigama', 'Attanagalla', 'Divulapitiya'
        ];

        foreach ($gsDivisions as $gs) {
            \App\Models\GsDivision::firstOrCreate(['name' => $gs]);
        }
    }
}

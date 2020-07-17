<?php

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'nisn' => rand(),
            'nis' => rand(),
            'name' => 'Huda Prasetyo',
            'grade_id' => 3,
            'address' => 'Kiaracondong',
            'phone' => rand(),
            'spp_id' => 1
        ]);
    }
}

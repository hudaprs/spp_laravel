<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::create([
            'name' => "10",
            'major' => "RPL"
        ]);

        Grade::create([
            'name' => "11",
            'major' => "RPL"
        ]);

        Grade::create([
            'name' => "12",
            'major' => "RPL"
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Spp;

class SppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spp::create([
            'year' => 2020,
            'nominal' => 200000
        ]);
    }
}

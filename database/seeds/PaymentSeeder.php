<?php

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'user_id' => 1,
            'student_id' => 1,
            'month' => 1,
            'year' => 2020,
            'spp_id' => 1,
            'amount' => 200000
        ]);
    }
}

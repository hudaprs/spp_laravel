<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(SppSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}

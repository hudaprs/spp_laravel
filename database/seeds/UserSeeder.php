<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            ['High Admin', 'highadmin@gmail.com', \Hash::make('password'), 1],
            ['Guest', 'guest@gmail.com', \Hash::make('password'), 2]
        ];

        foreach($userList as $user) {
            User::create([
                'name' => $user[0],
                'email' => $user[1],
                'password' => $user[2],
                'role_id' => $user[3]
            ]);
        }
    }
}

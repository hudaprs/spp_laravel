<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleList = [
            'High Admin',
            'Guest'
        ];

        foreach($roleList as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}

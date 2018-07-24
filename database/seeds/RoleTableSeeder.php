<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'Admin',
                'display_name' => 'Admin',
                'description' => 'All Access only for Admin'
            ]
        ];
        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\RoleUser;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_role = [
            [
                'user_id' =>1,
                'role_id' =>1
            ],
        ];
        foreach ($user_role as $key => $value) {
            RoleUser::create($value);
        }
    }
}

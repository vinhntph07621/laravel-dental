<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = [
            ['id' => 1, 'name' => 'Admin', 'status' => 1],
            ['id' => 2, 'name' => 'Doctor', 'status' => 1],
            ['id' => 3, 'name' => 'Receptionist', 'status' => 1],
            ['id' => 4, 'name' => 'Customer', 'status' => 1],
            ['id' => 5, 'name' => 'Nurse', 'status' => 1],
        ];

        DB::table('roles')->insert($role);
    }
}

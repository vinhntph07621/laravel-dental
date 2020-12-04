<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'id' => 1,
                'name' => 'Vinh Nguyen',
                'phone' => '0397361642',
                'email' => 'vinhxx7@gmail.com',
                'avatar' => 'none.jpg',
                'status' => 1,
                'password' => Hash::make('123456'),
            ],

            [
                'id' => 2,
                'name' => 'Vinh Dep Trai',
                'phone' => '0397361642',
                'email' => 'vinhxx8@gmail.com',
                'avatar' => 'none.jpg',
                'status' => 1,
                'password' => Hash::make('123456'),
            ],

            [
                'id' => 3,
                'name' => 'Taylor Swift',
                'phone' => '0397361642',
                'email' => 'letan2020@gmail.com',
                'avatar' => 'none.jpg',
                'status' => 1,
                'password' => Hash::make('123456'),
            ],
        ];
        DB::table('users')->insert($users);
    }
}

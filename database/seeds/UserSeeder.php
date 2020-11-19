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
        DB::table('users')->insert([
            'name' => 'Vinh Nguyen',
            'phone' => '0397361642',
            'email' => 'vinhxx7@gmail.com',
            'avatar' => 'none.jpg',
            'password' => Hash::make('123456'),
        ]);
    }
}

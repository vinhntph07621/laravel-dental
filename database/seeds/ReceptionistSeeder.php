<?php

use Illuminate\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('receptionist')->insert([
            'first_name' => 'Taylor',
            'last_name' => 'Swift',
            'birthday' => '2000-06-17',
            'phone' => '0397361642',
            'address' => 'Hoai Duc - Ha Noi',
            'email' => 'letan2020@gmail.com',
            'gender' => 0,
            'short_bio' => 'hello',
            'status' => 1,
            'user_id' => 2,
            'avatar' => 'none.jpg',
        ]);
    }
}

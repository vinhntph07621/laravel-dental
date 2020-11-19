<?php

use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('doctors')->insert([
            'first_name' => 'Vinh',
            'last_name' => 'Nguyen Thanh',
            'birthday' => '2000-06-17',
            'phone' => '0397361642',
            'address' => 'Hoai Duc - Ha Noi',
            'email' => 'vinhxx8@gmail.com',
            'gender' => 0,
            'short_bio' => 'hello',
            'status' => 1,
            'user_id' => 2,
            'avatar' => 'none.jpg',
        ]);
    }
}

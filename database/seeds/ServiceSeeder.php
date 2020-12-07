<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $service =  [
            ['id' => 1, 'name' => 'Bọc răng sứ', 'status' => 1],
            ['id' => 2, 'name' => 'Cấy ghép implant', 'status' => 1],
            ['id' => 3, 'name' => 'Niềng răng thẩm mỹ', 'status' => 1],
            ['id' => 4, 'name' => 'Tẩy trắng răng', 'status' => 1],
            ['id' => 5, 'name' => 'Điều trị tủy', 'status' => 1],
            ['id' => 6, 'name' => 'Nhổ răng khôn', 'status' => 1],
        ];
        DB::table('services')->insert($service);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReExaminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_examination', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number_booking_id')->unsigned();
            $table->dateTime('date_of_examination');
            $table->foreign('number_booking_id')->references('id')->on('number_bookings');
            $table->string('recommend',500);
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('re_examination');
    }
}

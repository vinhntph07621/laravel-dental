<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentHasServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_has_service', function (Blueprint $table) {
            $table->integer('appointment_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('appointment');
            $table->foreign('service_id')->references('id')->on('service');
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
        Schema::dropIfExists('appointment_has_service');
    }
}

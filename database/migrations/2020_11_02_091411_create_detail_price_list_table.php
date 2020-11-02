<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPriceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_price_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price_list_id')->unsigned();
            $table->string('unit');
            $table->integer('status');
            $table->foreign('price_list_id')->references('id')->on('price_list');
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
        Schema::dropIfExists('detail_price_list');
    }
}

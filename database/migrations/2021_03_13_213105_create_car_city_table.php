<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id');
            $table->foreignId('car_id');
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['city_id','car_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_city');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->nullable();
            $table->foreignId('to')->nullable();
            $table->date('day');
            $table->time('start_time');
            $table->integer('min_time');
            $table->integer('max_time');
            $table->decimal('price');
            $table->boolean('status')->default(0);
            $table->foreignId('car_id')->nullable();
            $table->foreignId('driver_id')->nullable();
            $table->timestamps();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('from')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('to')->references('id')->on('cities')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}

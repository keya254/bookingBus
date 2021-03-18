<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(0);
            $table->foreignId('trip_id');
            $table->foreignId('passenger_id')->nullable();
            $table->dateTime('booking_time')->nullable();
            $table->timestamps();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('set null')->onUpdate('cascade');
            $table->unique(['trip_id','name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}

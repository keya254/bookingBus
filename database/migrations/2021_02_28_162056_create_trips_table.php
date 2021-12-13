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
            $table->foreignId('from_id')->constrained('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('to_id')->constrained('cities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('max_seats');
            $table->dateTime('start_trip');
            $table->integer('min_time');
            $table->integer('max_time');
            $table->decimal('price');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('trips');
    }
}

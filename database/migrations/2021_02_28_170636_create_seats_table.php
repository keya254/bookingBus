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
            $table->foreignId('trip_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('passenger_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('booking_time')->nullable();
            $table->timestamps();
            $table->unique(['trip_id', 'name']);
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

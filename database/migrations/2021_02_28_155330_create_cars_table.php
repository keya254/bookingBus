<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->default('images/cars/1.png');
            $table->string('phone_number');
            $table->boolean('status')->default(0);
            $table->boolean('private')->default(0);
            $table->boolean('public')->default(0);
            $table->foreignId('owner_id')->nullable();
            $table->foreignId('typecar_id')->nullable();
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('typecar_id')->references('id')->on('type_cars')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}

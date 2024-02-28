<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_schedule', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('schedule_id');
            // $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('seat_id');
            // $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('status');
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
        Schema::dropIfExists('seat_schedule');
    }
}

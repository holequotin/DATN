<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cinema_id');
            // $table->foreignId('cinem_id')->constrained('cinemas')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedBigInteger('room_id');
            // $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('movie_id');
            // $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade')->onUpdate('cascade');
            
            $table->date('start_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_movie', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cinema_id');
            // $table->foreignId('cinema_id')->constrained('cinemas')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('movie_id');
            // $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade')->onUpdate('cascade');
            
            $table->date('release_at');
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
        Schema::dropIfExists('cinema_movie');
    }
}

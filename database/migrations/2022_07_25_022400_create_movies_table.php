<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('director');
            $table->string('actor');
            $table->string('language');
            $table->string('length');
            $table->date('release_at');
            $table->text('trailer');
            $table->text('description');

            $table->unsignedBigInteger('rating_id');
            // $table->foreignId('rating_id')->constrained('ratings');
            
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
        Schema::dropIfExists('movies');
    }
}

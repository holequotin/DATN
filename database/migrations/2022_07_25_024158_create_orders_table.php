<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('movie_id');
            // $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('cinema_id');
            // $table->foreignId('cinema_id')->constrained('cinemas')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('room_id');
            // $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->onUpdate('cascade');
            
            $table->date('date_order');
            $table->string('total_price');
            $table->string('amount_people');
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
        Schema::dropIfExists('orders');
    }
}

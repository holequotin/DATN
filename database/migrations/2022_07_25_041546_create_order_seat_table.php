<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_seat', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            // $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('seat_schedule_id');
            // $table->foreignId('seat_schedule_id')->constrained('seat_schedule');
            
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
        Schema::dropIfExists('order_seat');
    }
}

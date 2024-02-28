<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone',10);
            $table->unsignedBigInteger('cinema_id')->nullable();
            $table->string('location');

            $table->unsignedBigInteger('role_id');
            
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('cinema_id');
            $table->dropColumn('location');
            $table->dropColumn('role_id');
            $table->dropColumn('profile_id');
            $table->dropSoftDeletes();
        });
    }
}

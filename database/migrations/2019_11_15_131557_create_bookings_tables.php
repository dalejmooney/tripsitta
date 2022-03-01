<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTables extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->unsignedInteger('family_id');
            $table->unsignedInteger('babysitter_id');
            $table->string('type')->default('babysitter'); // babysitter / holiday_nanny
            $table->dateTime('start');
            $table->dateTime('end');
        });

        Schema::table('bookings', function($table) {
            $table->foreign('babysitter_id')->references('id')->on('users');
            $table->foreign('family_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

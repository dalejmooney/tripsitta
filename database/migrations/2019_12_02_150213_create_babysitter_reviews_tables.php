<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBabysitterReviewsTables extends Migration
{
    public function up()
    {
        Schema::create('babysitter_reviews', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('babysitter_id');
            $table->unsignedInteger('booking_id')->nullable();
            $table->unsignedSmallInteger('score');
        });

        Schema::table('babysitter_reviews', function($table) {
            $table->foreign('babysitter_id')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }

    public function down()
    {
        Schema::dropIfExists('babysitter_reviews');
    }
}

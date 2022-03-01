<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBookingChildrenTableDesign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_children', function(Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropForeign(['child_id']);
            $table->dropColumn('child_id');
            $table->string('name');
            $table->date('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_children', function (Blueprint $table) {
            $table->unsignedBigInteger('child_id')->nullable();
            $table->dropColumn(['name', 'dob']);
        });

        Schema::table('booking_children', function (Blueprint $table) {
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('family_children')->onDelete('cascade');
        });
    }
}

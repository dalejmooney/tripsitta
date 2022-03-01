<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableAddBookingSessionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('original_booking_session')->nullable()->default(null);
        });

        Schema::table('family_addresses', function (Blueprint $table) {
            $table->string('address2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['original_booking_session']);
        });

        Schema::table('family_addresses', function (Blueprint $table) {
            $table->string('address2')->nullable(false)->change();
        });
    }
}

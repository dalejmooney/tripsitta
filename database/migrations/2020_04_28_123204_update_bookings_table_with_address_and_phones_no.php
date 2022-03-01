<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableWithAddressAndPhonesNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('booking_address_id')->nullable();
            $table->boolean('contactable_main_phone_number')->default(0);
            $table->boolean('contactable_emergency_phone_number')->default(0);
            $table->string('alternative_phone_number',20)->default('');
            $table->text('parent_location_during_booking')->nullable();
            $table->longText('booking_notes')->nullable();
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
            $table->dropColumn('booking_address_id');
            $table->dropColumn('contactable_main_phone_number');
            $table->dropColumn('contactable_emergency_phone_number');
            $table->dropColumn('alternative_phone_number');
            $table->dropColumn('parent_location_during_booking');
            $table->dropColumn('booking_notes');
        });
    }
}

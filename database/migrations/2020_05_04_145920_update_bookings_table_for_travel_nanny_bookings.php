<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableForTravelNannyBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('start_location')->nullable();
            $table->string('end_location')->nullable();
            $table->string('start_location_airport')->nullable();
            $table->string('destination_town')->nullable();
            $table->boolean('accommodation_booked')->nullable()->default(0);
            $table->text('accommodation_details')->nullable();
            $table->boolean('babysitter_meet')->nullable()->default(0);
            $table->text('babysitter_meet_details')->nullable();
            $table->boolean('travel_trip')->nullable()->default(0);
            $table->text('travel_trip_details')->nullable();
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
            $table->dropColumn('start_location');
            $table->dropColumn('end_location');
            $table->dropColumn('start_location_airport');
            $table->dropColumn('destination_town');
            $table->dropColumn('accommodation_booked');
            $table->dropColumn('accommodation_details');
            $table->dropColumn('babysitter_meet');
            $table->dropColumn('babysitter_meet_details');
            $table->dropColumn('travel_trip');
            $table->dropColumn('travel_trip_details');
        });
    }
}

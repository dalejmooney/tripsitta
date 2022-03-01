<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingAddressNullValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_addresses', function (Blueprint $table) {
            $table->string('building')->nullable()->change();
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
        Schema::table('booking_addresses', function (Blueprint $table) {
            $table->string('building')->nullable(false)->change();
            $table->string('address2')->nullable(false)->change();
        });
    }
}

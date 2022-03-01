<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBabysitterBookedAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babysitter_booked_availabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('babysitter_id')->index();
            $table->date('date');
            $table->string('type', 255);  // babysitter-day / babysitter-night / holiday_nanny
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
        Schema::dropIfExists('babysitter_booked_availabilities');
    }
}

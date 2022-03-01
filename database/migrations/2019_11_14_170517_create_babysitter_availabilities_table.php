<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBabysitterAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babysitter_availabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('babysitter_id')->index();
            $table->date('date');
            $table->string('type', 255);  // babysitter-day / babysitter-night / holiday_nanny
            $table->softDeletes();
        });

        Schema::table('babysitter_availabilities', function($table) {
            $table->foreign('babysitter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('babysitter_availabilities');
    }
}

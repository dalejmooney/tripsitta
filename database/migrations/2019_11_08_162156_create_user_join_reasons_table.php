<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJoinReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babysitter_join_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('babysitter_id')->index();
            $table->string('reason', 255);

            $table->unique(['babysitter_id', 'reason']);
        });

        Schema::table('babysitter_join_reasons', function($table) {
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
        Schema::dropIfExists('babysitter_join_reasons');

    }
}

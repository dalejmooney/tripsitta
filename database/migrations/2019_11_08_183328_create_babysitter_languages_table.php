<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBabysitterLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babysitter_languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('babysitter_id')->index();
            $table->string('language_name', 500);
            $table->string('language_level', 255);

            $table->softDeletes();
        });

        Schema::table('babysitter_languages', function($table) {
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
        Schema::dropIfExists('babysitter_languages');
    }
}

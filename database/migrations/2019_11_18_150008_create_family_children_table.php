<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('family_id');
            $table->string('name');
            $table->date('dob');
            $table->softDeletes();
        });

        Schema::table('family_children', function($table) {
            $table->foreign('family_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_children');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('family_id')->index();
            $table->string('address1')->default('');
            $table->string('address2')->default('');
            $table->string('town')->default('');
            $table->string('postcode')->default('');
            $table->string('country')->default('');
            $table->timestamps();

            $table->softDeletes();
        });

        Schema::table('family_addresses', function($table) {
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
        Schema::dropIfExists('family_addresses');
    }
}

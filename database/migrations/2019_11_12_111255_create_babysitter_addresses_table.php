<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBabysitterAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babysitter_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('babysitter_id')->index();
            $table->boolean('home_address')->default(1);
            $table->string('address1')->default('');
            $table->string('address2')->default('');
            $table->string('town')->default('');
            $table->string('postcode')->default('');
            $table->string('country')->default('');
            $table->timestamps();

            $table->softDeletes();
        });

        Schema::table('babysitter_addresses', function($table) {
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
        Schema::dropIfExists('babysitter_addresses');
    }
}

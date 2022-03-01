<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddNewData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('home_phone_number')->after('phone_number')->default('');
            $table->string('emergency_name')->after('home_phone_number')->default('');
            $table->string('emergency_relationship')->after('emergency_name')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('home_phone_number');
            $table->removeColumn('emergency_name');
            $table->removeColumn('emergency_relationship');
        });
    }
}

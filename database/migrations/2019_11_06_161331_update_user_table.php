<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number',20)->default('')->after('password');
            $table->string('emergency_phone_number',20)->default('')->after('phone_number');
            $table->date('dob')->nullable()->after('emergency_phone_number');
        });

        Schema::table('babysitters', function (Blueprint $table) {
            $table->boolean('published')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $columns = ['phone_number', 'emergency_phone_number', 'dob'];

        if (Schema::hasTable('users') && Schema::hasColumns('users', $columns)) {
            Schema::table('users', function (Blueprint $table) use ($columns){
                $table->dropColumn($columns);
            });
        }

        $columns = ['published'];

        if (Schema::hasTable('babysitters') && Schema::hasColumns('babysitters', $columns)) {
            Schema::table('babysitters', function (Blueprint $table) use ($columns){
                $table->dropColumn($columns);
            });
        }
    }
}

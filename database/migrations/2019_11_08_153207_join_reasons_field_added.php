<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JoinReasonsFieldAdded extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babysitters', function (Blueprint $table) {
            $table->text('join_reasons')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('babysitters') && Schema::hasColumn('babysitters', 'join_reasons')) {
            Schema::table('babysitters', function (Blueprint $table){
                $table->dropColumn('join_reasons');
            });
        }
    }
}

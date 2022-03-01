<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustSourceField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('babysitters') && Schema::hasColumn('babysitters', 'source_id')) {
            Schema::table('babysitters', function (Blueprint $table){
                $table->dropColumn('source_id');
            });
        }
        Schema::table('babysitters', function (Blueprint $table) {
            $table->text('found_source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babysitters', function (Blueprint $table) {
            $table->text('source_id')->nullable();
        });
        if (Schema::hasTable('babysitters') && Schema::hasColumn('babysitters', 'found_source')) {
            Schema::table('babysitters', function (Blueprint $table){
                $table->dropColumn('found_source');
            });
        }
    }
}

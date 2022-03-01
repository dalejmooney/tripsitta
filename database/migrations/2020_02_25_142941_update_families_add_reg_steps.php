<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFamiliesAddRegSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->boolean('reg_step_1_completed')->default(0);
            $table->boolean('reg_step_2_completed')->default(0);
            $table->boolean('reg_form_submitted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->removeColumn('reg_step_1_completed');
            $table->removeColumn('reg_step_2_completed');
            $table->removeColumn('reg_form_submitted');
        });
    }
}

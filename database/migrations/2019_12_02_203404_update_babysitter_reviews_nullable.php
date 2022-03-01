<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBabysitterReviewsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babysitter_reviews', function (Blueprint $table) {
            $table->unsignedInteger('babysitter_id')->nullable()->change();
            $table->unsignedSmallInteger('score')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babysitter_reviews', function (Blueprint $table) {
            $table->unsignedInteger('babysitter_id')->nullable(false)->change();
            $table->unsignedSmallInteger('score')->nullable(false)->change();
        });
    }
}

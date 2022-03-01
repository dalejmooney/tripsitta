<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvociesTableForTwillAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->softDeletes();
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
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['published']);
        });
    }
}

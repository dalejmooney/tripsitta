<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePayoutsTableWithTransferisePaymentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babysitter_payouts', function (Blueprint $table) {
            $table->bigInteger('transferwise_payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babysitter_payouts', function (Blueprint $table) {
            $table->dropColumn(['transferwise_payment_id']);
        });
    }
}

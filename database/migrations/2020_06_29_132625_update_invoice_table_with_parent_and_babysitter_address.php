<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoiceTableWithParentAndBabysitterAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->text('babysitter_address');
            $table->text('family_address');
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
            $table->dropColumn(['babysitter_address', 'family_address']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBabysittersTables extends Migration
{
    public function up()
    {
        Schema::create('babysitters', function (Blueprint $table) {
            //createDefaultTableFields($table, true, false);
            $table->unsignedInteger('id')->primary();
            $table->text('join_reason_text')->nullable();
            $table->integer('experience_years')->nullable();
            $table->text('experience_age_groups')->nullable();
            $table->dateTime('interview_date')->nullable();
            $table->text('source_id')->nullable(); // how did you hear about us
            $table->date('first_aid_passed')->nullable();
            $table->date('first_aid_expiry')->nullable();
            $table->date('criminal_record_check_expiry')->nullable();
            $table->boolean('jobs_babysitter')->default('0');
            $table->boolean('jobs_holiday_nanny')->default('0');
            $table->text('holiday_nanny_travel_countries')->nullable();
            $table->longText('profile_content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('babysitters', function($table) {
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        }); // doesnt work because of soft delete ?
    }

    public function down()
    {
        Schema::dropIfExists('babysitters');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamiliesTables extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->longText('children_health_problems')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('families');
    }
}

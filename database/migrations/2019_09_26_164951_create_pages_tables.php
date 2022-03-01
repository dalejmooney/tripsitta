<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTables extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('subtitle')->nullable();

            $table->text('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('system_hook', 255)->nullable();
        });

        Schema::create('page_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'page');
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_slugs');
        Schema::dropIfExists('pages');
    }
}

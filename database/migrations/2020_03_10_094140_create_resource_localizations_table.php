<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceLocalizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_localizations', function (Blueprint $table) {
            $table->bigInteger('resource_id');
            $table->string('locale', 20);
            $table->json('data')->nullable();
            $table->unique(['resource_id', 'locale'], 'resource_id_locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_localizations');
    }
}

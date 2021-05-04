<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNpDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('np_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 2);
            $table->bigInteger('affiliated_id');
            $table->string('group', 20);
            $table->string('name', 100);
            $table->string('type', 50);
            $table->string('search', 255);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('np_descriptions');
    }
}

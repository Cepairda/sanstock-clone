<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_resource', function (Blueprint $table) {
            $table->bigInteger('resource_id');
            $table->bigInteger('relation_id');
            $table->string('resource_type', 255);
            $table->string('relation_type', 255);
            $table->unique(['resource_id', 'relation_id'], 'resource_id_relation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_resource');
    }
}

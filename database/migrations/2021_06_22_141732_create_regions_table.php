<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->char('ref', 36);
            $table->string('description', 100);
            $table->char('rr_price_type_ref', 36);
            $table->smallInteger('available_for_registration');
            $table->string('email', 100);
            $table->smallInteger('maximum_number_of_days_without_an_order')->nullable()->unsigned();
            $table->smallInteger('oddment_id');
            $table->timestamps();
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
        Schema::dropIfExists('regions');
    }
}

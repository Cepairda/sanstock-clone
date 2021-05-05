<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_shipping', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->char('areas_ref', 36);
            $table->char('settlement_ref', 36);
            $table->char('street_ref', 36);
            $table->string('house', 36);
            $table->string('apartment', 36);
            $table->char('warehouse_ref', 36);
            $table->string('first_name', 36);
            $table->string('middle_name', 36);
            $table->string('last_name', 36);
            $table->string('phone', 36);
            $table->smallInteger('cashless_payment');
            $table->string('payments_form', 36);
            $table->float('cash_sum', 20);
            $table->json('company');
            $table->float('insurance_sum', 20);
            $table->text('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_shipping');
    }
}

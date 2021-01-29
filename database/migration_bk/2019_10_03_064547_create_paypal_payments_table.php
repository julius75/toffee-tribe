<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('order_id');
            $table->integer('package_id')->unsigned()->index();
            $table->string('txn_id');
            $table->float('payment_gross', 10, 2);
            $table->string('currency_code', 5);
            $table->string('payer_id');
            $table->string('payer_name', 50);
            $table->string('payer_email', 50);
            $table->string('payer_country');
            $table->string('payment_status');
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
        Schema::dropIfExists('paypal_payments');
    }
}

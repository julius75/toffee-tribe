<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('order_number');
            $table->string('event_name')->nullable();
            $table->bigInteger('package_id')->unsigned()->index();
            $table->string('phoneNumber')->nullable();
            $table->string('ResultCode')->nullable();
            $table->decimal('amount', 9,2)->nullable();
            $table->string('mpesaReceiptNumber')->nullable();
            $table->string('ResultDesc')->nullable();
            $table->string('MerchantRequestID')->nullable();
            $table->string('CheckoutRequestID')->nullable();
            $table->dateTime('transactionDate')->nullable();
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
        Schema::dropIfExists('event_payments');
    }
}

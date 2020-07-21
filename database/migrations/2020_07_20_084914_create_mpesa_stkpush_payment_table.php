<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaStkpushPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stkpush_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resultCode')->nullable();
            $table->string('resultDesc')->nullable();
            $table->string('merchantRequestID')->nullable();
            $table->string('checkoutRequestID')->nullable();
            $table->string('amount')->nullable();
            $table->string('mpesaReceiptNumber')->nullable();
            $table->string('transactionDate')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('mpesaStkPushPayment');
    }
}

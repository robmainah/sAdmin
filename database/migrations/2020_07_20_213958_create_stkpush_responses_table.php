<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStkpushResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_stkpush_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('responseFrom')->nullable();
            $table->string('responseCode')->nullable();
            $table->string('responseDesc')->nullable();
            $table->string('merchantRequestID')->nullable();
            $table->string('checkoutRequestID')->nullable();
            $table->string('resultCode')->nullable();
            $table->string('resultDesc')->nullable();
            $table->string('CustomerMessage')->nullable();
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
        Schema::dropIfExists('mpesa_stkpush_responses');
    }
}

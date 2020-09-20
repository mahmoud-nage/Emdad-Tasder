<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("affiliate_id");
            $table->string("amount");
            $table->integer("payment_method");
            $table->string("name");
            $table->string("national_id");
            $table->string("bank_name");
            $table->string("banck_account_number");
            $table->string("paypal_email");
            $table->string("status")->default("pending");
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
        Schema::dropIfExists('payment_requests');
    }
}

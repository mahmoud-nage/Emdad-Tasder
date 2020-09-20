<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSellersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sellers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->integer('verification_status')->default(0);
			$table->text('verification_info')->nullable();
			$table->integer('cash_on_delivery_status')->default(0);
			$table->integer('sslcommerz_status')->default(0);
			$table->integer('stripe_status')->nullable()->default(0);
			$table->integer('paypal_status')->default(0);
			$table->string('paypal_client_id')->nullable();
			$table->string('paypal_client_secret')->nullable();
			$table->string('ssl_store_id')->nullable();
			$table->string('ssl_password')->nullable();
			$table->string('stripe_key')->nullable();
			$table->string('stripe_secret')->nullable();
			$table->integer('bank_account_status')->default(0);
			$table->string('bank_name')->nullable();
			$table->string('bank_account_username')->nullable();
			$table->text('bank_account_number', 65535)->nullable();
			$table->text('bank_branch', 65535)->nullable();
			$table->integer('egyptian_mail_status')->default(0);
			$table->string('full_name')->nullable();
			$table->string('SSN')->nullable();
			$table->integer('paystack_status')->default(0);
			$table->string('paystack_public_key')->nullable();
			$table->string('paystack_secret_key')->nullable();
			$table->float('admin_to_pay')->default(0.00);
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
		Schema::drop('sellers');
	}

}

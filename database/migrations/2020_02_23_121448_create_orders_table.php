<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->integer('guest_id')->nullable();
			$table->text('shipping_address')->nullable();
			$table->string('payment_type', 20)->nullable();
			$table->string('payment_status', 20)->nullable()->default('unpaid');
			$table->text('payment_details')->nullable();
			$table->integer('status_id')->default(1);
			$table->float('grand_total')->nullable();
			$table->float('coupon_discount')->default(0.00);
			$table->bigInteger('affiliate_id')->nullable();
			$table->bigInteger('coupon_url_id')->nullable();
			$table->text('code', 16777215)->nullable();
			$table->integer('date');
			$table->integer('viewed')->default(0);
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
		Schema::drop('orders');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('order_id');
			$table->integer('seller_id')->nullable();
			$table->integer('product_id');
			$table->text('variation')->nullable();
			$table->bigInteger('variation_id')->nullable();
			$table->float('price')->nullable();
			$table->float('tax')->default(0.00);
			$table->float('shipping_cost')->default(0.00);
			$table->integer('quantity')->nullable();
			$table->string('payment_status', 10)->default('unpaid');
			$table->string('delivery_status', 20)->nullable()->default('pending');
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
		Schema::drop('order_details');
	}

}

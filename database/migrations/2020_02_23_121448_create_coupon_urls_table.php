<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponUrlsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_urls', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('type', 10);
			$table->text('url', 65535)->nullable();
			$table->integer('visits')->default(0);
			$table->string('tag1', 250)->nullable();
			$table->string('tag2', 250)->nullable();
			$table->string('tag3', 250)->nullable();
			$table->string('tag4', 250)->nullable();
			$table->string('tag5', 250)->nullable();
			$table->integer('orders_pend')->default(0);
			$table->integer('orders_complete')->default(0);
			$table->integer('coupon_affiliate_id');
			$table->integer('affiliate_id');
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
		Schema::drop('coupon_urls');
	}

}

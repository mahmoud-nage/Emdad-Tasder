<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponAffiliatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupon_affiliates', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('type', 191)->nullable();
			$table->string('code', 191);
			$table->text('details', 65535)->nullable();
			$table->string('discount', 191)->nullable();
			$table->string('discount_type', 191)->nullable();
			$table->float('commission_percentage', 10, 0)->nullable();
			$table->integer('visits')->default(0);
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
		Schema::drop('coupon_affiliates');
	}

}

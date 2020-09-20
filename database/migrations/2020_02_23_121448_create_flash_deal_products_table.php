<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlashDealProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flash_deal_products', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('flash_deal_id');
			$table->integer('product_id');
			$table->integer('country_id');
			$table->float('discount')->nullable()->default(0.00);
			$table->string('discount_type', 20)->nullable();
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
		Schema::drop('flash_deal_products');
	}

}

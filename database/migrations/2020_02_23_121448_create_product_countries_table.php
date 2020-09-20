<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_countries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id');
			$table->integer('country_id');
			$table->float('unit_price');
			$table->float('purchase_price', 10, 0)->nullable();
			$table->text('variations', 16777215)->nullable();
			$table->float('discount', 10, 0)->nullable();
			$table->string('discount_type', 10)->nullable();
			$table->float('tax', 10, 0)->nullable();
			$table->string('tax_type', 10)->nullable();
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
		Schema::drop('product_countries');
	}

}

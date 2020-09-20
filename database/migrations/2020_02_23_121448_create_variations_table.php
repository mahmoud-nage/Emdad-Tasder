<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVariationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variations', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->text('choices_values', 65535)->nullable();
			$table->string('sku', 191)->nullable();
			$table->string('qty', 191)->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->bigInteger('product_id');
			$table->integer('product_country_id')->nullable();
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
		Schema::drop('variations');
	}

}

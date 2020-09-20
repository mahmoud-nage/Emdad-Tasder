<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zones', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name_en', 191);
			$table->string('name_ar', 191);
			$table->integer('area_id');
			$table->string('delivery_price', 191)->nullable();
			$table->integer('is_active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zones');
	}

}

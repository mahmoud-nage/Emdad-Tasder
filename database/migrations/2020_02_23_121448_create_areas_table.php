<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name_en', 191);
			$table->string('name_ar', 191);
			$table->string('code', 250)->nullable();
			$table->integer('city_id')->nullable();
			$table->string('delivery_price', 191)->nullable();
			$table->string('delivery_time', 191)->nullable();
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
		Schema::drop('areas');
	}

}

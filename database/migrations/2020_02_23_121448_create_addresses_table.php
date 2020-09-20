<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('city_id')->nullable();
			$table->integer('area_id')->nullable();
			$table->integer('zone_id')->nullable();
			$table->integer('building_no')->nullable();
			$table->integer('floor_no')->nullable();
			$table->integer('apartment_no')->nullable();
			$table->text('address_details', 65535)->nullable();
			$table->text('special_mark', 65535)->nullable();
			$table->string('phone', 191);
			$table->integer('user_id')->nullable();
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
		Schema::drop('addresses');
	}

}

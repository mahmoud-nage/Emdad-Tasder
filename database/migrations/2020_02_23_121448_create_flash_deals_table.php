<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlashDealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flash_deals', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title')->nullable();
			$table->integer('start_date')->nullable();
			$table->integer('end_date')->nullable();
			$table->integer('status')->default(0);
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
		Schema::drop('flash_deals');
	}

}

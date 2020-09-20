<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shops', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->string('name', 200)->nullable();
			$table->string('logo')->nullable();
			$table->text('sliders')->nullable();
			$table->string('address', 500)->nullable();
			$table->string('facebook')->nullable();
			$table->string('google')->nullable();
			$table->string('twitter')->nullable();
			$table->string('youtube')->nullable();
			$table->string('slug')->nullable();
			$table->string('meta_title')->nullable();
			$table->text('meta_description', 65535)->nullable();
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
		Schema::drop('shops');
	}

}

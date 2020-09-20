<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name_ar', 200);
			$table->string('name_en', 200)->nullable();
			$table->string('banner', 100)->nullable();
			$table->string('icon', 100)->nullable();
			$table->integer('featured')->default(0);
			$table->integer('top')->default(0);
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
		Schema::drop('categories');
	}

}

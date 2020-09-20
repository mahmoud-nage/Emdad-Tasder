<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerAffiliatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_affiliates', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('type', 191)->nullable();
			$table->text('photo', 65535);
			$table->text('url', 65535)->nullable();
			$table->integer('is_published')->default(0);
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
		Schema::drop('banner_affiliates');
	}

}

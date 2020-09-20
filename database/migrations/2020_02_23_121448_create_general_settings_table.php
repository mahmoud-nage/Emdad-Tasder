<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeneralSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('general_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('frontend_color')->default('default');
			$table->string('logo')->nullable();
			$table->string('admin_logo')->nullable();
			$table->string('admin_login_background')->nullable();
			$table->string('admin_login_sidebar')->nullable();
			$table->text('thumbnail', 65535)->nullable();
			$table->string('favicon')->nullable();
			$table->string('site_name')->nullable();
			$table->string('address', 1000)->nullable();
			$table->text('description', 16777215);
			$table->string('phone', 100)->nullable();
			$table->string('email')->nullable();
			$table->string('facebook', 1000)->nullable();
			$table->string('instagram', 1000)->nullable();
			$table->string('twitter', 1000)->nullable();
			$table->string('youtube', 1000)->nullable();
			$table->string('google_plus', 1000)->nullable();
			$table->string('google_play_store', 1000)->nullable();
			$table->string('apple_store', 1000)->nullable();
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
		Schema::drop('general_settings');
	}

}

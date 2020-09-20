<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 191);
			$table->text('body');
			$table->integer('user_id')->nullable();
			$table->integer('article_id')->nullable();
			$table->integer('user_report_id')->nullable();
			$table->integer('user_service_id')->nullable();
			$table->integer('message_id')->nullable();
			$table->boolean('seen')->default(0);
			$table->integer('is_admin')->default(0);
			$table->string('type')->nullable();
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
		Schema::drop('notifications');
	}

}

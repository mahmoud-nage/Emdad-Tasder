<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('provider', 10)->nullable();
			$table->string('provider_id', 50)->nullable();
			$table->string('user_type', 10)->default('customer');
			$table->string('name', 191);
			$table->string('email', 191)->unique();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->string('avatar', 256)->nullable();
			$table->string('avatar_original', 256)->nullable();
			$table->string('address', 300)->nullable();
			$table->string('gender', 10)->nullable();
			$table->date('birth_date')->nullable();
			$table->string('country', 30)->nullable();
			$table->string('city', 30)->nullable();
			$table->integer('area')->nullable();
			$table->integer('zone')->nullable();
			$table->string('postal_code', 20)->nullable();
			$table->string('reset_code', 10)->nullable();
			$table->string('phone', 20)->nullable();
			$table->float('balance')->default(0.00);
			$table->string('api_token', 60)->nullable();
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
		Schema::drop('users');
	}

}

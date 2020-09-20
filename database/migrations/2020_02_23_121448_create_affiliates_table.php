<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAffiliatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('affiliates', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('full_name', 100)->nullable();
			$table->integer('user_id');
			$table->integer('address_id');
			$table->integer('is_approved')->default(0);
			$table->integer('is_blocked')->default(0);
			$table->string('SSN', 20)->nullable();
			$table->integer('bank_account_status')->default(0);
			$table->string('bank_name', 250)->nullable();
			$table->string('bank_account_username', 250)->nullable();
			$table->string('bank_account_number', 250)->nullable();
			$table->integer('egyptian_mail_status')->default(0);
			$table->integer('payment_method')->nullable();
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
		Schema::drop('affiliates');
	}

}

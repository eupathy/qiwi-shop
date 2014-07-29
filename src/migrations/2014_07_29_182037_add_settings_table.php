<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSettingsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('ff-qiwi-shop')->create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('name');
			$table->integer('gate_id');
			$table->string('gate_password');
			$table->string('gate_key');
			$table->string('lifetime');
			$table->string('gate_url');
			$table->string('pay_url');
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
		Schema::connection('ff-qiwi-shop')->drop('settings');
	}

}

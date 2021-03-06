<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('password');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('nomor_hp')->unique();			
			$table->timestamp('email_verified_at')->nullable();
			$table->string('theme')->default('default');
			$table->string('foto')->default('storages/images/users/no_photo.png');
			$table->boolean('active')->default(true);
			$table->boolean('isdeleted')->default(true);
			$table->string('default_role',15);			
			$table->boolean('locked')->default(0);         			
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
		Schema::dropIfExists('users');
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResiTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('resi', function (Blueprint $table) {
      $table->uuid('id')->unique();
      $table->primary('id');
      $table->string('no_resi', 200);
      $table->unsignedInteger('user_id_picker');
      $table->unsignedInteger('user_id_scan')->nullabe();
      $table->uuid('resi_id_src')->nullable();
      $table->string('status', 15);

      $table->index('no_resi');
      $table->index('user_id_picker');
      $table->foreign('user_id_picker')->references('id')->on('users');

      $table->index('user_id_scan');
      $table->foreign('user_id_scan')->references('id')->on('users');

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
    Schema::dropIfExists('resi');
  }
}

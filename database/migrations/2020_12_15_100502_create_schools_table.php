<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schools', function (Blueprint $table) {
      $table->string('id')->unique()->default(uniqid("DTS", false));
      $table->primary('id');
      $table->string('name')->default('My New School');
      $table->longText('description')->nullable();
      $table->longText('address')->nullable();
      $table->string('country')->nullable();
      $table->unsignedBigInteger('created_by');
      $table->string('email')->nullable();
      $table->longText('image')->nullable();
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
    Schema::dropIfExists('schools');
  }
}

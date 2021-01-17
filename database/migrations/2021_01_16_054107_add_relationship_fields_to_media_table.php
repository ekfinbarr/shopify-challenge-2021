<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMediaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('media', function (Blueprint $table) {
      $table->unsignedBigInteger('category_id');
      $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('media_type_id');
      $table->foreign('media_type_id')->references('id')->on('media_types')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('media_format_id');
      $table->foreign('media_format_id')->references('id')->on('media_types')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('access_id');
      $table->foreign('access_id')->references('id')->on('access_types')->onUpdate('cascade')->onDelete('cascade');
    });
  }
}

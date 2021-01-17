<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('comments', function (Blueprint $table) {
      $table->unsignedBigInteger('media_id');
      $table->foreign('media_id')->references('id')->on('media')->onUpdate('cascade')->onDelete('cascade');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    });
  }
}

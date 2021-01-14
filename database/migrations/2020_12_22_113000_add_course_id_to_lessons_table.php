<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdToLessonsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('lessons', function (Blueprint $table) {
      $table->unsignedBigInteger('course_id')->nullable();
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('lessons', function (Blueprint $table) {
      $table->dropColumn('course_id');
    });
  }
}
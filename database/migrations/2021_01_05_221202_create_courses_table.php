<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->longText('title');
      $table->string('code')->nullable();
      $table->longText('description')->nullable();
      $table->string('school_id')->nullable();
      $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
      $table->unsignedBigInteger('class_id')->nullable();
      $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');
      $table->unsignedBigInteger('teacher_id')->nullable();
      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
      $table->unsignedBigInteger('created_by');
      $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
      $table->unsignedBigInteger('credit_unit')->nullable();
      $table->unsignedBigInteger('department_id')->nullable();
      // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
      $table->boolean('is_private')->nullable()->default(true);
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
    Schema::dropIfExists('courses');
  }
}

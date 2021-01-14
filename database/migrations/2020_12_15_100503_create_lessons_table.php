<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default('New Lesson');
            $table->longText('description')->nullable();
            $table->string('weekday')->nullable()->default(config('weekdays.1'));
            $table->string('start_time');
            $table->string('end_time');
            $table->string('start_period')->nullable()->default('AM');
            $table->string('end_period')->nullable()->default('PM');
            $table->unsignedBigInteger('course_id')->nullable();
            // $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id')->nullable();
            // $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('class_id')->nullable();
            // $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');
            $table->boolean('is_private')->default(true);
            $table->unsignedBigInteger('timetable_id');
            // $table->foreign('timetable_id')->references('id')->on('timetables')->onDelete('cascade');
            $table->boolean('notifications')->default(true);
            $table->boolean('is_valid')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('lessons');
    }
}

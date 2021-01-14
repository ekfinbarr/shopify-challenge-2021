<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
  use HasFactory, SoftDeletes;

  public $table = 'lessons';

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  protected $fillable = [
    'title',
    'description',
    'weekday',
    'start_time',
    'end_time',
    'start_period',
    'end_period',
    'course_id',
    'teacher_id',
    'class_id',
    'is_private',
    'timetable_id',
    'notifications',
    'created_by'
  ];

  const WEEK_DAYS = [
    '1' => 'Monday',
    '2' => 'Tuesday',
    '3' => 'Wednesday',
    '4' => 'Thursday',
    '5' => 'Friday',
    '6' => 'Saturday',
    '7' => 'Sunday',
  ];

  public function getDifferenceAttribute()
  {
    return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
  }

  public function getStartTimeAttribute($value)
  {
    return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
  }

  public function setStartTimeAttribute($value)
  {
    $this->attributes['start_time'] = $value ? Carbon::createFromFormat(
      config('panel.lesson_time_format'),
      $value
    )->format('H:i:s') : null;
  }

  public function getEndTimeAttribute($value)
  {
    return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
  }

  public function setEndTimeAttribute($value)
  {
    $this->attributes['end_time'] = $value ? Carbon::createFromFormat(
      config('panel.lesson_time_format'),
      $value
    )->format('H:i:s') : null;
  }

  function class()
  {
    return $this->belongsTo(SchoolClass::class, 'class_id');
  }

  public function teacher()
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }

  public function course()
  {
    return $this->belongsTo(Course::class, 'course_id');
  }

  public function timetable()
  {
    return $this->belongsTo(Timetable::class, 'timetable_id');
  }

  public function getSchoolAttribute()
  {
    if (!$this->timetable) return null;

    return School::where('id', $this->timetable->school_id)->first();
  }

  public static function isTimeAvailable($weekday, $startTime, $endTime, $class, $teacher, $lesson)
  {
    $lessons = self::where('weekday', $weekday)
      ->when($lesson, function ($query) use ($lesson) {
        $query->where('id', '!=', $lesson);
      })
      ->where(function ($query) use ($class, $teacher) {
        $query->where('class_id', $class)
          ->orWhere('teacher_id', $teacher);
      })
      ->where([
        ['start_time', '<', $endTime],
        ['end_time', '>', $startTime],
      ])
      ->count();

    return !$lessons;
  }
}

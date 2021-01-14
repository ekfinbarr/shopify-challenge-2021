<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
  use HasFactory, SoftDeletes;

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  protected $fillable = [
    'title',
    'code',
    'description',
    'teacher_id',
    'school_id',
    'class_id',
    'created_by',
    'credit_unit',
    'department_id',
    'is_private'
  ];

  public function lessons()
  {
    return $this->hasMany(Lesson::class, 'course_id');
  }

  public function getTimetablesAttribute()
  {
      $lessons = Lesson::with('timetable')->where('course_id', $this->id)->get();
      $timetables = [];
      foreach ($lessons as $key => $l) {
        array_push($timetables, $l->timetable);
      }
      return $timetables;
  }

  public function school()
  {
    return $this->belongsTo(School::class, 'school_id');
  }

  public function class()
  {
    return $this->belongsTo(SchoolClass::class, 'class_id');
  }

  public function teacher()
  {
      return $this->belongsTo(User::class, 'teacher_id');
  }

  // public function department()
  // {
  //   return $this->belongsTo(Department::class, 'department_id');
  // }
}

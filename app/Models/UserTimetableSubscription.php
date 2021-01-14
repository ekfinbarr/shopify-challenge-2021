<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTimetableSubscription extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'timetable_id',
    'lesson_id',
    'school_id',
    'notifications',
    'active'
  ];

  public function getValidAttribute()
  {
    return $this->active;
  }

  public function school()
  {
    return $this->belongsTo(School::class, 'school_id');
  }

  public function timetable()
  {
    return $this->belongsTo(Timetable::class, 'timetable_id');
  }

  public function lesson()
  {
    return $this->belongsTo(Lesson::class, 'lesson_id');
  }

  // public function timetable()
  // {
  //   return $this->belongsTo(Timetable::class, 'timetable_id');
  // }

  // public function getTimetableAttribute()
  // {
  //   return Timetable::with(['lessons', 'class'])->where('id', $this->timetable)->first();
  // }
  


  public function getClassAttribute()
  {
    if($this->lesson) {
      return $this->lesson->class ? $this->lesson->class : null;
    }
  }
}

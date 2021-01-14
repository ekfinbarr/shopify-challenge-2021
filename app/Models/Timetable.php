<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timetable extends Model
{

  use HasFactory, SoftDeletes;

  public $table = 'timetables';

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  protected $fillable = [
    'title',
    'description',
    'created_by',
    'school_id',
    'class_id',
    'is_private',
    'is_active',
    'is_locked'
  ];

  public function getLockedAttribute()
  {
    return $this->is_locked;
  }

  public function getActiveAttribute()
  {
    return $this->is_active;
  }

  function school()
  {
    return $this->belongsTo(School::class, 'school_id');
  }

  function class()
  {
    return $this->belongsTo(SchoolClass::class, 'class_id');
  }

  function created_by()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function lessons()
  {
      return $this->hasMany(Lesson::class, 'timetable_id');
  }
}

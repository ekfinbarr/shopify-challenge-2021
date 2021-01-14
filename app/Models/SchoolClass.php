<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Timetable;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'school_classes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'label',
        'school_id',
        'created_by'
    ];


    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'class_id');
    }

    public function isOwner($user_id)
    {
      if(!$user_id) return false;

      return $this->created_by === $user_id;
    }

    public function getTimetableAttribute()
    {
      $timetable = Timetable::where('class_id', $this->id)->orderBy('updated_at', 'desc')->first();
      return $timetable;
    }

    public function users()
    {
        return $this->belongsToMany(SchoolClass::class, 'user_classes', 'class_id', 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}

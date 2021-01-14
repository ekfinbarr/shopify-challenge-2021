<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    public $table = 'schools';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'country',
        'email',
        'created_by',
        'image'
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'school_id');
    }

    public function isOwner($user_id)
    {
      if(!$user_id) return false;

      return $this->created_by === $user_id;
    }

    public function users()
    {
        // return $this->belongsToMany(User::class, 'user_schools', 'school_id', 'user_id');
        return $this->hasMany(User::class, 'school_id');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class, 'school_id');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Timetable::class);
    }
}

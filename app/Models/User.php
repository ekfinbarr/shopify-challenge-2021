<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{

  use HasFactory, SoftDeletes, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'image',
    'last_login',
    'remember_token',
    'email_verified_at',
    'school_id'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];



  // checks whether user has a role(s)
  public function hasRole($role_name)
  {
    if (!isset($role_name) || !isset($this->roles)) {
      return false;
    }

    // if array is passed
    if (gettype($role_name) === 'array') {
      // check for multiple role
      foreach ($this->roles as $key => $role) {
        foreach ($role_name as $key => $name) {
          if ($name === $role->name || $name === $role->label) return true;
        }
      }
    } else { // if string is passed
      foreach ($this->roles as $key => $role) {
        if ($role->name === $role_name) return true;
      }
    }
    return false;
  }

  // checks whether user belongs to class
  public function classMember($class_id = null)
  {
    if (!isset($class_id) || !isset($this->classes)) {
      return false;
    }

    foreach ($this->classes as $key => $class) {
      if ($class->id === $class_id) return true;
    }

    return false;
  }

  public function getIsAdminAttribute()
  {
    return $this->roles()->where('name', 'admin')->exists();
  }

  public function getIsSuperAdminAttribute()
  {
    return $this->roles()->where('name', 'super_admin')->exists();
  }

  public function getIsTeacherAttribute()
  {
    return $this->roles()->where('name', 'teacher')->exists();
  }

  public function getIsStudentAttribute()
  {
    return $this->roles()->where('name', 'student')->exists();
  }

  public function teacherLessons()
  {
    return $this->hasMany(Lesson::class, 'teacher_id');
  }

  public static function teachers()
  {
    $role = Role::with('users')->where('name', 'teacher')->orWhere('label', 'teacher')->first();
    return $role->users ? $role->users : [];
  }

  public function getEmailVerifiedAtAttribute($value)
  {
    return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
  }

  public function setEmailVerifiedAtAttribute($value)
  {
    $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
  }

  public function setPasswordAttribute($input)
  {
    if ($input) {
      $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new ResetPassword($token));
  }

  public function roles()
  {
    return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
  }

  public function classes()
  {
    return $this->belongsToMany(SchoolClass::class, 'user_classes', 'user_id', 'class_id');
  }

  public function timetables()
  {
    return $this->hasMany(Timetable::class, 'created_by');
  }

  public function schools()
  {
    return $this->belongsToMany(School::class, 'user_schools', 'user_id', 'school_id');
  }

  public function activeSchool()
  {
    return $this->belongsTo(School::class, 'school_id');
  }

  public function school()
  {
    return $this->belongsTo(School::class, 'school_id');
  }

  public function currentSchool()
  {
    return $this->activeSchool ? $this->activeSchool : null;
  }

  public function setSchoolIdAttribute($value)
  {
    if ($value) {
      $this->attributes['school_id'] = $value;
    }
  }

  public function isActiveSchool($id = null)
  {
    if (!$id) return false;

    return $this->school_id == $id;
  }

  public function timetable_subscriptions()
  {
      return $this->hasMany(UserTimetableSubscription::class , 'user_id');
  }

  public function subscribedToLesson($id /** lesson id */)
  {
    if(Auth::check()) return false;
    if($this->timetable_subscriptions->where('lesson_id', $id)) {
      return true;
    }
    return false;
  }

  // public function getNotificationsAttribute()
  // {
  //   return $this->notifications() ? $this->notifications() : [];
  // }
}

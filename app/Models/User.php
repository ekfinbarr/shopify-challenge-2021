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


  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

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
    'country',
    'last_login',
    'remember_token',
    'email_verified_at'
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



  // check whether user has a role(s)
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


  public function getIsAdminAttribute()
  {
    return $this->roles()->where('name', 'admin')->exists();
  }

  public function getEmailVerifiedAtAttribute($value)
  {
    return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
  }

  public function updateLogin()
  {
    $this->last_login_at = Carbon::now();
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

  public function comments()
  {
    return $this->hasMany(Comment::class, 'user_id');
  }

  public function media()
  {
    return $this->hasMany(Media::class, 'user_id');
  }

  public function photos()
  {
      return $this->hasMany(Media::class, 'user_id');
  }

  public function folders()
  {
    return $this->hasMany(Comment::class, 'user_id');
  }

  public function hasMedia($id)
  {
    if (!isset($id)) return false;
    return Media::where([['id', $id], ['user_id', $this->id]])->first() ? true : false;
  }
}

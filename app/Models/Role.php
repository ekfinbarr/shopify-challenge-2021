<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
  use HasFactory, SoftDeletes;

  public $table = 'roles';

  protected $dates = [
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  protected $fillable = [
    'name',
    'label',
    'description'
  ];

  public function users()
  {
    return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
  }

  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
  }

  public function hasPermission($name)
  {
    if (!isset($name) || !isset($this->permissions)) {
      return false;
    }

    // if array is passed
    if (gettype($name) === 'array') {
      // check for multiple permission
      foreach ($this->permissions as $key => $p) {
        foreach ($name as $key => $name) {
          if ($name === $p->name) return true;
        }
      }
    } else { // if string
      foreach ($this->permissions as $key => $p) {
        if ($p->name === $name) return true;
      }
    }
    return false;
  }
}

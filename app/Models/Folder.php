<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
    ];
  
    protected $fillable = [
      'name',
      'label',
      'description',
      'access_id',
      'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAccessAttribute()
    {
      return AccessType::where('id', $this->access_id)->first()->name;
    }
}

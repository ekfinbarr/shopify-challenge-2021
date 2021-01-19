<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
      'description'
    ];

    public function medias()
    {
        return $this->hasMany(Media::class, 'category_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'category_id');
    }
}

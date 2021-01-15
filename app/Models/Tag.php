<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
    ];
  
    protected $fillable = [
      'name',
      'label'
    ];

    public function medias()
    {
        return $this->belongsToMany(Media::class, 'media_tags', 'tag_id', 'media_id');
    }
}

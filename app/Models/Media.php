<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
    ];
  
    protected $fillable = [
      'name',
      'description',
      'slug',
      'price',
      'file',
      'size',
      'likes',
      'views',
      'downloads',
      'category_id',
      'user_id',
      'access_id',
      'published',
      'media_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAccessAttribute()
    {
        return AccessType::where('id', $this->access_id)->first()->name;
    }

    public function getMediaTypeAttribute()
    {
        return MediaType::where('id', $this->media_type_id)->first()->name;
    }
}

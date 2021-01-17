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
      'dimension',
      'size',
      'likes',
      'views',
      'downloads',
      'category_id',
      'user_id',
      'access_id',
      'published',
      'media_type_id',
      'media_format_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publisher()
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

    public function getMediaFormatAttribute()
    {
        return MediaFormat::where('id', $this->media_format_id)->first()->name;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'media_id');
    }

    public function scopePublic($query)
    {
        return $query->where('access_id', AccessType::where("name", "public")->first()->id);
    }

    public function scopePrivate($query)
    {
        return $query->where('access_id', AccessType::where("name", "private")->first()->id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tags', 'media_id', 'tag_id');
    }
}

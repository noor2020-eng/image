<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class post extends Model
{
    protected $fillable = [
        'title', 'body'
    ];

    public function getImageAttribute($value)
    {
        return !is_null($value) ? asset(Storage::url($value)) : '';
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function imagePosts()
    {
        return $this->hasMany(ImagePosts::class);
    }
}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ImagePost extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(post::class);
    }
}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }

}

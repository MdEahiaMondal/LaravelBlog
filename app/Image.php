<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path', 'cat_type'];


    public function imageable()
    {
        return $this->morphTo();
    }
}

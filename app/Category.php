<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // assigment all field
    protected $guarded = [];

    public function post() 
    {
        return $this->hasMany(Post::class);
    }
}

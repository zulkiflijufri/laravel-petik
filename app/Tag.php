<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // assigment all field
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

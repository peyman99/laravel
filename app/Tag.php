<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    Protected $fillable=['name'];
    public function videos()
    {
        return $this->morphedByMany(Tag::class,'taggable');
    }
    public function posts()
    {
        return $this->morphedByMany(Tag::class,'taggable');
    }
}

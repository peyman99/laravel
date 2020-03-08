<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $date=['delete_at'];
    public $directory='/images/';
    protected $fillable = ['title','content'];


    public function User()
    {
        return $this->belongsTo(User::class);

    }

    public function photos()
    {
        return $this->morphMany(Photo::class,'imageable');

    }
    public function tags()
    {
        return $this->morphToMany(Tag::class,'taggable');
    }


    //Accessor هنگام خواندن اطلاعات از دیتابیس
    public function getTitleAttribute($value)
    {
//        return ucfirst($value);
        return strtoupper($value);
    }
    //Mutator هنگام ثبت اطلاعات در دیتابیس
    public function setTitleAttribute ($value)
    {
        $this->attributes['title']=strtoupper($value);
    }

    public function getPatchAttribute($value)
    {
        return $this->directory.$value;
    }
}

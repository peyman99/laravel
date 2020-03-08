<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;



class User extends Authenticatable implements MustVerifyEmail,AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }
    public function photos()
    {
        return $this->morphMany(Photo::class,'imageable');

    }

    public function isAdmin($role)
    {
        foreach ($this->roles as $role){
            if($role->name=='مدیر') {
                return true;
            }
        }return false;
    }
}

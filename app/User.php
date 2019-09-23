<?php

namespace App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','email', 'password','role_id','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function setPasswordAttribute($password){
        $this->attributes['password'] = Hash::make($password);
    }
    public function roles(){
        return $this->belongsToMany(Role::class,'assigned_roles');

    } 
    public function business(){
        return $this->hasMany(Business::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
   
    public function isAdmin(){
  
        if ($this->role_id === 1) {
            return true;
        }
        return false;
    }
    public static $rules = [
        "name" => "required",
        "last_name" => "required",
        "password" => "required",
        'email' => 'required|unique:users,email,',
        
    ];

}

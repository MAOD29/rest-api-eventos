<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable = ['name','descripcion','image','location','contact','start','finish','user_id','typebusiness_id'];
    protected $dates = [];

    public static $rules = [
        'name' => 'required|max:50',
        'descripcion' => 'required',
        'location' => 'required',
        'image' =>'required',
        'contact' => 'required',
        'start' => 'required',
        'finish' => 'required',
        'typebusiness_id' => 'required',
        'user_id' => 'required'
    ];
    
    public function user() {
    return $this->hasOne('App\User');
    }
        
    public function TypeBusiness(){
        return $this->hasMany(Typebusiness::class);
    }
}

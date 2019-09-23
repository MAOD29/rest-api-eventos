<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable = ['name','descripcion','image','location','contact','start','finish','user_id','typebusinesses_id'];
    protected $dates = [];

    public static $rules = [
        'name' => 'required|max:50',
        'descripcion' => 'required',
        'location' => 'required',
        'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
        'contact' => 'required',
        'start' => 'required',
        'finish' => 'required',
        'typebusinesses_id' => 'required',
        'user_id' => 'required'
    ];
    
    public function user() {
    return $this->hasOne('App\User');
    }
        
    public function TypeBusiness(){
        return $this->hasMany(Typebusiness::class);
    }
}

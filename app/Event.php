<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    
    protected $fillable = ['title','descripcion','location','image','date','start','finish','web_site','user_id'];

    protected $dates = [];

    public static $rules = [
        'title' => 'required|max:50',
        'descripcion' => 'required',
        'location' => 'required',
        'image' =>'required',
        'date' => 'required',
        'start' => 'required',
        'finish' => 'required',
        'web_site' => 'required',
        'user_id' => 'required'
    ];

    // Relationships
    public function user() {
    return $this->hasOne('App\User');
    }
}

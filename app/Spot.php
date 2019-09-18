<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    //
    protected $fillable = ['name','description','location','image'];

    protected $dates = [];

    public static $rules = [
        'name' => 'required|max:50',
        'description' => 'required',
        'location' => 'required',
        'image' =>'required',
    ];
}

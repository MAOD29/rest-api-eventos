<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
     use Sluggable;
    //
    protected $fillable = ['name','description','location','image'];

    protected $dates = [];

    public static $rules = [
        'name' => 'required|max:50',
        'description' => 'required',
        'location' => 'required',
        'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
    ];
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    use Sluggable;
    
    protected $fillable = ['title','descripcion','location','image','date','start','finish','web_site','user_id'];

    protected $dates = [];

    public static $rules = [
        'title' => 'required|max:50',
        'descripcion' => 'required',
        'location' => 'required',
       'image' =>'required|image|mimes:jpeg,png,jpg|max:2048',
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
     public function sluggable() {
        return [
            'slug' => [
                'source' => 'title',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Symfony\Component\String\Slugger\SluggerInterface;

class Post extends Model
{
    use HasFactory, Sluggable;


    protected $fillable = [
        'user_id',
        'category_id',
        'photo_id',
        'title',
        'body',
        'slug'
    ];

    public function sluggable(): array
    {
        return[
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function comments(){
       return $this->hasMany('App\Models\Comment');
    }

    public function photoPlaceholder(){
        return 'http://placehold.it/700x200';
    }

}

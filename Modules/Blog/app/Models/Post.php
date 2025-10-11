<?php

namespace Modules\Blog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Blog\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name', 'description'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'link',
        'image',
        'status',
        'order',
        'slug',
        'is_home'
    ];

    public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }
}

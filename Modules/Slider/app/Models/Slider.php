<?php

namespace Modules\Slider\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Slider\Database\Factories\SliderFactory;

class Slider extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'link',
        'status',
        'order',
        'image',
    ];

   
}

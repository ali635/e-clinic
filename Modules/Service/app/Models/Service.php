<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Service\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name','short_description','description'];

    protected $fillable = [
        'price',
        'start',
        'end',
        'patient_time_minute',
        'status',
        'order',
        'image',
        'is_home'
    ];

    // protected static function newFactory(): ServiceFactory
    // {
    //     // return ServiceFactory::new();
    // }
}

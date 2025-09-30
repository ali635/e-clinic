<?php

namespace Modules\Location\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Location\Database\Factories\CityFactory;

class City extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'status',
        'order',
        'country_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // protected static function newFactory(): CityFactory
    // {
    //     // return CityFactory::new();
    // }
}

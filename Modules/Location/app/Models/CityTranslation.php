<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Location\Database\Factories\CityTransaltionFactory;

class CityTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'city_id',
    ];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

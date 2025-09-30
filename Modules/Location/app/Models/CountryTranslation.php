<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Location\Database\Factories\CountryTransaltionFactory;

class CountryTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
       /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'country_id',
    ];

    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

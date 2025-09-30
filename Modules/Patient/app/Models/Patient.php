<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Location\Models\City;
use Modules\Location\Models\Country;

// use Modules\Patient\Database\Factories\PatientFactory;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'country_id',
        'city_id',
        'status'
    ];


    public function diseases()
    {
        return $this->hasMany(PatientDisease::class, 'patient_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    // protected static function newFactory(): PatientFactory
    // {
    //     // return PatientFactory::new();
    // }
}

<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Location\Models\City;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Location\Models\Country;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Modules\Booking\Models\Visit;

// use Modules\Patient\Database\Factories\PatientFactory;

class Patient extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'status',
        'hear_about_us'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
    protected $hidden = [
        'password',
    ];


    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->date_of_birth
                ? $this->date_of_birth->age
                : null,
        );
    }

    public function diseases()
    {
        return $this->hasMany(PatientDisease::class, 'patient_id');
    }


    public function diseasesMany()
    {
        return $this->belongsToMany(
            Disease::class,
            'patient_diseases',
            'patient_id',
            'disease_id'
        );
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }
}

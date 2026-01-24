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
use Modules\Location\Models\Area;

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
        'referral_id',
        'hear_about_us',
        'other_phone',
        'area_id',
        'marital_status',
        'img_profile',
        'job_id',
        'race_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'password' => 'hashed',
    ];
    protected $hidden = [
        'password',
        'remember_token',
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

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function race()
    {
        return $this->belongsTo(PatientRace::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

     public function job()
    {
        return $this->belongsTo(PatientJob::class);
    }


    public function patientInfo()
    {
        return $this->hasOne(\Modules\Firebase\Models\PatientInfo::class);
    }

    /**
     * Calculate the patient's star rating based on completed visits.
     * Uses the loyalty program logic: 0-2 visits = 0 stars, 3-4 = 1 star, 
     * 5-9 = 2 stars, 10-14 = 3 stars, 15+ = 4 stars
     *
     * @return int Star rating (0-4)
     */
    public function getStarRating(): int
    {
        $completedVisits = $this->visits()->where('is_arrival', true)->count();

        if ($completedVisits >= 15) {
            return 4;
        } elseif ($completedVisits >= 10) {
            return 3;
        } elseif ($completedVisits >= 5) {
            return 2;
        } elseif ($completedVisits >= 3) {
            return 1;
        }

        return 0;
    }
}

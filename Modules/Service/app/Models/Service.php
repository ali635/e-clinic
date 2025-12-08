<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Booking\Models\Visit;

// use Modules\Service\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name', 'short_description', 'description'];

    protected $fillable = [
        'price',
        'patient_time_minute',
        'status',
        'order',
        'image',
        'is_home',
        'slug'
    ];

    protected $appends = ['display_name'];


    public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }


    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

 

    public function schedules()
    {
        return $this->hasMany(ServiceSchedule::class);
    }
}

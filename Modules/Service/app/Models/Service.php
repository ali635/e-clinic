<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Booking\Models\Visit;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

// use Modules\Service\Database\Factories\ServiceFactory;

class Service extends Model
{
    use HasFactory, Translatable, LogsActivity;

    protected $with = ['translations'];

    public $translatedAttributes = ['name', 'short_description', 'description'];

    protected $fillable = [
        'price',
        'start',
        'end',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('service')
            ->setDescriptionForEvent(function (string $eventName) {
                return __('Service ":name" has been :event.', [
                    'name' => $this->getTranslation('name', app()->getLocale()),
                    'event' => $eventName,
                ]);
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(\Spatie\Activitylog\Contracts\Activity $activity): void
    {
        $properties = $activity->properties->toArray();
        $attributes = $properties['attributes'] ?? [];
        $nameTrans = $this->getTranslation('name', app()->getLocale());
        $shortDescriptionTrans = $this->getTranslation('short_description', app()->getLocale());
        $descriptionTrans = $this->getTranslation('description', app()->getLocale());

        $attributes = array_merge($attributes, [
            'name' => $nameTrans->name,
            'short_description' => $shortDescriptionTrans->short_description,
            'description' => $descriptionTrans->description,
        ]);
        $properties['attributes'] = $attributes;
        $activity->properties = $properties;
    }
}

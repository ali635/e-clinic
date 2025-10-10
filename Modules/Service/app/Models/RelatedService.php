<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

// use Modules\Service\Database\Factories\RelatedServiceFactory;

class RelatedService extends Model
{
    use HasFactory, Translatable,LogsActivity;

    protected $with = ['translations'];
    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'price'
    ];


     public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }

      public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('RelatedService')
            ->setDescriptionForEvent(function (string $eventName) {
                return __('Related Service ":name" has been :event.', [
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
        $attributes = array_merge($attributes, [
            'name' => $nameTrans->name,
        ]);
        $properties['attributes'] = $attributes;
        $activity->properties = $properties;
    }
}

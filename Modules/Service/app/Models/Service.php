<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;
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
                    'name' => $this->getTranslation('name', App::getLocale()),
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

        // Extract the name from the Livewire/Filament request payload
        $name = $short_description = $description = null;
        $requestData = request()->all();

        // Check for nested Livewire component data
        if (isset($requestData['components']) && is_array($requestData['components'])) {
            foreach ($requestData['components'] as $component) {
                if (isset($component['snapshot'])) {
                    $snapshot = json_decode($component['snapshot'], true);
                    if (isset($snapshot['data']['name'])) {
                        $name = $snapshot['data']['name'];
                        $short_description = $snapshot['data']['short_description'] ?? null;
                        $description = $snapshot['data']['description'] ?? null;
                        break;
                    }
                }
            }
        }

        // Fallback to direct request input
        $name = $name ?: request()->input('name');
        $short_description = $short_description ?: request()->input('short_description');
        $description = $description ?: request()->input('description');

        // Get current translations
        $nameTrans = $this->getTranslation('name', App::getLocale());
        $shortDescriptionTrans = $this->getTranslation('short_description', App::getLocale());
        $descriptionTrans = $this->getTranslation('description', App::getLocale());

        $attributes = array_merge($attributes, [
            'name' => $name ?: $nameTrans,
            'short_description' => $short_description ?: $shortDescriptionTrans,
            'description' => $description ?: $descriptionTrans,
        ]);

        $properties['attributes'] = $attributes;
        $activity->properties = $properties;
    }

    public function schedules()
    {
        return $this->hasMany(ServiceSchedule::class);
    }
}

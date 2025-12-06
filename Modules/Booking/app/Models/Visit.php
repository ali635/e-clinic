<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\Service;
use Illuminate\Notifications\Notifiable;
use Modules\Booking\Observers\VisitObserver;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Booking\Database\Factories\VisitFactory;
#[ObservedBy([VisitObserver::class])]
class Visit extends Model
{
    use HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'patient_id',
        'service_id',
        'price',
        'is_arrival',
        'arrival_time',
        'lab_tests',
        'x_rays',
        'treatment',
        'doctor_description',
        'secretary_description',
        'total_price',
        'notes',
        'attachment',
        'patient_description',
        'status',
        'chief_complaint',
        'medical_history',
        'diagnosis',
        'sys',
        'dia',
        'pulse_rate',
        'weight',
        'height',
        'body_max_index',
        'payment_method',
        'discount_amount',
        'total_after_discount',
    ];

    protected function casts(): array
    {
        return [
            'lab_tests' => 'array',
            'x_rays' => 'array',
        ];
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function relatedService()
    {
        return $this->hasMany(RelatedServiceVisit::class);
    }
    public function medicines()
    {
        return $this->hasMany(MedicineVisit::class);
    }
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'visit_id', 'id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class)->where('status', 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('Visit')
            ->setDescriptionForEvent(function (string $eventName) {
                return __('Visit for patient ":name" has been :event.', [
                    'name' => $this->patient?->name ?? 'Unknown Patient',
                    'event' => $eventName,
                ]);
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // --- Customize What Gets Stored in Activity Log ---
    public function tapActivity(\Spatie\Activitylog\Contracts\Activity $activity): void
    {
        $properties = $activity->properties->toArray();
        $attributes = $properties['attributes'] ?? [];

        // Replace IDs with readable names
        $attributes['patient'] = $this->patient?->name ?? null;

        // For service name (translated)
        $attributes['service'] = $this->service
            ? $this->service->getTranslation('name', app()->getLocale())->name
            : null;

        // Optionally remove raw IDs (cleaner logs)
        unset($attributes['patient_id'], $attributes['service_id']);

        // Save updated data back
        $properties['attributes'] = $attributes;
        $activity->properties = $properties;
    }
}

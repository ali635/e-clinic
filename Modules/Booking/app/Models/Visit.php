<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\Service;
use Illuminate\Notifications\Notifiable;
use Modules\Booking\Observers\VisitObserver;

// use Modules\Booking\Database\Factories\VisitFactory;
#[ObservedBy([VisitObserver::class])]
class Visit extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'patient_id',
        'service_id',
        'price',
        'is_arrival',
        'arrival_time',
        'lab_tests',
        'x-rays',
        'treatment',
        'doctor_description',
        'secretary_description',
        'total_price',
        'notes',
        'attachment'
    ];

    protected function casts(): array
    {
        return [
            'lab_tests' => 'array',
            'x-rays' => 'array',

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

    public function patient()
    {
        return $this->belongsTo(Patient::class)->where('status', 1);
    }
}

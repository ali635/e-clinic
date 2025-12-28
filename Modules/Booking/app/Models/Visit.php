<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\Room\Models\Room;
use Modules\Service\Models\Service;
use Illuminate\Notifications\Notifiable;
use Modules\Booking\Observers\VisitObserver;
use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Traits\LogsActivity;

// use Modules\Booking\Database\Factories\VisitFactory;
#[ObservedBy([VisitObserver::class])]
class Visit extends Model
{
    use HasFactory, Notifiable;

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
        'diagnosis',
        'cancel_reason',
        'medicines_list',
        'room_id',
        'result_ai',
        'next_visit'
    ];

    protected function casts(): array
    {
        return [
            'lab_tests' => 'array',
            'x_rays' => 'array',
            'chief_complaint' => 'array',
            'medical_history' => 'array',
            'diagnosis' => 'array',
            'treatment' => 'array',
            'medicines_list' => 'array',
            'arrival_time' => 'datetime',
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

    /**
     * Get the room this visit is assigned to.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function isDelayed(): bool
    {
        return $this->arrival_time && \Carbon\Carbon::parse($this->arrival_time)->diffInMinutes(now()) > 30;
    }

    /**
     * Get formatted visit data for AI analysis
     * 
     * @return string
     */
    public function getVisitDataForAI(): string
    {
        $data = [];

        // Patient Information
        if ($this->patient) {
            $data[] = "Patient Information:";
            $data[] = "- Name: " . ($this->patient->name ?? 'N/A');
            $data[] = "- Age: " . ($this->patient->age ?? 'N/A');
            $data[] = "- Gender: " . ($this->patient->gender ?? 'N/A');
            $data[] = "";
        }

        // Vital Signs
        $data[] = "Vital Signs:";
        $data[] = "- Blood Pressure: Systolic: " . ($this->sys ?? 'N/A') . " mmHg, Diastolic: " . ($this->dia ?? 'N/A') . " mmHg";
        $data[] = "- Pulse Rate: " . ($this->pulse_rate ?? 'N/A') . " bpm";
        $data[] = "";

        // Anthropometric Measurements
        $data[] = "Anthropometric Measurements:";
        $data[] = "- Weight: " . ($this->weight ?? 'N/A') . " kg";
        $data[] = "- Height: " . ($this->height ?? 'N/A') . " cm";
        $data[] = "- BMI: " . ($this->body_max_index ?? 'N/A');
        $data[] = "";

        // Chief Complaint
        if ($this->chief_complaint && is_array($this->chief_complaint) && count($this->chief_complaint) > 0) {
            $data[] = "Chief Complaint:";
            $data[] = "- " . implode(", ", $this->chief_complaint);
            $data[] = "";
        }

        // Notes
        if ($this->notes) {
            $data[] = "Notes:";
            $data[] = $this->notes;
            $data[] = "";
        }

        // Past Medical History
        if ($this->medical_history && is_array($this->medical_history) && count($this->medical_history) > 0) {
            $data[] = "Past Medical History:";
            $data[] = "- " . implode(", ", $this->medical_history);
            $data[] = "";
        }

        // Diagnosis
        if ($this->diagnosis && is_array($this->diagnosis) && count($this->diagnosis) > 0) {
            $data[] = "Diagnosis:";
            $data[] = "- " . implode(", ", $this->diagnosis);
            $data[] = "";
        }

        // Doctor Description & Treatment Notes
        if ($this->doctor_description) {
            $data[] = "Doctor Description:";
            $data[] = $this->doctor_description;
            $data[] = "";
        }

        // Treatment
        if ($this->treatment && is_array($this->treatment) && count($this->treatment) > 0) {
            $data[] = "Treatment:";
            $data[] = "- " . implode(", ", $this->treatment);
            $data[] = "";
        }

        // Medications
        if ($this->medicines_list && is_array($this->medicines_list) && count($this->medicines_list) > 0) {
            $data[] = "Medicines Prescribed:";
            $data[] = "- " . implode(", ", $this->medicines_list);
            $data[] = "";
        }

        // Laboratory Tests
        if ($this->lab_tests && is_array($this->lab_tests) && count($this->lab_tests) > 0) {
            $data[] = "Laboratory Tests:";
            $data[] = "- " . implode(", ", $this->lab_tests);
            $data[] = "";
        }

        // Imaging/X-Rays
        if ($this->x_rays && is_array($this->x_rays) && count($this->x_rays) > 0) {
            $data[] = "Imaging Results (X-Rays):";
            $data[] = "- " . implode(", ", $this->x_rays);
            $data[] = "";
        }

        // Service Information
        if ($this->service) {
            $data[] = "Service:";
            $data[] = "- " . ($this->service->name ?? 'N/A');
            $data[] = "";
        }

        return implode("\n", $data);
    }

}

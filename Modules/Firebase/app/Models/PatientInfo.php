<?php

namespace Modules\Firebase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;

class PatientInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'patient_info';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'fcm_token',
        'current_lang',
        'device_info',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'device_info' => 'array',
    ];

    /**
     * Get the patient that owns the patient info.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

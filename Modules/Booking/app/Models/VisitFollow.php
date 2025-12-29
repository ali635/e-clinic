<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;

class VisitFollow extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'visit_id',
        'date',
        'status',
        'comments',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

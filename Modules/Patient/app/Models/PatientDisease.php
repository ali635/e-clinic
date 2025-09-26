<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Patient\Database\Factories\PatientDiseaseFactory;

class PatientDisease extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'disease_id',
    ];

    // protected static function newFactory(): PatientDiseaseFactory
    // {
    //     // return PatientDiseaseFactory::new();
    // }
}

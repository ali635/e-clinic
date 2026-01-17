<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Patient\Database\Factories\PatientJobFactory;

class PatientJob extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}

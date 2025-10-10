<?php

namespace Modules\Patient\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disease extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name'];


     public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_diseases');
    }
}
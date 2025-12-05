<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Medicine\Models\Medicine;

// use Modules\Booking\Database\Factories\RelatedServiceVisitFactory;

class MedicineVisit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'visit_id',
        'medicine_id',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

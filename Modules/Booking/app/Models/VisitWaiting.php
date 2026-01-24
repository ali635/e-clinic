<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;
use Modules\Room\Models\Room;
// use Modules\Booking\Database\Factories\VistiWaitingFactory;

class VisitWaiting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'visit_id',
        'is_arrival',
        'status',
        'room_id',
    ];

   public function patient()
   {
       return $this->belongsTo(Patient::class);
   }

   public function visit()
   {
       return $this->belongsTo(Visit::class);
   }

   public function room()
   {
       return $this->belongsTo(Room::class);
   }
}

<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;

// use Modules\Booking\Database\Factories\FeedbackFactory;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'visit_id',
        'patient_id',
        'comments',
        'rating',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class)->where('status', 1);
    }
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    // protected static function newFactory(): FeedbackFactory
    // {
    //     // return FeedbackFactory::new();
    // }
}

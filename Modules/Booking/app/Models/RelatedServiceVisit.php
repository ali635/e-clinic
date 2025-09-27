<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Models\RelatedService;

// use Modules\Booking\Database\Factories\RelatedServiceVisitFactory;

class RelatedServiceVisit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'visit_id',
        'related_service_id',
        'price_related_service',
        'qty'
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function relatedService()
    {
        return $this->belongsTo(RelatedService::class);
    }
}

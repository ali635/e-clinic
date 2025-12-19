<?php

namespace Modules\Room\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Booking\Models\Visit;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'status',
        'description',
        'current_visit_id',
        'is_ready',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_ready' => 'boolean',
    ];

    /**
     * Get the current visit in this room.
     */
    public function currentVisit()
    {
        return $this->belongsTo(Visit::class, 'current_visit_id');
    }

    /**
     * Get all visits that have been assigned to this room.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}

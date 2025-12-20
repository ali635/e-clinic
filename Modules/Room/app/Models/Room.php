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
        'doctor_stage',
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

    /**
     * Check if room is available for new patients.
     */
    public function isAvailable(): bool
    {
        return $this->doctor_stage === 'available';
    }

    /**
     * Check if room is waiting for assistant doctor.
     */
    public function isWaitingAssistant(): bool
    {
        return $this->doctor_stage === 'waiting_assistant';
    }

    /**
     * Check if room is waiting for main doctor.
     */
    public function isWaitingMain(): bool
    {
        return $this->doctor_stage === 'waiting_main';
    }

    /**
     * Get the status color for badges.
     */
    public function getStatusColor(): string
    {
        return match ($this->doctor_stage) {
            'available' => 'success',
            'waiting_assistant' => 'info',
            'waiting_main' => 'warning',
            default => 'gray',
        };
    }

    /**
     * Get human-readable status label.
     */
    public function getStatusLabel(): string
    {
        return match ($this->doctor_stage) {
            'available' => __('Available'),
            'waiting_assistant' => __('With Assistant Dr.'),
            'waiting_main' => __('With Main Dr.'),
            default => __('Unknown'),
        };
    }
}

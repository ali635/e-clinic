<?php

namespace Modules\Firebase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;

class FirebaseNotification extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'firebase_notifications';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'message',
        'image',
        'screen_event',
        'data',
        'send_date',
        'is_sent',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'send_date' => 'datetime',
        'is_sent' => 'boolean',
        'data' => 'array',
    ];

    /**
     * Get the patients that should receive this notification.
     */
    public function patients()
    {
        return $this->belongsToMany(
            Patient::class,
            'firebase_notification_patient',
            'firebase_notification_id',
            'patient_id'
        )->withTimestamps();
    }

    /**
     * Get the logs for this notification.
     */
    public function logs()
    {
        return $this->hasMany(FirebaseNotificationLog::class);
    }

    /**
     * Check if notification is scheduled.
     */
    public function isScheduled(): bool
    {
        return $this->send_date !== null && $this->send_date->isFuture();
    }

    /**
     * Check if notification should be sent to all patients.
     */
    public function isForAllPatients(): bool
    {
        return $this->patients()->count() === 0;
    }

    /**
     * Get the status of the notification.
     */
    public function getStatusAttribute(): string
    {
        if ($this->is_sent) {
            return 'sent';
        }

        if ($this->isScheduled()) {
            return 'scheduled';
        }

        return 'pending';
    }
}

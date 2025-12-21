<?php

namespace Modules\Firebase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Patient\Models\Patient;

class FirebaseNotificationLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'firebase_notification_logs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'firebase_notification_id',
        'is_sent',
        'error_exceptions',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_sent' => 'boolean',
    ];

    /**
     * Get the patient that this log belongs to.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the notification that this log belongs to.
     */
    public function firebaseNotification()
    {
        return $this->belongsTo(FirebaseNotification::class);
    }
}

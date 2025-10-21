<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Enums\DayOfWeek;

// use Modules\Service\Database\Factories\ServiceScheduleFactory;

class ServiceSchedule extends Model
{
    use HasFactory;


    protected $fillable = [
        'service_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'day_of_week' => DayOfWeek::class,
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

\Illuminate\Support\Facades\Schedule::command('firebase:send-birthday-notifications')->dailyAt('10:00');
\Illuminate\Support\Facades\Schedule::command('firebase:send-visit-reminders')->dailyAt('09:00');

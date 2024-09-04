<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// using schedule
\Illuminate\Support\Facades\Schedule::command('app:test-command')
    ->dailyAt('13:00');

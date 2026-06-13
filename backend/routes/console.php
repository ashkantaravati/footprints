<?php
use Illuminate\Support\Facades\Schedule;

Schedule::command('footprints:cleanup')->hourly()->withoutOverlapping();

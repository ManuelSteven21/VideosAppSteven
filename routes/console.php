<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    // Usar `info()` para mostrar el mensaje en la consola
    info(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment('Beauty begins with confidence.');
})->purpose('Display an inspiring salon message');


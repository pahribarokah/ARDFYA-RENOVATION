<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register the FixOrphanedInquiries command
Artisan::command('fix:inquiries:run', function () {
    $this->call('fix:inquiries');
})->purpose('Fix orphaned inquiries by associating them with customer accounts based on email');

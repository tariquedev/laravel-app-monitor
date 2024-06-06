<?php

return [
    'admin_email' => env('APPMONITOR_ADMIN_EMAIL', 'admin@example.com'),
    'notify_on_down' => env('APPMONITOR_NOTIFY_ON_DOWN', true),
    'notify_on_error' => env('APPMONITOR_NOTIFY_ON_ERROR', true),
    'error_codes' => [500, 502, 503, 504, 413],
];

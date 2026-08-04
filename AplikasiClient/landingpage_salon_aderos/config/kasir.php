<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kasir API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to the Sistem Kasir (NestJS) REST API.
    | The landing page acts as a client/consumer of this API.
    |
    */

    'api_url' => env('KASIR_API_URL', 'http://localhost:3000/api'),
    'tenant_slug' => env('KASIR_TENANT_SLUG', 'aderose-glowing-salon'),
    'timeout' => env('KASIR_API_TIMEOUT', 10),
];

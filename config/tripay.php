<?php

return [
    'api_key' => env('TRIPAY_API_KEY'),
    'private_key' => env('TRIPAY_PRIVATE_KEY'),
    'merchant_code' => env('TRIPAY_MERCHANT_CODE'),
    'endpoint' => env('APP_ENV') == 'production' ? "https://tripay.co.id/api" : "https://tripay.co.id/api-sandbox",
];

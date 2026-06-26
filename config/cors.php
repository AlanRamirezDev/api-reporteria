<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */
    
    'paths' => ['api/*', '*'], 
    
    'allowed_methods' => ['*'],
    
    'allowed_origins' => [
        'http://localhost:4321',
        'http://localhost:3000',
        'https://portafolio-dev-xi.vercel.app'
    ],
    
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
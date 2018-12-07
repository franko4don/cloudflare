<?php

return [
    'key' => env('CLOUDFLARE_API_KEY', ''),
    
    'email' => env('CLOUDFLARE_EMAIL', ''),

    'per_page' => env('CLOUDFLARE_RESULT_PER_PAGE', '50'),
    
    'url' => env('CLOUDFLARE_API_URL', 'https://api.cloudflare.com/client/v4/')
];


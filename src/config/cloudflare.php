<?php

return [
    'cloudflare_api_key' => env('CLOUDFLARE_API_KEY', ''),
    
    'cloudflare_email' => env('CLOUDFLARE_EMAIL', ''),

    'default_result_per_page' => env('CLOUDFLARE_RESULT_PER_PAGE', '50'),
    
    'cloudflare_api_url' => env('CLOUDFLARE_API_URL', 'https://api.cloudflare.com/client/v4/')
];


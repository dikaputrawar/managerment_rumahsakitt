    <?php

    return [

        'paths' => ['api/*', 'sanctum/*'],

        'allowed_methods' => ['*'],

        // Ganti * dengan domain frontend kamu, misal http://localhost:3000 atau http://127.0.0.1:5173
        // Kalau mau sementara, boleh pakai '*', tapi ini kurang aman di production
        'allowed_origins' => ['*'],

        'allowed_origins_patterns' => [],

        'allowed_headers' => ['*'],

        'exposed_headers' => [],

        'max_age' => 0,

        'supports_credentials' => false,

    ];

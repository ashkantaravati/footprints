<?php
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'footprints',
        'user' => 'footprints_user',
        'pass' => 'change-me',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'base_url' => 'https://example.com',
        'cookie_name' => 'footprints_session',
        'session_days' => 60,
        'password_min_length' => 12,
        'poll_interval_seconds' => 3,
        'max_upload_mb' => 10,
        'max_groups_per_user' => 20,
    ],
];

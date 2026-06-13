<?php
return [
    'password_min' => (int) env('FOOTPRINTS_PASSWORD_MIN', 12),
    'poll_interval' => (int) env('FOOTPRINTS_POLL_INTERVAL', 3),
    'default_retention_days' => (int) env('FOOTPRINTS_DEFAULT_RETENTION_DAYS', 90),
    'attachment_retention_days' => (int) env('FOOTPRINTS_ATTACHMENT_RETENTION_DAYS', 30),
    'max_groups_per_user' => (int) env('FOOTPRINTS_MAX_GROUPS_PER_USER', 20),
    'max_upload_mb' => (int) env('FOOTPRINTS_MAX_UPLOAD_MB', 10),
];

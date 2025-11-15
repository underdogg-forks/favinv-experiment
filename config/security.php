<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains security-related settings for the application.
    | Adjust these settings based on your security requirements.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for various endpoints to prevent abuse.
    |
    */
    'rate_limiting' => [
        'login' => [
            'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
            'decay_minutes' => env('LOGIN_DECAY_MINUTES', 15),
        ],
        'registration' => [
            'max_attempts' => env('REGISTRATION_MAX_ATTEMPTS', 3),
            'decay_minutes' => env('REGISTRATION_DECAY_MINUTES', 60),
        ],
        'api' => [
            'max_attempts' => env('API_MAX_ATTEMPTS', 60),
            'decay_minutes' => env('API_DECAY_MINUTES', 1),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Policy
    |--------------------------------------------------------------------------
    |
    | Configure password requirements for user accounts.
    |
    */
    'password_policy' => [
        'min_length' => env('PASSWORD_MIN_LENGTH', 12),
        'require_uppercase' => env('PASSWORD_REQUIRE_UPPERCASE', true),
        'require_lowercase' => env('PASSWORD_REQUIRE_LOWERCASE', true),
        'require_numbers' => env('PASSWORD_REQUIRE_NUMBERS', true),
        'require_special_chars' => env('PASSWORD_REQUIRE_SPECIAL_CHARS', true),
        'prevent_common_passwords' => env('PASSWORD_PREVENT_COMMON', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    |
    | Configure file upload restrictions to prevent malicious uploads.
    |
    */
    'file_upload' => [
        'max_size' => env('FILE_UPLOAD_MAX_SIZE', 10240), // KB
        'allowed_extensions' => [
            'jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 
            'xls', 'xlsx', 'txt', 'zip', 'csv'
        ],
        'blocked_extensions' => [
            'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps',
            'exe', 'bat', 'cmd', 'sh', 'bash', 'ps1',
            'js', 'jsp', 'asp', 'aspx', 'cgi', 'pl'
        ],
        'mime_validation' => env('FILE_UPLOAD_MIME_VALIDATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Additional security headers configuration.
    |
    */
    'headers' => [
        'hsts_max_age' => env('HSTS_MAX_AGE', 31536000), // 1 year in seconds
        'hsts_include_subdomains' => env('HSTS_INCLUDE_SUBDOMAINS', true),
        'hsts_preload' => env('HSTS_PRELOAD', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Blocking
    |--------------------------------------------------------------------------
    |
    | Configure IP-based blocking for security.
    |
    */
    'ip_blocking' => [
        'enabled' => env('IP_BLOCKING_ENABLED', true),
        'max_failed_attempts' => env('IP_MAX_FAILED_ATTEMPTS', 10),
        'block_duration_minutes' => env('IP_BLOCK_DURATION', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Authentication
    |--------------------------------------------------------------------------
    |
    | 2FA configuration options.
    |
    */
    'two_factor' => [
        'enforce_for_admins' => env('2FA_ENFORCE_ADMINS', true),
        'backup_codes_count' => env('2FA_BACKUP_CODES_COUNT', 8),
    ],
];

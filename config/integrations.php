<?php

return [
    'enabled' => env('INTEGRATIONS_ENABLED', true),
    'queue' => env('INTEGRATIONS_QUEUE_ENABLED', false),
    'timeout' => (int) env('INTEGRATIONS_TIMEOUT', 30),
    'retry_attempts' => (int) env('INTEGRATIONS_RETRY_ATTEMPTS', 3),

    'email' => [
        'enabled' => env('MAIL_NOTIFICATIONS_ENABLED', true),
    ],

    'webhooks' => [
        'enabled' => env('WEBHOOKS_ENABLED', true),
        'default_secret' => env('WEBHOOK_DEFAULT_SECRET'),
    ],

    'github' => [
        'enabled' => env('GITHUB_WEBHOOKS_ENABLED', true),
        'secret' => env('GITHUB_WEBHOOK_SECRET'),
    ],

    'gitlab' => [
        'enabled' => env('GITLAB_WEBHOOKS_ENABLED', true),
        'secret' => env('GITLAB_WEBHOOK_SECRET'),
    ],

    'bitbucket' => [
        'enabled' => env('BITBUCKET_WEBHOOKS_ENABLED', true),
        'secret' => env('BITBUCKET_WEBHOOK_SECRET'),
    ],

    'context' => [
        'ticket_folio_pattern' => '/#?(TCK-\d{6})/i',
    ],
];

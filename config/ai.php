<?php

return [
    'enabled' => env('OPENAI_TICKETS_ENABLED', false),
    'provider' => env('AI_PROVIDER', 'openai'),
    'model' => env('OPENAI_MODEL', 'gpt-4.1-mini'),
    'timeout' => (int) env('OPENAI_TIMEOUT', env('OPENAI_REQUEST_TIMEOUT', 60)),
    'max_context_articles' => (int) env('AI_MAX_CONTEXT_ARTICLES', 5),
    'max_ticket_comments' => (int) env('AI_MAX_TICKET_COMMENTS', 8),
    'max_response_length' => (int) env('AI_MAX_RESPONSE_LENGTH', 4000),
];

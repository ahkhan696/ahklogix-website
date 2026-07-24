<?php

return [
    'driver'      => env('CHAT_DRIVER', 'gemini'),
    'daily_limit' => (int) env('CHAT_DAILY_LIMIT', 200),
];

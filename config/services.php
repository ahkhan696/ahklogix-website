<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ── Anthropic / Claude API ────────────────────────────────────────────────
    'anthropic' => [
        'key'   => env('ANTHROPIC_API_KEY'),
        'model' => env('ANTHROPIC_CHAT_MODEL', 'claude-haiku-4-5-20251001'),
    ],

    // ── AHKLOGIX site-wide settings ──────────────────────────────────────────
    // These fall back to .env values. Phase 3 replaces them with the Settings
    // table so the owner can update them from the Filament admin panel.
    'whatsapp_number' => env('WHATSAPP_NUMBER', ''),
    'booking_url'     => env('BOOKING_URL', '#'),
    'contact_email'   => env('CONTACT_EMAIL', 'hello@ahklogix.com'),
    'chatbot_embed'   => env('CHATBOT_EMBED_CODE', null),

];

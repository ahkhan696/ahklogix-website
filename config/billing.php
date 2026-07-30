<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Billing enabled
    |--------------------------------------------------------------------------
    | When false: every authenticated customer is treated as pro (free-beta
    | mode), checkout routes are short-circuited server-side, and no calls
    | are made to Paddle. Flip to true to enable real Paddle billing + gating.
    |
    | Set via BILLING_ENABLED in .env. Default: true (billing on).
    */

    'enabled' => (bool) env('BILLING_ENABLED', true),

];

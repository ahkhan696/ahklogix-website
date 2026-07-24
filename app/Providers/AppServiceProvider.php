<?php

namespace App\Providers;

use App\Contracts\ChatDriver;
use App\Services\Chat\ClaudeDriver;
use App\Services\Chat\GeminiDriver;
use App\Services\Chat\RuleBasedDriver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChatDriver::class, function () {
            return match (config('chat.driver', 'gemini')) {
                'claude' => new ClaudeDriver(),
                'rules'  => new RuleBasedDriver(),
                default  => new GeminiDriver(),
            };
        });
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('chat', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->ip())
                ->response(fn () => response()->json(
                    ['error' => 'Too many requests. Please wait a moment before trying again.'],
                    429
                ));
        });
    }
}


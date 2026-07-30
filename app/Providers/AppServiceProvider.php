<?php

namespace App\Providers;

use App\Contracts\ChatDriver;
use App\Contracts\SubscriptionGateway;
use App\Models\Customer;
use App\Models\PaddleCustomer;
use App\Services\Chat\ClaudeDriver;
use App\Services\Chat\GeminiDriver;
use App\Services\Chat\RuleBasedDriver;
use App\Services\Subscriptions\PaddleGateway;
use App\Services\Subscriptions\StripeGateway;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Paddle\Cashier as PaddleCashier;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Prevent Stripe Cashier from registering its webhook route — Paddle is active.
        \Laravel\Cashier\Cashier::ignoreRoutes();

        $this->app->bind(ChatDriver::class, function () {
            return match (config('chat.driver', 'gemini')) {
                'claude' => new ClaudeDriver(),
                'rules'  => new RuleBasedDriver(),
                default  => new GeminiDriver(),
            };
        });

        $this->app->bind(SubscriptionGateway::class, function () {
            $provider = \App\Models\Setting::get('payment_provider', 'paddle');
            return match ($provider) {
                'stripe' => new StripeGateway(),
                default  => new PaddleGateway(),
            };
        });
    }

    public function boot(): void
    {
        PaddleCashier::useCustomerModel(PaddleCustomer::class);

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

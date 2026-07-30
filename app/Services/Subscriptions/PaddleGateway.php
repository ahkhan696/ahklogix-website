<?php

namespace App\Services\Subscriptions;

use App\Contracts\SubscriptionGateway;
use App\Models\Customer;
use Laravel\Paddle\Cashier;
use Laravel\Paddle\Checkout;

class PaddleGateway implements SubscriptionGateway
{
    public function isSubscribed(Customer $customer): bool
    {
        return $customer->subscribed('default');
    }

    public function buildCheckout(Customer $customer, string $planId): Checkout
    {
        return $customer->subscribe($planId, 'default')
            ->returnTo(route('customer.account') . '?checkout=success');
    }

    public function billingPortalUrl(Customer $customer): ?string
    {
        $paddleCustomer = $customer->customer;

        if (! $paddleCustomer) {
            return null;
        }

        try {
            $response = Cashier::api('POST', "customers/{$paddleCustomer->paddle_id}/portal-sessions");
            return $response['data']['urls']['general']['overview'] ?? null;
        } catch (\Throwable) {
            return null;
        }
    }
}

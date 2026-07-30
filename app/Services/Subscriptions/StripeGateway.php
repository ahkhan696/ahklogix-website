<?php

namespace App\Services\Subscriptions;

use App\Contracts\SubscriptionGateway;
use App\Models\Customer;

/**
 * Stripe is not supported in Pakistan (2026) — this driver is a placeholder
 * for future re-enablement via a foreign entity.
 *
 * To re-enable: swap Customer's Billable trait back to Laravel\Cashier\Billable,
 * set payment_provider=stripe in admin settings, and fill STRIPE_* env vars.
 */
class StripeGateway implements SubscriptionGateway
{
    public function isSubscribed(Customer $customer): bool
    {
        throw new \RuntimeException('Stripe driver is not active. Set payment_provider=paddle in admin settings.');
    }

    public function buildCheckout(Customer $customer, string $planId): mixed
    {
        throw new \RuntimeException('Stripe driver is not active. Set payment_provider=paddle in admin settings.');
    }

    public function billingPortalUrl(Customer $customer): ?string
    {
        throw new \RuntimeException('Stripe driver is not active. Set payment_provider=paddle in admin settings.');
    }
}

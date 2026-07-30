<?php

namespace App\Contracts;

use App\Models\Customer;

interface SubscriptionGateway
{
    public function isSubscribed(Customer $customer): bool;

    /** Returns a driver-specific checkout object (e.g. Laravel\Paddle\Checkout). */
    public function buildCheckout(Customer $customer, string $planId): mixed;

    public function billingPortalUrl(Customer $customer): ?string;
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $customer     = Auth::guard('customer')->user();
        $isSubscribed = $customer->subscribed('pro');
        $subscription = $isSubscribed ? $customer->subscription('pro') : null;

        return view('customer.account.index', compact('customer', 'isSubscribed', 'subscription'));
    }

    public function checkout(string $price): RedirectResponse
    {
        $allowed = array_filter([
            config('services.stripe.price_monthly'),
            config('services.stripe.price_yearly'),
        ]);

        abort_unless(in_array($price, $allowed, true), 422);

        $customer = Auth::guard('customer')->user();

        if ($customer->subscribed('pro')) {
            return $this->billingPortal();
        }

        $checkout = $customer
            ->newSubscription('pro', $price)
            ->checkout([
                'success_url' => route('customer.account') . '?checkout=success',
                'cancel_url'  => route('customer.account'),
            ]);

        return redirect($checkout->url);
    }

    public function billingPortal(): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();

        return redirect(
            $customer->billingPortalUrl(route('customer.account'))
        );
    }
}

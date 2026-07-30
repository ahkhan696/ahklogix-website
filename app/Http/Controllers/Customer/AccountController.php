<?php

namespace App\Http\Controllers\Customer;

use App\Contracts\SubscriptionGateway;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(private SubscriptionGateway $gateway) {}

    public function index(): View
    {
        $customer     = Auth::guard('customer')->user();
        $isSubscribed = $this->gateway->isSubscribed($customer);
        $subscription = $customer->subscription('default');

        $monthlyPriceId = Setting::get('paddle_price_monthly');
        $yearlyPriceId  = Setting::get('paddle_price_yearly');

        $checkoutMonthly = (! $isSubscribed && $monthlyPriceId)
            ? $this->gateway->buildCheckout($customer, $monthlyPriceId)
            : null;

        $checkoutYearly = (! $isSubscribed && $yearlyPriceId)
            ? $this->gateway->buildCheckout($customer, $yearlyPriceId)
            : null;

        return view('customer.account.index', compact(
            'customer', 'isSubscribed', 'subscription',
            'checkoutMonthly', 'checkoutYearly'
        ));
    }

    public function billingPortal(): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        $url      = $this->gateway->billingPortalUrl($customer);

        if (! $url) {
            return redirect()->route('customer.account')
                ->with('error', 'Unable to open billing portal. Please try again later.');
        }

        return redirect($url);
    }
}

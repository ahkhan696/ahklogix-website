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

        $billingEnabled  = config('billing.enabled', true);
        $checkoutMonthly = null;
        $checkoutYearly  = null;

        if ($billingEnabled && ! $isSubscribed) {
            $monthlyPriceId = Setting::get('paddle_price_monthly');
            $yearlyPriceId  = Setting::get('paddle_price_yearly');

            if ($monthlyPriceId) {
                try {
                    $checkoutMonthly = $this->gateway->buildCheckout($customer, $monthlyPriceId);
                } catch (\Throwable $e) {
                    logger()->error('Paddle checkout (monthly) failed', ['error' => $e->getMessage()]);
                }
            }

            if ($yearlyPriceId) {
                try {
                    $checkoutYearly = $this->gateway->buildCheckout($customer, $yearlyPriceId);
                } catch (\Throwable $e) {
                    logger()->error('Paddle checkout (yearly) failed', ['error' => $e->getMessage()]);
                }
            }
        }

        return view('customer.account.index', compact(
            'customer', 'isSubscribed', 'subscription',
            'billingEnabled', 'checkoutMonthly', 'checkoutYearly'
        ));
    }

    public function billingPortal(): RedirectResponse
    {
        if (! config('billing.enabled', true)) {
            return redirect()->route('customer.account')
                ->with('error', 'Billing is not yet active.');
        }

        $customer = Auth::guard('customer')->user();
        $url      = $this->gateway->billingPortalUrl($customer);

        if (! $url) {
            return redirect()->route('customer.account')
                ->with('error', 'Unable to open billing portal. Please try again later.');
        }

        return redirect($url);
    }
}

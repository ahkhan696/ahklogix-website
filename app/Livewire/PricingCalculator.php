<?php

namespace App\Livewire;

use App\Contracts\SubscriptionGateway;
use App\Models\CalculatorScenario;
use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\Computed;

class PricingCalculator extends Component
{
    public string $platform    = 'amazon';
    public string $feePercent  = '15.0';
    public string $flatFee     = '0.00';
    public bool   $isPro       = false;
    public bool   $isGuest     = true;
    public bool   $comparisonMode = false;

    /** @var array<int, array{name: string, selling_price: string, cogs: string, shipping: string}> */
    public array $products = [];

    public string $scenarioName = '';

    private const FREE_TIER_MAX = 3;
    private const PRO_TIER_MAX  = 20;

    private const PLATFORM_DEFAULTS = [
        'amazon'  => ['percent' => '15.0',  'flat' => '0.00'],
        'shopify' => ['percent' => '2.9',   'flat' => '0.30'],
        'ebay'    => ['percent' => '12.9',  'flat' => '0.30'],
    ];

    public function mount(): void
    {
        $this->isPro   = $this->resolveProAccess();
        $this->isGuest = auth('customer')->guest();
        $this->products = [$this->emptyProduct()];
    }

    // ── Pro access resolution ─────────────────────────────────────────────────

    private function resolveProAccess(): bool
    {
        if (! config('billing.enabled', true)) {
            return true;
        }

        /** @var Customer|null $customer */
        $customer = auth('customer')->user();

        if (! $customer) {
            return false;
        }

        return app(SubscriptionGateway::class)->isSubscribed($customer);
    }

    private function authorizePro(): bool
    {
        if (! $this->isPro) {
            $this->dispatch('pro-required');
            return false;
        }
        return true;
    }

    // ── Platform / fee ────────────────────────────────────────────────────────

    public function updatedPlatform(string $value): void
    {
        $defaults = self::PLATFORM_DEFAULTS[$value] ?? self::PLATFORM_DEFAULTS['amazon'];
        $this->feePercent = $defaults['percent'];
        $this->flatFee    = $defaults['flat'];
    }

    // ── Product management ────────────────────────────────────────────────────

    public function addProduct(): void
    {
        $max = $this->isPro ? self::PRO_TIER_MAX : self::FREE_TIER_MAX;

        if (count($this->products) >= $max) {
            if (! $this->isPro) {
                $this->dispatch('pro-required');
            }
            return;
        }

        $this->products[] = $this->emptyProduct();
    }

    public function removeProduct(int $index): void
    {
        if (count($this->products) > 1) {
            array_splice($this->products, $index, 1);
            $this->products = array_values($this->products);
        }
    }

    public function resetAll(): void
    {
        $this->products       = [$this->emptyProduct()];
        $this->platform       = 'amazon';
        $this->feePercent     = '15.0';
        $this->flatFee        = '0.00';
        $this->comparisonMode = false;
        $this->scenarioName   = '';
    }

    // ── Comparison mode ───────────────────────────────────────────────────────

    public function toggleComparison(): void
    {
        if (! $this->authorizePro()) {
            return;
        }

        $this->comparisonMode = ! $this->comparisonMode;
    }

    // ── Saved scenarios ───────────────────────────────────────────────────────

    public function saveScenario(): void
    {
        if (! $this->authorizePro()) {
            return;
        }

        /** @var Customer|null $customer */
        $customer = auth('customer')->user();

        if (! $customer) {
            $this->dispatch('pro-required');
            return;
        }

        $name = trim($this->scenarioName) ?: 'Scenario ' . now()->format('M j, H:i');

        CalculatorScenario::create([
            'customer_id' => $customer->id,
            'name'        => $name,
            'platform'    => $this->platform,
            'fee_percent' => (float) $this->feePercent,
            'flat_fee'    => (float) $this->flatFee,
            'products'    => $this->products,
        ]);

        $this->scenarioName = '';
        unset($this->scenarios);

        $this->dispatch('scenario-saved', name: $name);
    }

    public function loadScenario(int $id): void
    {
        if (! $this->authorizePro()) {
            return;
        }

        /** @var Customer|null $customer */
        $customer = auth('customer')->user();

        if (! $customer) {
            return;
        }

        $scenario = CalculatorScenario::where('customer_id', $customer->id)->find($id);

        if (! $scenario) {
            return;
        }

        $this->platform   = $scenario->platform;
        $this->feePercent = (string) $scenario->fee_percent;
        $this->flatFee    = (string) $scenario->flat_fee;
        $this->products   = $scenario->products;
    }

    public function deleteScenario(int $id): void
    {
        if (! $this->authorizePro()) {
            return;
        }

        /** @var Customer|null $customer */
        $customer = auth('customer')->user();

        if (! $customer) {
            return;
        }

        CalculatorScenario::where('customer_id', $customer->id)->where('id', $id)->delete();

        unset($this->scenarios);
    }

    // ── Export ────────────────────────────────────────────────────────────────

    public function exportCsv(): mixed
    {
        if (! $this->authorizePro()) {
            return null;
        }

        $results  = $this->results;
        $products = $this->products;
        $platform = ucfirst($this->platform);
        $filename = 'pricing-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($results, $products, $platform) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Product', 'Platform', 'Selling Price', 'Platform Fees', 'Net Revenue', 'Profit', 'Margin %', 'Breakeven Price']);

            foreach ($products as $i => $product) {
                $r = $results[$i] ?? null;
                if (! $r || ! $r['hasData']) {
                    continue;
                }
                fputcsv($handle, [
                    $product['name'] ?: 'Product ' . ($i + 1),
                    $platform,
                    number_format($r['price'], 2),
                    number_format($r['fees'], 2),
                    number_format($r['net'], 2),
                    number_format($r['profit'], 2),
                    number_format($r['margin'], 1),
                    number_format($r['breakeven'], 2),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    // ── Computed properties ───────────────────────────────────────────────────

    #[Computed]
    public function results(): array
    {
        return array_map(function (array $p): array {
            $price    = (float) ($p['selling_price'] ?? 0);
            $cogs     = (float) ($p['cogs'] ?? 0);
            $shipping = (float) ($p['shipping'] ?? 0);
            $pct      = (float) $this->feePercent;
            $flat     = (float) $this->flatFee;

            $hasData = $price > 0;

            $fees      = $hasData ? round(($price * $pct / 100) + $flat, 2) : 0;
            $net       = $hasData ? round($price - $fees - $shipping, 2) : 0;
            $profit    = $hasData ? round($net - $cogs, 2) : 0;
            $margin    = ($hasData && $price > 0) ? round(($profit / $price) * 100, 1) : 0;
            $breakeven = ($pct < 100) ? round(($cogs + $shipping) / (1 - $pct / 100) + $flat, 2) : 0;

            return compact('hasData', 'price', 'fees', 'net', 'profit', 'margin', 'breakeven');
        }, $this->products);
    }

    #[Computed]
    public function scenarios(): array
    {
        /** @var Customer|null $customer */
        $customer = auth('customer')->user();

        if (! $customer || ! $this->isPro) {
            return [];
        }

        return $customer->calculatorScenarios()->get()->toArray();
    }

    #[Computed]
    public function comparison(): array
    {
        if (! $this->comparisonMode || ! $this->isPro) {
            return [];
        }

        $platforms = self::PLATFORM_DEFAULTS;
        $out = [];

        foreach ($platforms as $key => $defaults) {
            $pct  = (float) $defaults['percent'];
            $flat = (float) $defaults['flat'];
            $rows = [];

            foreach ($this->products as $p) {
                $price    = (float) ($p['selling_price'] ?? 0);
                $cogs     = (float) ($p['cogs'] ?? 0);
                $shipping = (float) ($p['shipping'] ?? 0);
                $hasData  = $price > 0;

                $fees      = $hasData ? round(($price * $pct / 100) + $flat, 2) : 0;
                $net       = $hasData ? round($price - $fees - $shipping, 2) : 0;
                $profit    = $hasData ? round($net - $cogs, 2) : 0;
                $margin    = ($hasData && $price > 0) ? round(($profit / $price) * 100, 1) : 0;

                $rows[] = compact('hasData', 'price', 'fees', 'net', 'profit', 'margin');
            }

            $out[$key] = ['label' => ucfirst($key), 'rows' => $rows];
        }

        return $out;
    }

    // ── Render ────────────────────────────────────────────────────────────────

    public function render(): \Illuminate\View\View
    {
        return view('livewire.pricing-calculator');
    }

    private function emptyProduct(): array
    {
        return ['name' => '', 'selling_price' => '', 'cogs' => '', 'shipping' => ''];
    }
}

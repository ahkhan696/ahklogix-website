<?php

namespace App\Livewire;

use Livewire\Component;

class PricingCalculator extends Component
{
    public string $platform = 'amazon';
    public string $feePercent = '15.0';
    public string $flatFee = '0.00';

    /** @var array<int, array{name: string, selling_price: string, cogs: string, shipping: string}> */
    public array $products = [];

    private const PLATFORM_DEFAULTS = [
        'amazon'  => ['percent' => '15.0',  'flat' => '0.00'],
        'shopify' => ['percent' => '2.9',   'flat' => '0.30'],
        'ebay'    => ['percent' => '12.9',  'flat' => '0.30'],
    ];

    private const FREE_TIER_MAX = 3;

    public function mount(): void
    {
        $this->products = [
            $this->emptyProduct(),
        ];
    }

    public function updatedPlatform(string $value): void
    {
        $defaults = self::PLATFORM_DEFAULTS[$value] ?? self::PLATFORM_DEFAULTS['amazon'];
        $this->feePercent = $defaults['percent'];
        $this->flatFee    = $defaults['flat'];
    }

    public function addProduct(): void
    {
        if (count($this->products) < self::FREE_TIER_MAX) {
            $this->products[] = $this->emptyProduct();
        }
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
        $this->products   = [$this->emptyProduct()];
        $this->platform   = 'amazon';
        $this->feePercent = '15.0';
        $this->flatFee    = '0.00';
    }

    /** @return array<int, array{has_data: bool, revenue: float, fees: float, net: float, profit: float, margin: float, breakeven: float}> */
    public function getResultsProperty(): array
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
            $breakeven = ($pct < 100) ? round($cogs / (1 - $pct / 100), 2) : 0;

            return compact('hasData', 'price', 'fees', 'net', 'profit', 'margin', 'breakeven');
        }, $this->products);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.pricing-calculator');
    }

    private function emptyProduct(): array
    {
        return ['name' => '', 'selling_price' => '', 'cogs' => '', 'shipping' => ''];
    }
}

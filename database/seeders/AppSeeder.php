<?php

namespace Database\Seeders;

use App\Models\App as AppModel;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run(): void
    {
        AppModel::firstOrCreate(
            ['slug' => 'pricing-calculator'],
            [
                'title'       => 'Pricing Calculator',
                'icon'        => 'calculator',
                'tagline'     => 'Calculate your true product margins across marketplaces in seconds.',
                'description' => '<p>The AHKLOGIX Pricing Calculator helps e-commerce sellers instantly understand true profitability — factoring in platform fees, COGS, shipping, and desired margins. No spreadsheets, no guesswork.</p><p>Connect your marketplace accounts or enter costs manually to get a clear picture of what you actually make on every sale.</p>',
                'feature_list' => [
                    ['label' => 'Basic margin & fee calculation',      'tier' => 'free'],
                    ['label' => 'Support for Amazon, Shopify, eBay',   'tier' => 'free'],
                    ['label' => 'Up to 3 products at once',            'tier' => 'free'],
                    ['label' => 'Saved scenarios & history',           'tier' => 'pro'],
                    ['label' => 'Multi-marketplace fee comparison',    'tier' => 'pro'],
                    ['label' => 'Export to Excel / PDF',               'tier' => 'pro'],
                ],
                'status'      => 'coming_soon',
                'sort_order'  => 1,
            ]
        );
    }
}

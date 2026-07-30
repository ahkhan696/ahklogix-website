<?php

namespace App\Filament\Widgets;

use App\Models\CalculatorScenario;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Laravel\Paddle\Subscription;

class SubscriptionStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalCustomers = Customer::count();

        $activeSubscriptions = Subscription::where('billable_type', Customer::class)
            ->where('status', 'active')
            ->count();

        $scenariosSaved = CalculatorScenario::count();

        $calculatorOpens = (int) DB::table('apps')
            ->where('slug', 'pricing-calculator')
            ->value('usage_count');

        $conversionRate = $totalCustomers > 0
            ? round(($activeSubscriptions / $totalCustomers) * 100)
            : 0;

        return [
            Stat::make('Total customers', (string) $totalCustomers)
                ->description("{$activeSubscriptions} active subscriber" . ($activeSubscriptions !== 1 ? 's' : ''))
                ->color($activeSubscriptions > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-users'),

            Stat::make('Active subscriptions', (string) $activeSubscriptions)
                ->description("{$conversionRate}% conversion rate")
                ->color($activeSubscriptions > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-credit-card'),

            Stat::make('Scenarios saved', (string) $scenariosSaved)
                ->description("{$calculatorOpens} calculator opens total")
                ->color('info')
                ->icon('heroicon-o-bookmark'),
        ];
    }
}

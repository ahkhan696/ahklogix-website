<?php

namespace App\Filament\Widgets;

use App\Models\ChatSession;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class ChatStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $today        = now()->utc()->format('Y-m-d');
        $dailyLimit   = (int) config('chat.daily_limit', 200);
        $dailyCount   = (int) Cache::get('chat_daily_' . $today, 0);
        $driverErrors = (int) Cache::get('chat_driver_errors_' . $today, 0);
        $handoffs     = ChatSession::whereDate('created_at', now()->toDateString())
            ->where('handoff_triggered', true)
            ->count();

        $usagePct = $dailyLimit > 0 ? round(($dailyCount / $dailyLimit) * 100) : 0;
        $usageColor = match (true) {
            $usagePct >= 90 => 'danger',
            $usagePct >= 70 => 'warning',
            default         => 'success',
        };

        return [
            Stat::make('Chat requests today', "{$dailyCount} / {$dailyLimit}")
                ->description("{$usagePct}% of daily quota")
                ->color($usageColor)
                ->icon('heroicon-o-chat-bubble-oval-left'),

            Stat::make('Driver errors today', (string) $driverErrors)
                ->description($driverErrors > 0 ? 'Fell back to rule-based' : 'No errors')
                ->color($driverErrors > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-exclamation-triangle'),

            Stat::make('Handoffs today', (string) $handoffs)
                ->description('WhatsApp / booking / contact')
                ->color('info')
                ->icon('heroicon-o-arrow-right-circle'),
        ];
    }
}

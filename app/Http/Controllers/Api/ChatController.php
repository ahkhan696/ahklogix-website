<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ChatDriver;
use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\Setting;
use App\Services\Chat\IntentDetector;
use App\Services\Chat\RuleBasedDriver;
use App\Services\ChatSystemPromptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function stream(
        Request $request,
        ChatDriver $driver,
        ChatSystemPromptService $promptService,
        IntentDetector $intent,
    ) {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        // ── Daily quota ceiling ──────────────────────────────────────────────
        $dailyLimit = config('chat.daily_limit', 200);
        if ($dailyLimit > 0) {
            $dailyKey   = 'chat_daily_' . now()->utc()->format('Y-m-d');
            $dailyCount = Cache::increment($dailyKey);
            if ($dailyCount === 1) {
                // First hit of the day — pin the key so it expires at UTC midnight
                Cache::put($dailyKey, 1, now()->utc()->endOfDay());
            }
            if ($dailyCount > $dailyLimit) {
                return response()->json([
                    'error' => 'Daily chat limit reached. Please contact us directly.',
                ], 429);
            }
        }

        $userMessage = trim($request->input('message'));
        $messages    = [['role' => 'user', 'content' => $userMessage]];
        $system      = $promptService->get();
        $sessionId   = $request->header('X-Chat-Session-Id');
        $ip          = $request->ip();

        // ── Intent detection ─────────────────────────────────────────────────
        $detectedIntent = $intent->detect($userMessage);

        // ── Driver fallback wiring ───────────────────────────────────────────
        $fallback = ($driver instanceof RuleBasedDriver) ? null : new RuleBasedDriver();
        $primary  = $driver->isConfigured() ? $driver : null;

        // Name of whichever driver will actually respond (used for logging)
        $activeDriverName = class_basename($primary ?? $fallback ?? $driver);

        return response()->stream(
            function () use (
                $primary, $fallback, $messages, $system,
                $sessionId, $ip, $detectedIntent, $activeDriverName, $userMessage
            ) {
                while (ob_get_level() > 0) {
                    ob_end_clean();
                }

                $botText       = '';
                $driverUsed    = $activeDriverName;
                $usedFallback  = false;

                // ── Stream from primary driver ───────────────────────────────
                if ($primary !== null) {
                    try {
                        foreach ($primary->stream($messages, $system) as $chunk) {
                            $botText .= $chunk;
                            echo 'data: ' . json_encode(['text' => $chunk]) . "\n\n";
                            flush();
                        }
                    } catch (\Throwable $e) {
                        Log::warning('ChatDriver failed, falling back to RuleBasedDriver', [
                            'driver' => class_basename($primary),
                            'error'  => $e->getMessage(),
                        ]);
                        // Track driver errors for the admin widget
                        Cache::increment('chat_driver_errors_' . now()->utc()->format('Y-m-d'));
                        $usedFallback = true;
                        $driverUsed   = 'RuleBasedDriver';
                        $botText      = '';
                    }
                } else {
                    $usedFallback = true;
                }

                // ── Fallback driver ──────────────────────────────────────────
                if ($usedFallback && $fallback !== null) {
                    try {
                        foreach ($fallback->stream($messages, $system) as $chunk) {
                            $botText .= $chunk;
                            echo 'data: ' . json_encode(['text' => $chunk]) . "\n\n";
                            flush();
                        }
                    } catch (\Throwable) {
                        $errMsg  = 'The assistant is temporarily unavailable. Please try again.';
                        $botText = $errMsg;
                        echo 'data: ' . json_encode(['error' => $errMsg]) . "\n\n";
                        flush();
                    }
                } elseif ($usedFallback && $fallback === null) {
                    $errMsg  = 'The assistant is temporarily unavailable. Please try again.';
                    $botText = $errMsg;
                    echo 'data: ' . json_encode(['error' => $errMsg]) . "\n\n";
                    flush();
                }

                // ── Handoff event ────────────────────────────────────────────
                $handoffTriggered = false;
                if ($detectedIntent !== null) {
                    $whatsapp   = Setting::get('whatsapp_number', '');
                    $bookingUrl = Setting::get('booking_url', '');
                    $handoff    = ['intent' => $detectedIntent];
                    if ($whatsapp) {
                        $handoff['whatsapp_url'] = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp);
                    }
                    if ($bookingUrl) {
                        $handoff['booking_url'] = $bookingUrl;
                    }
                    $handoff['contact_url'] = '/contact';
                    $handoffTriggered       = true;
                    echo 'data: ' . json_encode(['handoff' => $handoff]) . "\n\n";
                    flush();
                }

                echo "data: [DONE]\n\n";
                flush();

                // ── Persist session ──────────────────────────────────────────
                if ($sessionId) {
                    try {
                        $session = ChatSession::firstOrNew(['session_id' => $sessionId]);
                        $msgs    = $session->messages ?? [];
                        $msgs[]  = ['role' => 'user',      'content' => $userMessage];
                        $msgs[]  = ['role' => 'assistant', 'content' => $botText];

                        $session->ip_address        = $ip;
                        $session->driver            = $driverUsed;
                        $session->turns             = (int) collect($msgs)->where('role', 'user')->count();
                        $session->messages          = $msgs;
                        $session->intent_detected   = $detectedIntent;
                        $session->handoff_triggered = $session->handoff_triggered || $handoffTriggered;
                        $session->save();
                    } catch (\Throwable $e) {
                        Log::warning('Failed to persist chat session', ['error' => $e->getMessage()]);
                    }
                }
            },
            200,
            [
                'Content-Type'      => 'text/event-stream',
                'Cache-Control'     => 'no-cache',
                'X-Accel-Buffering' => 'no',
                'Connection'        => 'keep-alive',
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ChatDriver;
use App\Http\Controllers\Controller;
use App\Services\Chat\RuleBasedDriver;
use App\Services\ChatSystemPromptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function stream(Request $request, ChatDriver $driver, ChatSystemPromptService $promptService)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $messages = [['role' => 'user', 'content' => trim($request->input('message'))]];
        $system   = $promptService->get();

        // RuleBasedDriver is always the fallback; skip it if the primary IS already rule-based.
        $fallback = ($driver instanceof RuleBasedDriver) ? null : new RuleBasedDriver();
        $primary  = $driver->isConfigured() ? $driver : null;

        return response()->stream(function () use ($primary, $fallback, $messages, $system) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            if ($primary !== null) {
                try {
                    foreach ($primary->stream($messages, $system) as $chunk) {
                        echo 'data: ' . json_encode(['text' => $chunk]) . "\n\n";
                        flush();
                    }
                    echo "data: [DONE]\n\n";
                    flush();
                    return;
                } catch (\Throwable $e) {
                    Log::warning('ChatDriver failed, falling back to RuleBasedDriver', [
                        'driver' => class_basename($primary),
                        'error'  => $e->getMessage(),
                    ]);
                }
            }

            // Fallback (no primary key, primary error, or primary is RuleBasedDriver itself)
            if ($fallback !== null) {
                try {
                    foreach ($fallback->stream($messages, $system) as $chunk) {
                        echo 'data: ' . json_encode(['text' => $chunk]) . "\n\n";
                        flush();
                    }
                } catch (\Throwable) {
                    echo 'data: ' . json_encode(['error' => 'The assistant is temporarily unavailable. Please try again.']) . "\n\n";
                    flush();
                }
            } else {
                // Primary is RuleBasedDriver and it failed — last resort
                echo 'data: ' . json_encode(['error' => 'The assistant is temporarily unavailable. Please try again.']) . "\n\n";
                flush();
            }

            echo "data: [DONE]\n\n";
            flush();
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ]);
    }
}

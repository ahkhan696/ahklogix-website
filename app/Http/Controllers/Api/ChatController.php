<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ChatDriver;
use App\Http\Controllers\Controller;
use App\Services\ChatSystemPromptService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function stream(Request $request, ChatDriver $driver, ChatSystemPromptService $promptService)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        if (! $driver->isConfigured()) {
            return response()->json([
                'error' => 'The chat assistant is not yet available. Please contact us directly.',
            ], 503);
        }

        $messages = [['role' => 'user', 'content' => trim($request->input('message'))]];
        $system   = $promptService->get();

        return response()->stream(function () use ($driver, $messages, $system) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            try {
                foreach ($driver->stream($messages, $system) as $chunk) {
                    echo 'data: ' . json_encode(['text' => $chunk]) . "\n\n";
                    flush();
                }
            } catch (\Throwable) {
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChatSystemPromptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function stream(Request $request, ChatSystemPromptService $promptService)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $apiKey = config('services.anthropic.key');

        if (blank($apiKey)) {
            return response()->json([
                'error' => 'The chat assistant is not yet available. Please contact us directly.',
            ], 503);
        }

        $message = trim($request->input('message'));
        $system  = $promptService->get();

        try {
            $upstream = Http::withHeaders([
                'x-api-key'         => $apiKey,
                'anthropic-version' => '2023-06-01',
            ])->withOptions(['stream' => true])
              ->post('https://api.anthropic.com/v1/messages', [
                  'model'      => config('services.anthropic.model', 'claude-haiku-4-5-20251001'),
                  'max_tokens' => 1024,
                  'stream'     => true,
                  'system'     => $system,
                  'messages'   => [
                      ['role' => 'user', 'content' => $message],
                  ],
              ]);
        } catch (\Exception) {
            return response()->json([
                'error' => 'The assistant is temporarily unavailable. Please try again.',
            ], 502);
        }

        if (! $upstream->successful()) {
            return response()->json([
                'error' => 'The assistant is temporarily unavailable. Please try again.',
            ], 502);
        }

        return response()->stream(function () use ($upstream) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $body   = $upstream->getBody();
            $buffer = '';

            while (! $body->eof()) {
                $buffer .= $body->read(4096);

                // Process every complete line in the buffer.
                while (($nl = strpos($buffer, "\n")) !== false) {
                    $line   = trim(substr($buffer, 0, $nl));
                    $buffer = substr($buffer, $nl + 1);

                    if (! str_starts_with($line, 'data: ')) {
                        continue;
                    }

                    $event = json_decode(substr($line, 6), true);

                    if (! is_array($event)) {
                        continue;
                    }

                    $type = $event['type'] ?? '';

                    if ($type === 'content_block_delta'
                        && ($event['delta']['type'] ?? '') === 'text_delta'
                        && ($text = $event['delta']['text'] ?? '') !== ''
                    ) {
                        echo 'data: ' . json_encode(['text' => $text]) . "\n\n";
                        flush();
                    } elseif ($type === 'message_stop') {
                        echo "data: [DONE]\n\n";
                        flush();
                        return;
                    }
                }
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

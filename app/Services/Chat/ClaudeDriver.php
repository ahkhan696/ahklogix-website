<?php

namespace App\Services\Chat;

use App\Contracts\ChatDriver;
use Illuminate\Support\Facades\Http;

class ClaudeDriver implements ChatDriver
{
    public function isConfigured(): bool
    {
        return filled(config('services.anthropic.key'));
    }

    public function stream(array $messages, string $system): \Generator
    {
        $upstream = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
        ])->withOptions(['stream' => true])
          ->post('https://api.anthropic.com/v1/messages', [
              'model'      => config('services.anthropic.model', 'claude-haiku-4-5-20251001'),
              'max_tokens' => 1024,
              'stream'     => true,
              'system'     => $system,
              'messages'   => $messages,
          ]);

        if (! $upstream->successful()) {
            throw new \RuntimeException('Anthropic API error: ' . $upstream->status());
        }

        $body   = $upstream->getBody();
        $buffer = '';

        while (! $body->eof()) {
            $buffer .= $body->read(4096);

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
                    yield $text;
                } elseif ($type === 'message_stop') {
                    return;
                }
            }
        }
    }
}

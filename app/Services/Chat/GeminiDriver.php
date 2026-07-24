<?php

namespace App\Services\Chat;

use App\Contracts\ChatDriver;
use Illuminate\Support\Facades\Http;

class GeminiDriver implements ChatDriver
{
    public function isConfigured(): bool
    {
        return filled(config('services.gemini.key'));
    }

    public function stream(array $messages, string $system): \Generator
    {
        $model = config('services.gemini.model', 'gemini-flash-latest');
        $key   = config('services.gemini.key');
        $url   = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:streamGenerateContent?alt=sse&key={$key}";

        $contents = array_map(fn ($m) => [
            'role'  => $m['role'] === 'assistant' ? 'model' : 'user',
            'parts' => [['text' => $m['content']]],
        ], $messages);

        $upstream = Http::withOptions(['stream' => true])
            ->post($url, [
                'system_instruction' => ['parts' => [['text' => $system]]],
                'contents'           => $contents,
                'generationConfig'   => ['maxOutputTokens' => 1024],
            ]);

        if (! $upstream->successful()) {
            throw new \RuntimeException('Gemini API error: ' . $upstream->status());
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

                $text = $event['candidates'][0]['content']['parts'][0]['text'] ?? '';

                if ($text !== '') {
                    yield $text;
                }
            }
        }
    }
}

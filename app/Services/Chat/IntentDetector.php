<?php

namespace App\Services\Chat;

class IntentDetector
{
    private const PATTERNS = [
        'whatsapp' => ['whatsapp', 'whats app', 'wa ', 'chat with', 'message you', 'message us', 'text you', 'speak to', 'talk to', 'talk to someone', 'reach you', 'reach out', 'contact you', 'contact us', 'get in touch', 'human'],
        'booking'  => ['book', 'schedule', 'meeting', 'appointment', 'demo', 'call with', 'consultation', 'availability', 'available', 'calendar', 'set up a call', 'hop on a call'],
        'contact'  => ['email', 'contact form', 'send a message', 'write to', 'form'],
    ];

    public function detect(string $message): ?string
    {
        $lower = strtolower($message);

        foreach (self::PATTERNS as $intent => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($lower, $kw)) {
                    return $intent;
                }
            }
        }

        return null;
    }
}

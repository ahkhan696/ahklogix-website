<?php

namespace App\Services\Chat;

use App\Contracts\ChatDriver;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class RuleBasedDriver implements ChatDriver
{
    public function isConfigured(): bool
    {
        return true;
    }

    public function stream(array $messages, string $system): \Generator
    {
        $message = collect($messages)->last(fn ($m) => $m['role'] === 'user')['content'] ?? '';

        $keywords = $this->keywords($message);

        $faqs     = Cache::remember('rule_driver.faqs', 3600, fn () => Faq::orderBy('order')->get(['question', 'answer']));
        $services = Cache::remember('rule_driver.services', 3600, fn () => Service::orderBy('order')->get(['title', 'short_description']));

        $bestFaq        = null;
        $bestFaqScore   = 0;
        $bestSvc        = null;
        $bestSvcScore   = 0;

        foreach ($faqs as $faq) {
            $score = $this->score($keywords, strtolower($faq->answer), strtolower($faq->question));
            if ($score > $bestFaqScore) {
                $bestFaqScore = $score;
                $bestFaq      = $faq;
            }
        }

        foreach ($services as $svc) {
            $score = $this->score($keywords, strtolower((string) $svc->short_description), strtolower($svc->title));
            if ($score > $bestSvcScore) {
                $bestSvcScore = $score;
                $bestSvc      = $svc;
            }
        }

        $whatsapp = Setting::get('whatsapp_number', config('services.whatsapp_number', ''));
        $ctaLine  = $whatsapp
            ? "Feel free to chat with us on WhatsApp for a faster response: https://wa.me/{$whatsapp}"
            : 'You can also reach us via our contact form: https://ahklogix.com/contact';

        // FAQ beats service when scores are equal (more precise match)
        if ($bestFaqScore > 0 && $bestFaqScore >= $bestSvcScore) {
            $answer = $bestFaq->answer . "\n\n" . $ctaLine;
        } elseif ($bestSvcScore > 0) {
            $desc   = $bestSvc->short_description ? ": {$bestSvc->short_description}" : '.';
            $answer = "We offer **{$bestSvc->title}**{$desc}\n\n" . $ctaLine;
        } else {
            $answer = "I can help with questions about AHKLOGIX's services, products (including POSR), and AI chatbot capabilities. {$ctaLine}";
        }

        foreach ($this->sentences($answer) as $sentence) {
            yield $sentence;
        }
    }

    /** Extract significant keywords from a user message. */
    private function keywords(string $message): array
    {
        static $stop = ['the', 'and', 'for', 'are', 'but', 'not', 'you', 'all', 'can', 'was', 'one', 'our', 'out', 'get', 'has', 'him', 'his', 'how', 'its', 'let', 'may', 'new', 'now', 'old', 'see', 'two', 'way', 'who', 'did', 'use', 'your', 'from', 'they', 'been', 'have', 'that', 'this', 'will', 'with', 'what', 'when', 'about', 'could', 'would', 'there', 'their', 'which', 'them', 'then', 'than', 'some', 'more', 'also', 'into', 'just', 'like', 'make', 'much', 'only', 'over', 'such', 'take', 'well', 'does', 'tell', 'want', 'need'];

        preg_match_all('/[a-z]+/i', strtolower($message), $m);

        return array_unique(
            array_filter($m[0], fn ($w) => strlen($w) > 2 && ! in_array($w, $stop, true))
        );
    }

    /**
     * Score a document: +2 for each keyword found in $title, +1 for each found in $body.
     */
    private function score(array $keywords, string $body, string $title): int
    {
        $score = 0;
        foreach ($keywords as $kw) {
            if (str_contains($title, $kw)) {
                $score += 2;
            } elseif (str_contains($body, $kw)) {
                $score += 1;
            }
        }
        return $score;
    }

    /** Split text into sentence-sized chunks to yield. */
    private function sentences(string $text): array
    {
        $parts = preg_split('/(?<=[.!?])\s+/', trim($text));
        return array_filter((array) $parts, fn ($s) => $s !== '');
    }
}

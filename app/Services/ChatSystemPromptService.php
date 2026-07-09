<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ChatSystemPromptService
{
    public function get(): string
    {
        return Cache::remember('chat.system_prompt', 86400, fn () => $this->build());
    }

    private function build(): string
    {
        $services = Service::orderBy('order')->get(['title', 'short_description']);
        $faqs     = Faq::orderBy('order')->get(['question', 'answer']);

        $whatsapp = Setting::get('whatsapp_number', config('services.whatsapp_number', ''));
        $booking  = Setting::get('booking_url', config('services.booking_url', '#'));

        $lines = [];

        $lines[] = 'You are the AI assistant for AHKLOGIX, a software engineering studio that builds custom web apps, API integrations, automation workflows (Make.com), CRM implementations (Zoho, GoHighLevel), AI chatbots, AI integrations, and mobile apps. The studio also offers digital marketing and SEO services.';
        $lines[] = '';
        $lines[] = 'Answer questions about AHKLOGIX\'s services, products, process, and expertise. Be helpful, professional, and concise.';

        if ($services->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '## OUR SERVICES';
            foreach ($services as $svc) {
                $desc = $svc->short_description ? ": {$svc->short_description}" : '';
                $lines[] = "- {$svc->title}{$desc}";
            }
        }

        if ($faqs->isNotEmpty()) {
            $lines[] = '';
            $lines[] = '## FREQUENTLY ASKED QUESTIONS';
            foreach ($faqs as $faq) {
                $lines[] = "Q: {$faq->question}";
                $lines[] = "A: {$faq->answer}";
                $lines[] = '';
            }
        }

        $lines[] = '';
        $lines[] = '## OUR PRODUCT — POSR';
        $lines[] = 'POSR is a Point of Sale system designed specifically for restaurants. It handles orders, table management, menu configuration, and reporting — built for the pace of a busy restaurant floor.';

        $lines[] = '';
        $lines[] = '## CONTACT & NEXT STEPS';
        if ($whatsapp) {
            $lines[] = "- WhatsApp: {$whatsapp}";
        }
        if ($booking && $booking !== '#') {
            $lines[] = "- Book a call: {$booking}";
        }
        $lines[] = '- Contact form: https://ahklogix.com/contact';

        $lines[] = '';
        $lines[] = '## GUIDELINES';
        $lines[] = '- Only discuss AHKLOGIX\'s services, products, expertise, and relevant software/tech topics.';
        $lines[] = '- For hire, quote, or project inquiries, direct the user to WhatsApp or the booking link.';
        $lines[] = '- Do not invent facts, prices, or timelines not stated above.';
        $lines[] = '- Keep responses concise (2–4 sentences unless detail is genuinely needed).';
        $lines[] = '- Respond in the same language the user writes in.';

        return implode("\n", $lines);
    }
}

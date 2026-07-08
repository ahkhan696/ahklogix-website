<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqsSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            ['question' => 'Where is AHKLOGIX based?',
             'answer'   => '<p>We are based in the UAE and work with clients across the Middle East, UK, Europe, and North America. All projects are managed remotely with clear communication throughout.</p>',
             'category' => 'General', 'order' => 1],

            ['question' => 'What industries do you work with?',
             'answer'   => '<p>We have built solutions for real estate, hospitality, logistics, financial services, healthcare, e-commerce, and professional services. Our technology expertise transfers across industries — the problems change, the engineering principles don\'t.</p>',
             'category' => 'General', 'order' => 2],

            ['question' => 'How do I start a project with AHKLOGIX?',
             'answer'   => '<p>The easiest way is to message us on WhatsApp or fill in the contact form. We\'ll schedule a free discovery call to understand your goals, then send a clear proposal with scope, timeline, and pricing — no vague estimates.</p>',
             'category' => 'General', 'order' => 3],

            // Services
            ['question' => 'Do you only work with Laravel?',
             'answer'   => '<p>Laravel is our primary framework for web applications, but we also work with React Native for mobile, Make.com and Zapier for no-code automation, and integrate with virtually any third-party platform via APIs. We recommend the right tool for each job.</p>',
             'category' => 'Services', 'order' => 1],

            ['question' => 'Can you integrate with our existing tools?',
             'answer'   => '<p>Yes — API integration is one of our core specialties. We work with Zoho, GoHighLevel, Shopify, WooCommerce, QuickBooks, Stripe, Twilio, WhatsApp Business API, and many others. If it has an API, we can connect it.</p>',
             'category' => 'Services', 'order' => 2],

            ['question' => 'Do you offer ongoing support after launch?',
             'answer'   => '<p>Yes. We offer maintenance and support retainers for all custom projects — covering bug fixes, minor enhancements, security updates, and monitoring. Details are discussed per project.</p>',
             'category' => 'Services', 'order' => 3],

            ['question' => 'What is POSR?',
             'answer'   => '<p>POSR is our own product — a Point of Sale system purpose-built for restaurants. It covers table management, order tracking, kitchen display, inventory, and reporting in one place. <a href="/posr">Learn more about POSR.</a></p>',
             'category' => 'Services', 'order' => 4],

            // Process
            ['question' => 'How long does a typical project take?',
             'answer'   => '<p>It depends on scope. A Zoho CRM setup typically takes 2–4 weeks. A custom web application ranges from 4–12 weeks. We always agree on a timeline before work begins and keep you updated throughout.</p>',
             'category' => 'Process', 'order' => 1],

            ['question' => 'What does your development process look like?',
             'answer'   => '<p>We follow four stages: <strong>Discovery</strong> (understand your goals and users), <strong>Planning</strong> (scope, architecture, timeline), <strong>Build & Test</strong> (sprints with regular demos), and <strong>Launch & Support</strong> (deployment, training, handover). No surprises.</p>',
             'category' => 'Process', 'order' => 2],

            ['question' => 'How do you handle communication during a project?',
             'answer'   => '<p>You get a dedicated point of contact, regular progress updates (typically weekly), and access to a shared project tracker. We\'re reachable on WhatsApp and email throughout the engagement.</p>',
             'category' => 'Process', 'order' => 3],
        ];

        foreach ($faqs as $data) {
            Faq::firstOrCreate(
                ['question' => $data['question']],
                $data
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'             => 'Custom Web Applications',
                'icon'              => 'code-bracket',
                'short_description' => 'Bespoke Laravel & full-stack web apps built for your exact workflow — scalable, fast, and maintainable.',
                'body'              => '<p>We design and develop custom web applications from the ground up using Laravel, Livewire, and modern JavaScript. No bloated templates — every line of code is written for your specific business logic.</p><p>Whether you need a client portal, internal tool, SaaS platform, or public-facing product, we architect it to grow with you.</p>',
                'featured'          => true,
                'order'             => 1,
            ],
            [
                'title'             => 'API Integration & Automation',
                'icon'              => 'arrows-right-left',
                'short_description' => 'Connect your tools and automate repetitive workflows so your team focuses on what matters.',
                'body'              => '<p>We integrate third-party APIs — payment gateways, CRMs, ERPs, marketing platforms, and more — into a unified system that works without manual intervention.</p>',
                'featured'          => true,
                'order'             => 2,
            ],
            [
                'title'             => 'Zoho Implementation',
                'icon'              => 'building-office',
                'short_description' => 'Full Zoho CRM, Zoho One, and Zoho Creator setup, customisation, and training for your team.',
                'body'              => '<p>From initial Zoho setup to advanced custom modules, workflows, blueprints, and third-party integrations — we handle the entire implementation so you get a CRM that actually fits your sales process.</p>',
                'featured'          => true,
                'order'             => 3,
            ],
            [
                'title'             => 'GoHighLevel Setup & Automation',
                'icon'              => 'funnel',
                'short_description' => 'End-to-end GoHighLevel builds — funnels, pipelines, workflows, sub-accounts, and white-label setup.',
                'body'              => '<p>We configure GoHighLevel to capture leads, nurture them automatically, and route them through your sales pipeline — so no opportunity slips through the cracks.</p>',
                'featured'          => false,
                'order'             => 4,
            ],
            [
                'title'             => 'Make.com Automation',
                'icon'              => 'bolt',
                'short_description' => 'Multi-step Make.com (Integromat) scenarios that connect your apps and eliminate manual data entry.',
                'body'              => '<p>We design complex Make.com scenarios — from simple two-app syncs to multi-branch logic with error handling — that keep your data flowing reliably across all your platforms.</p>',
                'featured'          => false,
                'order'             => 5,
            ],
            [
                'title'             => 'AI Chatbots & Integration',
                'icon'              => 'cpu-chip',
                'short_description' => 'Custom AI chatbots and LLM integrations that handle support, qualify leads, and automate decisions.',
                'body'              => '<p>We build AI-powered chatbots and integrate large language models into your existing products — customer support bots, lead qualification assistants, document analysis tools, and more.</p>',
                'featured'          => true,
                'order'             => 6,
            ],
            [
                'title'             => 'Mobile App Development',
                'icon'              => 'device-phone-mobile',
                'short_description' => 'Cross-platform iOS & Android apps built with React Native — one codebase, two stores.',
                'body'              => '<p>We develop clean, performant mobile apps using React Native. From MVP to full-featured product, we handle design, development, API integration, and store submission.</p>',
                'featured'          => false,
                'order'             => 7,
            ],
            [
                'title'             => 'Digital Marketing & SEO',
                'icon'              => 'chart-bar',
                'short_description' => 'Data-driven SEO, paid ads, and content strategies that drive qualified traffic and measurable ROI.',
                'body'              => '<p>We combine technical SEO, content marketing, and paid advertising into a cohesive strategy built around your revenue goals — not vanity metrics.</p>',
                'featured'          => false,
                'order'             => 8,
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($data['title'])], $data);
        }
    }
}

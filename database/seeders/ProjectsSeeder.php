<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title'    => 'Restaurant Management SaaS — POSR',
                'client'   => 'Internal Product',
                'category' => 'SaaS / Web App',
                'tags'     => ['Laravel', 'Livewire', 'POS', 'SaaS'],
                'problem'  => 'Restaurant owners were juggling multiple disconnected tools for orders, inventory, staff, and reporting — leading to errors, lost revenue, and wasted time.',
                'solution' => 'Built POSR — a fully integrated Point of Sale system designed specifically for restaurants, covering table management, kitchen display, inventory tracking, and real-time reporting in a single dashboard.',
                'stack'    => ['Laravel 12', 'Livewire', 'Alpine.js', 'MySQL', 'Tailwind CSS'],
                'results'  => '<p>Reduced order processing time by 40%. Now used by 12 restaurant clients across the UAE.</p>',
                'featured' => true,
                'order'    => 1,
            ],
            [
                'title'    => 'Zoho CRM Implementation for Real Estate Agency',
                'client'   => 'Property Hub Dubai',
                'category' => 'CRM / Zoho',
                'tags'     => ['Zoho CRM', 'Zoho Creator', 'Automation'],
                'problem'  => 'The sales team was managing 300+ leads in spreadsheets. Deals were falling through due to no follow-up system and zero pipeline visibility.',
                'solution' => 'Implemented Zoho CRM with custom modules for property listings, a blueprint for the sales process, automated follow-up sequences, and a Zoho Creator app for field agents.',
                'stack'    => ['Zoho CRM', 'Zoho Creator', 'Zoho Flow', 'WhatsApp API'],
                'results'  => '<p>Lead response time dropped from 4 hours to under 15 minutes. Conversion rate improved by 28% in 3 months.</p>',
                'featured' => true,
                'order'    => 2,
            ],
            [
                'title'    => 'GoHighLevel White-Label Agency Build',
                'client'   => 'NexGen Marketing',
                'category' => 'GoHighLevel / Automation',
                'tags'     => ['GoHighLevel', 'Funnels', 'White-label'],
                'problem'  => 'A marketing agency needed a scalable client onboarding system and wanted to white-label their CRM offering without building custom software.',
                'solution' => 'Set up a GoHighLevel white-label instance with automated onboarding funnels, sub-account templating, and a suite of pre-built email/SMS workflows for each client niche.',
                'stack'    => ['GoHighLevel', 'Make.com', 'Zapier', 'Twilio'],
                'results'  => '<p>Agency onboarded 8 new clients in the first month post-launch. Reduced manual onboarding work by 70%.</p>',
                'featured' => true,
                'order'    => 3,
            ],
            [
                'title'    => 'E-commerce Inventory Sync via Make.com',
                'client'   => 'RetailFlow Co.',
                'category' => 'Automation / API',
                'tags'     => ['Make.com', 'Shopify', 'WooCommerce', 'API'],
                'problem'  => 'A multi-channel retailer was manually syncing inventory between Shopify, WooCommerce, and their warehouse system — causing overselling and stock discrepancies.',
                'solution' => 'Built a real-time inventory sync engine in Make.com that propagates stock changes across all three platforms within seconds, with error alerting and rollback logic.',
                'stack'    => ['Make.com', 'Shopify API', 'WooCommerce REST API', 'Google Sheets'],
                'results'  => '<p>Zero overselling incidents since go-live. Saved 20 staff-hours per week in manual reconciliation.</p>',
                'featured' => false,
                'order'    => 4,
            ],
            [
                'title'    => 'AI Lead Qualification Chatbot',
                'client'   => 'FinEdge Advisors',
                'category' => 'AI / Chatbot',
                'tags'     => ['OpenAI', 'Laravel', 'AI Chatbot', 'GoHighLevel'],
                'problem'  => 'A financial advisory firm was spending 2–3 hours per day qualifying inbound leads — most of whom weren\'t a fit.',
                'solution' => 'Built a GPT-4-powered chatbot that asks qualifying questions, scores leads, and pushes qualified contacts directly into GoHighLevel with full conversation context.',
                'stack'    => ['OpenAI GPT-4', 'Laravel', 'GoHighLevel', 'Twilio SMS'],
                'results'  => '<p>Advisor time on unqualified leads dropped by 85%. Booked meetings increased 40% in 60 days.</p>',
                'featured' => true,
                'order'    => 5,
            ],
        ];

        foreach ($projects as $data) {
            Project::firstOrCreate(['slug' => Str::slug($data['title'])], $data);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'        => 'Why GoHighLevel Is the Best CRM for Marketing Agencies in 2025',
                'excerpt'      => 'If you run a marketing agency and you\'re still duct-taping together ActiveCampaign, ClickFunnels, and a spreadsheet — there\'s a better way. Here\'s why GoHighLevel has become the go-to platform for serious agencies.',
                'body'         => '<h2>The Problem with Pieced-Together Stacks</h2><p>Most marketing agencies start with a CRM here, an email tool there, a funnel builder somewhere else. It works — until it doesn\'t. Data gets out of sync, automations break at the seams between platforms, and your team wastes hours on manual tasks that should be automatic.</p><h2>What GoHighLevel Solves</h2><p>GoHighLevel (GHL) consolidates your CRM, email marketing, SMS, pipeline management, landing pages, funnels, appointment booking, and reporting into a single platform. More importantly, it lets you white-label the whole thing and resell it to your clients — creating a recurring revenue stream.</p><h2>Key Features Worth Knowing</h2><ul><li><strong>Sub-accounts:</strong> Each client gets their own isolated GHL account, managed from your master agency account.</li><li><strong>Workflows:</strong> Visual automation builder with conditions, branches, and wait steps.</li><li><strong>Pipeline view:</strong> Kanban-style deal management with automated stage actions.</li><li><strong>Reputation management:</strong> Automated review request sequences via SMS and email.</li></ul><h2>When GoHighLevel Makes Sense</h2><p>GHL is ideal if you manage campaigns for multiple clients and want to consolidate tools. It\'s less ideal if you need deep e-commerce functionality or very complex CRM customisation (for that, Zoho or Salesforce is the better call).</p>',
                'author'       => 'AHKLOGIX Team',
                'tags'         => ['GoHighLevel', 'CRM', 'Marketing Agencies', 'Automation'],
                'published_at' => now()->subDays(14),
                'status'       => 'published',
            ],
            [
                'title'        => 'Make.com vs Zapier: Which Automation Platform Should You Use?',
                'excerpt'      => 'Both Make.com and Zapier connect your apps and automate workflows. But they\'re built for different use cases. Here\'s a straight comparison to help you choose the right one.',
                'body'         => '<h2>The Short Answer</h2><p>Use <strong>Zapier</strong> if you need simple, fast automations and your team isn\'t technical. Use <strong>Make.com</strong> if you need complex multi-step logic, data transformation, or you\'re watching your costs on high-volume workflows.</p><h2>Pricing</h2><p>Zapier charges per task — costs can escalate quickly at scale. Make.com charges per operation but is generally 5–10x cheaper for equivalent workflows.</p><h2>Complexity</h2><p>Zapier is linear: trigger → action → action. Make.com is visual and supports branches, iterators, aggregators, and error handling. For anything beyond three steps, Make.com\'s visual editor is far easier to reason about.</p><h2>Our Recommendation</h2><p>For new projects at AHKLOGIX, we default to Make.com. The visual builder, cheaper pricing at scale, and native support for complex data transformations make it the stronger choice for serious automation work.</p>',
                'author'       => 'AHKLOGIX Team',
                'tags'         => ['Make.com', 'Zapier', 'Automation', 'No-code'],
                'published_at' => now()->subDays(7),
                'status'       => 'published',
            ],
            [
                'title'        => 'How We Built an AI Lead Qualification Bot That Books Meetings on Autopilot',
                'excerpt'      => 'A deep dive into the architecture behind the AI chatbot we built for a financial advisory firm — and the numbers it produced.',
                'body'         => '<h2>The Brief</h2><p>A financial advisory firm was spending 2–3 hours per day on discovery calls with leads who weren\'t a fit. They needed a way to qualify inbound leads before an advisor ever picked up the phone.</p><h2>The Architecture</h2><p>We built a GPT-4-powered chatbot embedded on their website. When a visitor starts a chat, the bot:</p><ol><li>Asks qualifying questions based on the firm\'s criteria (investment amount, timeline, goals)</li><li>Scores the lead against predefined rules</li><li>If qualified: pushes the lead into GoHighLevel with full conversation context and triggers a booking SMS</li><li>If not qualified: thanks them and offers a relevant guide</li></ol><h2>The Results</h2><p>Within 60 days: 85% reduction in advisor time on unqualified leads, 40% increase in booked meetings, and the advisor team reported dramatically better call quality because prospects already felt understood before the call began.</p>',
                'author'       => 'AHKLOGIX Team',
                'tags'         => ['AI', 'Chatbot', 'GPT-4', 'Lead Generation', 'GoHighLevel'],
                'published_at' => null,
                'status'       => 'draft',
            ],
        ];

        foreach ($posts as $data) {
            Post::firstOrCreate(['slug' => Str::slug($data['title'])], $data);
        }
    }
}

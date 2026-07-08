<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name'     => 'Sarah Al-Mansouri',
                'company'  => 'Property Hub Dubai',
                'rating'   => 5,
                'quote'    => 'The Zoho CRM implementation transformed our sales process. AHKLOGIX didn\'t just set up software — they understood our business first. Lead response time is now under 15 minutes and our pipeline has never been clearer.',
                'featured' => true,
                'order'    => 1,
            ],
            [
                'name'     => 'James Okonkwo',
                'company'  => 'NexGen Marketing',
                'rating'   => 5,
                'quote'    => 'We\'ve worked with three other development agencies before AHKLOGIX. The difference is night and day — these guys actually deliver what they promise, on time, and explain every decision. Our GoHighLevel setup is exactly what we envisioned.',
                'featured' => true,
                'order'    => 2,
            ],
            [
                'name'     => 'Priya Nair',
                'company'  => 'RetailFlow Co.',
                'rating'   => 5,
                'quote'    => 'The inventory automation they built in Make.com saved us 20 hours a week immediately. More importantly, our overselling problem — which was costing us customer relationships — is completely gone.',
                'featured' => true,
                'order'    => 3,
            ],
            [
                'name'     => 'David Chen',
                'company'  => 'FinEdge Advisors',
                'rating'   => 5,
                'quote'    => 'The AI chatbot they built for us is one of the best business decisions we\'ve made. It qualifies leads, asks the right questions, and by the time I get on a call, the prospect already feels like we know them. Booked meetings are up 40%.',
                'featured' => true,
                'order'    => 4,
            ],
            [
                'name'     => 'Mohammed Al-Rashid',
                'company'  => 'Horizon Logistics',
                'rating'   => 5,
                'quote'    => 'We needed a custom web portal built fast without sacrificing quality. AHKLOGIX delivered a clean, performant Laravel application in three weeks. The code is well-documented and my in-house team can maintain it easily.',
                'featured' => false,
                'order'    => 5,
            ],
            [
                'name'     => 'Emma Thompson',
                'company'  => 'Bloom Wellness UAE',
                'rating'   => 4,
                'quote'    => 'Really impressed with how they handled our GoHighLevel funnel setup. They took the time to understand our customer journey before building anything. Results speak for themselves — cost per lead dropped significantly.',
                'featured' => false,
                'order'    => 6,
            ],
        ];

        foreach ($reviews as $data) {
            Review::firstOrCreate(
                ['name' => $data['name'], 'company' => $data['company']],
                $data
            );
        }
    }
}

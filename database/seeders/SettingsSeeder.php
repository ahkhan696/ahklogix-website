<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'whatsapp_number' => '',        // e.g. 971501234567
            'booking_url'     => '',        // Cal.com or GHL booking link
            'contact_email'   => 'hello@ahklogix.com',
            'chatbot_embed'   => '',        // paste embed script here
            'linkedin_url'    => '',
            'twitter_url'     => '',
            'github_url'      => '',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\NewContactSubmission;
use App\Models\ContactSubmission;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $services     = Service::orderBy('order')->pluck('title');
        $whatsapp     = Setting::get('whatsapp_number');
        $bookingUrl   = Setting::get('booking_url');
        $contactEmail = Setting::get('contact_email');

        return view('pages.contact', compact('services', 'whatsapp', 'bookingUrl', 'contactEmail'));
    }

    public function submit(Request $request)
    {
        // Honeypot — bots fill the hidden field; humans never see it
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('success', true);
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ]);

        $submission = ContactSubmission::create($data);

        // Email notification (log driver in dev; swap MAIL_MAILER in production)
        $to = Setting::get('contact_email', config('mail.from.address'));
        if ($to) {
            Mail::to($to)->send(new NewContactSubmission($submission));
        }

        // TODO: GoHighLevel webhook — enter the URL in Admin → Settings → Integrations
        // $ghlUrl = Setting::get('ghl_webhook_url');
        // if ($ghlUrl) {
        //     Http::timeout(5)->post($ghlUrl, [
        //         'name'    => $submission->name,
        //         'email'   => $submission->email,
        //         'phone'   => '',
        //         'company' => $submission->company,
        //         'source'  => 'AHKLOGIX website',
        //         'message' => $submission->message,
        //         'tags'    => 'website-lead,' . ($submission->service ?: 'general'),
        //     ]);
        // }

        return redirect()->route('contact')->with('success', true);
    }
}

@php
$_contactPoint = [
    '@type'       => 'ContactPoint',
    'contactType' => 'customer support',
    'url'         => route('contact'),
];
if ($email = \App\Models\Setting::get('contact_email')) {
    $_contactPoint['email'] = $email;
}
$_org = [
    '@context'     => 'https://schema.org',
    '@type'        => 'Organization',
    'name'         => 'AHKLOGIX',
    'url'          => url('/'),
    'logo'         => url('images/ahklogix-logo-color.png'),
    'description'  => 'Custom web apps, API integration & automation, Zoho, GoHighLevel, Make.com, AI chatbots, mobile, digital marketing, SEO — and POSR, a Point of Sale for Restaurants.',
    'contactPoint' => $_contactPoint,
    'sameAs'       => array_values(array_filter([
        \App\Models\Setting::get('linkedin_url'),
        \App\Models\Setting::get('twitter_url'),
        \App\Models\Setting::get('github_url'),
    ])),
];
@endphp
<script type="application/ld+json">{!! json_encode($_org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

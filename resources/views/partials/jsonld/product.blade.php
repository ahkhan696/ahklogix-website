@php
$_product = [
    '@context'            => 'https://schema.org',
    '@type'               => 'SoftwareApplication',
    'name'                => 'POSR — Point of Sale for Restaurants',
    'description'         => 'A purpose-built Point of Sale system for restaurants — table management, order tracking, kitchen display, and real-time analytics.',
    'url'                 => route('posr'),
    'applicationCategory' => 'BusinessApplication',
    'operatingSystem'     => 'Web',
    'offers'              => [
        '@type'          => 'Offer',
        'priceCurrency'  => 'USD',
        'price'          => '0',
        'description'    => 'Contact for pricing and demo',
    ],
    'author' => [
        '@type' => 'Organization',
        'name'  => 'AHKLOGIX',
        'url'   => url('/'),
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($_product, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

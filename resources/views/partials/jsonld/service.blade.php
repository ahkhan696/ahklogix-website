@php
$_svc = [
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $service->title,
    'description' => $service->seo_description ?: $service->short_description,
    'url'         => route('services.show', $service->slug),
    'provider'    => [
        '@type' => 'Organization',
        'name'  => 'AHKLOGIX',
        'url'   => url('/'),
    ],
    'areaServed'  => 'Worldwide',
    'serviceType' => $service->title,
];
@endphp
<script type="application/ld+json">{!! json_encode($_svc, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

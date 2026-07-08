@props([
    'title'       => null,
    'description' => 'AHKLOGIX — Custom web apps, API integration & automation, Zoho, GoHighLevel, Make.com, and AI chatbots.',
    'ogImage'     => null,
    'canonical'   => null,
])

@php
    $pageTitle = $title ? $title . ' | ' . config('app.name') : config('app.name') . ' — Software Engineering Studio';
    $canonicalUrl = $canonical ?? url()->current();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Font preconnect (Bunny Fonts CDN) --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="{{ config('app.name') }}">
    <meta property="og:title"       content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url"         content="{{ $canonicalUrl }}">
    @if($ogImage)
    <meta property="og:image"       content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title"       content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $description }}">
    @if($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    {{-- Head extras slot (JSON-LD, page-specific styles, etc.) --}}
    {{ $head ?? '' }}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg text-text-body antialiased">

    <x-header />

    <main id="main-content">
        {{ $slot }}
    </main>

    <x-footer />

    {{-- Floating widgets — rendered on every page --}}
    <x-whatsapp-button />
    <x-chatbot-bubble />

</body>
</html>

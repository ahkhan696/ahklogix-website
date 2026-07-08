@php
$_allFaqs = $grouped->flatten();
$_faqPage = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $_allFaqs->map(fn ($faq) => [
        '@type' => 'Question',
        'name'  => $faq->question,
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => strip_tags($faq->answer),
        ],
    ])->values()->all(),
];
@endphp
<script type="application/ld+json">{!! json_encode($_faqPage, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

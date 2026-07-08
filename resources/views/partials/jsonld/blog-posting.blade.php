@php
$_bp = [
    '@context'      => 'https://schema.org',
    '@type'         => 'BlogPosting',
    'headline'      => $post->title,
    'description'   => $post->seo_description ?: $post->excerpt,
    'url'           => route('blog.show', $post->slug),
    'datePublished' => $post->published_at->toIso8601String(),
    'dateModified'  => $post->updated_at->toIso8601String(),
    'author'        => [
        '@type' => 'Person',
        'name'  => $post->author ?: 'AHKLOGIX',
    ],
    'publisher'     => [
        '@type' => 'Organization',
        'name'  => 'AHKLOGIX',
        'url'   => url('/'),
    ],
];
$_bpImg = $post->getFirstMediaUrl('cover', 'blog-hero') ?: $post->getFirstMediaUrl('cover');
if ($_bpImg) {
    $_bp['image'] = ['@type' => 'ImageObject', 'url' => $_bpImg, 'width' => 1200, 'height' => 630];
}
@endphp
<script type="application/ld+json">{!! json_encode($_bp, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

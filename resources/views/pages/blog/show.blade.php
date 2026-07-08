@php
    $postOgImage = $post->getFirstMediaUrl('cover', 'blog-hero') ?: $post->getFirstMediaUrl('cover') ?: null;
@endphp
<x-layouts.app
    :title="$post->seo_title ?: $post->title . ' — AHKLOGIX Blog'"
    :description="$post->seo_description ?: $post->excerpt"
    :ogImage="$postOgImage">
<x-slot:head>
@include('partials.jsonld.blog-posting')
</x-slot:head>

{{-- ── Breadcrumb + post header ────────────────────────────────────────────── --}}
<section class="pt-16 pb-12 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <a href="{{ route('blog.index') }}" class="hover:text-violet transition-colors duration-200">Blog</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium line-clamp-1">{{ $post->title }}</span>
            </nav>

            {{-- Tags --}}
            @if(!empty($post->tags))
            <div class="flex flex-wrap gap-2 mb-5">
                @foreach($post->tags as $tag)
                <a
                    href="{{ route('blog.index', ['tag' => $tag]) }}"
                    class="inline-block rounded-full px-3 py-1 text-xs font-semibold bg-violet/8 text-violet hover:bg-violet/15 transition-colors duration-200"
                >{{ $tag }}</a>
                @endforeach
            </div>
            @endif

            <h1 class="font-heading font-bold text-3xl lg:text-5xl text-indigo-ink leading-tight max-w-3xl">
                {{ $post->title }}
            </h1>

            {{-- Meta row --}}
            <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-text-muted">
                @if($post->author)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                    </svg>
                    {{ $post->author }}
                </span>
                @endif
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                    {{ $post->published_at->format('F j, Y') }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    {{ $post->reading_time }} min read
                </span>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Cover image ──────────────────────────────────────────────────────────── --}}
@php
    $coverUrl  = $post->getFirstMediaUrl('cover', 'blog-hero');
    $originUrl = $post->getFirstMediaUrl('cover');
    $imgSrc    = $coverUrl ?: $originUrl;
@endphp
@if($imgSrc)
<section class="bg-bg pb-4">
    <x-container>
        <x-reveal>
            <div class="rounded-2xl overflow-hidden border border-border shadow-xl">
                <img
                    src="{{ $imgSrc }}"
                    alt="{{ $post->title }}"
                    class="w-full h-auto max-h-[500px] object-cover"
                    width="1200"
                    height="630"
                    loading="lazy"
                >
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Body (rich text) ─────────────────────────────────────────────────────── --}}
@if($post->body)
<section class="py-16 bg-bg">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto prose prose-lg
                prose-a:text-violet prose-a:no-underline hover:prose-a:underline
                prose-headings:font-heading prose-headings:text-indigo-ink prose-headings:font-semibold
                prose-strong:text-indigo-ink
                prose-code:text-violet prose-code:bg-surface prose-code:rounded prose-code:px-1 prose-code:py-0.5 prose-code:text-sm prose-code:before:content-[''] prose-code:after:content-['']
                prose-pre:bg-indigo-ink prose-pre:text-white/90 prose-pre:rounded-xl
                prose-blockquote:border-violet prose-blockquote:text-text-muted
                prose-img:rounded-xl prose-img:shadow-lg prose-img:border prose-img:border-border">
                {!! $post->body !!}
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Tag footer --}}
@if(!empty($post->tags))
<section class="pb-12 bg-bg">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto border-t border-border pt-8">
                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide mb-3">Filed under</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                    <a
                        href="{{ route('blog.index', ['tag' => $tag]) }}"
                        class="inline-block rounded-full px-3.5 py-1.5 text-xs font-semibold border border-border text-text-muted hover:border-violet hover:text-violet transition-colors duration-200"
                    >{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Related posts ────────────────────────────────────────────────────────── --}}
@if($related->isNotEmpty())
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="mb-10">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Keep reading</p>
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Related posts</h2>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $related_post)
            <x-reveal :delay="$loop->index * 80">
                <a
                    href="{{ route('blog.show', $related_post->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-white overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    <div class="relative h-40 overflow-hidden flex-shrink-0">
                        @php
                            $relCover = $related_post->getFirstMediaUrl('cover', 'blog-hero') ?: $related_post->getFirstMediaUrl('cover');
                        @endphp
                        @if($relCover)
                            <img src="{{ $relCover }}" alt="{{ $related_post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" width="600" height="315">
                        @else
                            <div class="w-full h-full flex items-end p-4" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                                <span class="font-heading font-bold text-sm text-white/80 leading-tight line-clamp-2">{{ $related_post->title }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        @if(!empty($related_post->tags))
                        <div class="flex flex-wrap gap-1.5 mb-2">
                            @foreach(array_slice($related_post->tags, 0, 2) as $tag)
                            <span class="inline-block rounded-full px-2 py-0.5 text-[10px] font-semibold bg-violet/8 text-violet">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                        <h3 class="font-heading font-semibold text-sm text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug line-clamp-2 flex-1">
                            {{ $related_post->title }}
                        </h3>
                        <div class="mt-3 pt-3 border-t border-border flex items-center justify-between text-xs text-text-muted">
                            <span>{{ $related_post->published_at?->format('M j, Y') }}</span>
                            <span>{{ $related_post->reading_time }} min read</span>
                        </div>
                    </div>
                </a>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>
@endif

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-bg relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">
                    Ready to build something <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">like this?</span>
                </h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    We build the things we write about. Send us a message and let's scope out your project.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('blog.index') }}">Back to blog</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

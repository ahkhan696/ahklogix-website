<x-layouts.app
    title="Blog — AHKLOGIX"
    description="Insights, tutorials, and updates from the AHKLOGIX engineering team — web apps, automation, AI, CRM, and more.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-14 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <div class="max-w-2xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">The AHKLOGIX Blog</p>
                <h1 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink leading-tight">
                    Insights from the<br>
                    <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">engineering floor</span>
                </h1>
                <p class="mt-5 text-lg text-text-muted leading-relaxed">
                    Tutorials, deep dives, and real-world lessons on web apps, automation, AI, and CRM systems — from the team that builds them.
                </p>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Tag filter bar ──────────────────────────────────────────────────────── --}}
@if($allTags->isNotEmpty())
<section class="py-5 bg-surface border-b border-border sticky top-14 z-20 backdrop-blur-sm">
    <x-container>
        <div class="flex items-center gap-2 flex-wrap">
            <a
                href="{{ route('blog.index') }}"
                class="inline-flex items-center rounded-full px-3.5 py-1.5 text-xs font-semibold border transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-1
                    {{ !$activeTag ? 'border-violet text-violet bg-violet/5' : 'border-border text-text-muted hover:border-violet hover:text-violet' }}"
            >
                All
            </a>
            @foreach($allTags as $tag)
            <a
                href="{{ route('blog.index', ['tag' => $tag]) }}"
                class="inline-flex items-center rounded-full px-3.5 py-1.5 text-xs font-semibold border transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-1
                    {{ $activeTag === $tag ? 'border-violet text-violet bg-violet/5' : 'border-border text-text-muted hover:border-violet hover:text-violet' }}"
            >
                {{ $tag }}
            </a>
            @endforeach
        </div>
    </x-container>
</section>
@endif

{{-- ── Post grid ────────────────────────────────────────────────────────────── --}}
<section class="py-16 bg-bg">
    <x-container>

        @if($posts->isEmpty())
        <x-reveal>
            <div class="text-center py-20">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5" style="background: var(--gradient-brand)">
                    <x-svg-icon name="pencil-square" class="w-8 h-8 text-white" />
                </div>
                <h2 class="font-heading font-semibold text-xl text-indigo-ink mb-2">No posts yet</h2>
                <p class="text-text-muted">
                    @if($activeTag)
                        No posts tagged "<strong>{{ $activeTag }}</strong>". <a href="{{ route('blog.index') }}" class="text-violet hover:underline">See all posts</a>.
                    @else
                        Check back soon — great content is on the way.
                    @endif
                </p>
            </div>
        </x-reveal>
        @else

        @if($activeTag)
        <x-reveal>
            <p class="text-sm text-text-muted mb-8">
                Showing posts tagged
                <span class="font-semibold text-indigo-ink">"{{ $activeTag }}"</span>
                — <a href="{{ route('blog.index') }}" class="text-violet hover:underline">clear filter</a>
            </p>
        </x-reveal>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <x-reveal :delay="$loop->index * 60">
                <a
                    href="{{ route('blog.show', $post->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-white overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    {{-- Cover --}}
                    <div class="relative h-48 overflow-hidden flex-shrink-0">
                        @php
                            $coverUrl = $post->getFirstMediaUrl('cover', 'blog-hero') ?: $post->getFirstMediaUrl('cover');
                        @endphp
                        @if($coverUrl)
                            <img
                                src="{{ $coverUrl }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                                width="600"
                                height="315"
                            >
                        @else
                            <div class="w-full h-full flex items-end p-5" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                                <span class="font-heading font-bold text-base text-white/80 leading-tight line-clamp-2">{{ $post->title }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Tags --}}
                        @if(!empty($post->tags))
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                            <span class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-semibold bg-violet/8 text-violet">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif

                        <h2 class="font-heading font-semibold text-base text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug line-clamp-2">
                            {{ $post->title }}
                        </h2>

                        @if($post->excerpt)
                        <p class="mt-2 text-sm text-text-muted leading-relaxed line-clamp-3 flex-1">
                            {{ $post->excerpt }}
                        </p>
                        @endif

                        {{-- Meta --}}
                        <div class="mt-4 pt-4 border-t border-border flex items-center justify-between text-xs text-text-muted">
                            <span>{{ $post->published_at->format('M j, Y') }}</span>
                            <span>{{ $post->reading_time }} min read</span>
                        </div>
                    </div>
                </a>
            </x-reveal>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
        <x-reveal>
            <div class="mt-12 flex justify-center">
                {{ $posts->appends(request()->query())->links('vendor.pagination.simple-tailwind') }}
            </div>
        </x-reveal>
        @endif

        @endif
    </x-container>
</section>

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Want to work with us?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    We build the things we write about. Send us a message and let's scope out your project.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our portfolio</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

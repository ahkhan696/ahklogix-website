@php
    $serviceOgImage = $service->getFirstMediaUrl('icon_image', 'hero') ?: $service->getFirstMediaUrl('icon_image') ?: null;
@endphp
<x-layouts.app
    :title="$service->seo_title ?: $service->title . ' — AHKLOGIX'"
    :description="$service->seo_description ?: $service->short_description"
    :ogImage="$serviceOgImage">
<x-slot:head>
@include('partials.jsonld.service')
</x-slot:head>

{{-- ── Breadcrumb + hero ───────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <a href="{{ route('services.index') }}" class="hover:text-violet transition-colors duration-200">Services</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">{{ $service->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    {{-- Icon --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$service->icon ?? 'code-bracket'" class="w-7 h-7 text-white" />
                    </div>

                    <h1 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink leading-tight">
                        {{ $service->title }}
                    </h1>
                    <p class="mt-5 text-lg text-text-muted leading-relaxed">
                        {{ $service->short_description }}
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <x-button-primary href="{{ route('contact') }}">Start with this service</x-button-primary>
                        <x-button-secondary href="{{ route('services.index') }}">All services</x-button-secondary>
                    </div>
                </div>

                {{-- Right: stat card --}}
                <div class="hidden lg:flex justify-end">
                    <div class="rounded-2xl border border-border bg-surface p-8 w-full max-w-xs">
                        <p class="text-xs font-semibold uppercase tracking-widest text-text-muted mb-6">Why clients choose this</p>
                        <div class="space-y-4">
                            @foreach([
                                ['Scoped before we build', 'No guesswork — we agree on deliverables in writing.'],
                                ['Engineers on the call', 'You talk to the person doing the work, not a PM relay.'],
                                ['Delivered, not handed off', 'We stay until it works the way you expected.'],
                            ] as [$title, $desc])
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-violet flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-semibold text-indigo-ink">{{ $title }}</div>
                                    <div class="text-xs text-text-muted mt-0.5 leading-relaxed">{{ $desc }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Cover image ───────────────────────────────────────────────────────────── --}}
@php
    $coverUrl  = $service->getFirstMediaUrl('icon_image', 'hero');
    $originUrl = $service->getFirstMediaUrl('icon_image');
    $imgSrc    = $coverUrl ?: $originUrl;
@endphp
@if($imgSrc)
<section class="bg-bg pb-4">
    <x-container>
        <x-reveal>
            <div class="rounded-2xl overflow-hidden border border-border shadow-xl">
                <img
                    src="{{ $imgSrc }}"
                    alt="{{ $service->title }}"
                    class="w-full h-auto max-h-[480px] object-cover"
                    width="1200"
                    height="630"
                    loading="lazy"
                >
            </div>
        </x-reveal>
    </x-container>
</section>
@else
<section class="bg-bg pb-4">
    <x-container>
        <x-reveal>
            <div class="rounded-2xl overflow-hidden border border-border h-56 flex items-center justify-center"
                 style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.12)">
                    <x-svg-icon :name="$service->icon ?? 'code-bracket'" class="w-8 h-8 text-white" />
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Body (rich text) ─────────────────────────────────────────────────────── --}}
@if($service->body)
<section class="py-20 bg-bg">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto prose prose-lg prose-a:text-violet prose-headings:font-heading prose-headings:text-indigo-ink prose-headings:font-semibold">
                {!! $service->body !!}
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Related work ─────────────────────────────────────────────────────────── --}}
@if($related->isNotEmpty())
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="mb-10">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Related work</p>
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">See how we've done it</h2>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($related as $project)
            <x-reveal :delay="$loop->index * 80">
                <a
                    href="{{ route('portfolio.show', $project->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-white overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    <div class="relative h-40 overflow-hidden">
                        @if($project->getFirstMediaUrl('cover'))
                            <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" width="600" height="320">
                        @else
                            <div class="w-full h-full flex items-end p-5" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 60%, #7C3AED 100%)">
                                <span class="font-heading font-bold text-lg text-white/80 leading-tight">{{ $project->title }}</span>
                            </div>
                        @endif
                        @if($project->category)
                        <div class="absolute top-3 left-3">
                            <span class="inline-block rounded-full px-2.5 py-1 text-[11px] font-semibold bg-white/90 text-indigo-ink backdrop-blur-sm">{{ $project->category }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-heading font-semibold text-base text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug">{{ $project->title }}</h3>
                        @if($project->client)
                        <p class="mt-1 text-xs text-text-muted">{{ $project->client }}</p>
                        @endif
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
                    Ready to start with <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $service->title }}</span>?
                </h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Send us a message and we'll get back to you with a clear scope and honest timeline.
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

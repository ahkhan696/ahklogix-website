@php
    $projectOgImage = $project->getFirstMediaUrl('cover', 'full') ?: $project->getFirstMediaUrl('cover') ?: null;
@endphp
<x-layouts.app
    :title="($project->seo_title ?: $project->title) . ' — Case Study'"
    :description="$project->seo_description ?: $project->problem"
    :ogImage="$projectOgImage">

{{-- ── Hero / header ───────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-0 bg-bg">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <a href="{{ route('portfolio.index') }}" class="hover:text-violet transition-colors duration-200">Portfolio</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">{{ $project->title }}</span>
            </nav>

            {{-- Category + client --}}
            <div class="flex flex-wrap items-center gap-3 mb-5">
                @if($project->category)
                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold border border-violet/30 text-violet">
                    {{ $project->category }}
                </span>
                @endif
                @if($project->client)
                <span class="text-sm text-text-muted">{{ $project->client }}</span>
                @endif
            </div>

            <h1 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink leading-tight max-w-4xl">
                {{ $project->title }}
            </h1>

            {{-- Stack tags --}}
            @if($project->stack)
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach((array)$project->stack as $tech)
                <span class="rounded-lg border border-border bg-surface px-3 py-1 text-xs font-medium text-text-body">{{ $tech }}</span>
                @endforeach
            </div>
            @endif
        </x-reveal>

        {{-- Cover image --}}
        @if($project->getFirstMediaUrl('cover'))
        <x-reveal>
            <div class="mt-10 rounded-2xl overflow-hidden border border-border shadow-xl">
                <img
                    src="{{ $project->getFirstMediaUrl('cover') }}"
                    alt="{{ $project->title }}"
                    class="w-full h-auto max-h-[480px] object-cover"
                    width="1200" height="630"
                >
            </div>
        </x-reveal>
        @else
        <x-reveal>
            <div class="mt-10 rounded-2xl overflow-hidden border border-border h-64 flex items-center justify-center" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                <p class="font-heading font-bold text-3xl text-white/80">{{ $project->title }}</p>
            </div>
        </x-reveal>
        @endif
    </x-container>
</section>

{{-- ── Problem / Solution / Results ───────────────────────────────────────── --}}
<section class="py-20 bg-bg">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Problem --}}
            @if($project->problem)
            <x-reveal>
                <div class="rounded-2xl border border-border bg-surface p-7 h-full">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background: rgba(124,58,237,0.1)">
                        <svg class="w-5 h-5 text-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <h2 class="font-heading font-semibold text-lg text-indigo-ink mb-3">The problem</h2>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $project->problem }}</p>
                </div>
            </x-reveal>
            @endif

            {{-- Solution --}}
            @if($project->solution)
            <x-reveal :delay="80">
                <div class="rounded-2xl border border-border bg-surface p-7 h-full">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background: rgba(124,58,237,0.1)">
                        <svg class="w-5 h-5 text-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z"/>
                        </svg>
                    </div>
                    <h2 class="font-heading font-semibold text-lg text-indigo-ink mb-3">Our solution</h2>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $project->solution }}</p>
                </div>
            </x-reveal>
            @endif

            {{-- Results --}}
            @if($project->results)
            <x-reveal :delay="160">
                <div class="rounded-2xl border-2 p-7 h-full" style="border-color: rgba(124,58,237,0.25); background: rgba(124,58,237,0.03)">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5" style="background: var(--gradient-brand)">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>
                        </svg>
                    </div>
                    <h2 class="font-heading font-semibold text-lg text-indigo-ink mb-3">The results</h2>
                    <div class="text-sm text-text-muted leading-relaxed prose prose-sm prose-a:text-violet max-w-none">
                        {!! $project->results !!}
                    </div>
                </div>
            </x-reveal>
            @endif
        </div>
    </x-container>
</section>

{{-- ── Gallery ──────────────────────────────────────────────────────────────── --}}
@php $gallery = $project->getMedia('gallery'); @endphp
@if($gallery->isNotEmpty())
<section class="py-10 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <h2 class="font-heading font-semibold text-xl text-indigo-ink mb-8">Project gallery</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($gallery as $img)
                <div class="rounded-xl overflow-hidden border border-border">
                    <img
                        src="{{ $img->getUrl() }}"
                        alt="{{ $project->title }} — screenshot"
                        class="w-full h-48 object-cover"
                        loading="lazy"
                    >
                </div>
                @endforeach
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-bg relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Want results like this?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Tell us what you're trying to solve and we'll propose the right approach.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">View all work</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

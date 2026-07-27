@php
    $isLive      = $app->status === 'live';
    $tileImg     = $app->getFirstMediaUrl('tile_image', 'card') ?: $app->getFirstMediaUrl('tile_image');
    $freeFeats   = collect($app->feature_list ?? [])->where('tier', 'free');
    $proFeats    = collect($app->feature_list ?? [])->where('tier', 'pro');
    $hasFeatures = $freeFeats->isNotEmpty() || $proFeats->isNotEmpty();
@endphp
<x-layouts.app
    :title="$app->title . ' — AHKLOGIX Apps'"
    :description="$app->tagline ?: 'A mini-app built by AHKLOGIX.'">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <a href="{{ route('apps.index') }}" class="hover:text-violet transition-colors duration-200">Apps</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">{{ $app->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    {{-- Icon --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$app->icon ?? 'squares-2x2'" class="w-7 h-7 text-white" />
                    </div>

                    {{-- Status badge --}}
                    @if(!$isLive)
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-border bg-surface px-3 py-1 text-xs font-semibold text-text-muted">
                            <span class="w-1.5 h-1.5 rounded-full bg-text-muted inline-block"></span>
                            Coming soon
                        </span>
                    </div>
                    @else
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            Live
                        </span>
                    </div>
                    @endif

                    <h1 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink leading-tight">
                        {{ $app->title }}
                    </h1>

                    @if($app->tagline)
                    <p class="mt-5 text-lg text-text-muted leading-relaxed">
                        {{ $app->tagline }}
                    </p>
                    @endif

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        @if($isLive)
                            <x-button-primary href="{{ route('apps.show', $app) }}/use">
                                Try it free
                            </x-button-primary>
                        @else
                            <button
                                disabled
                                class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white opacity-40 cursor-not-allowed"
                                style="background: var(--gradient-brand)"
                                title="Coming soon"
                            >
                                Try it free — coming soon
                            </button>
                        @endif
                        <x-button-secondary href="{{ route('apps.index') }}">All apps</x-button-secondary>
                    </div>
                </div>

                {{-- Right: free vs pro summary card --}}
                <div class="hidden lg:flex justify-end">
                    <div class="rounded-2xl border border-border bg-surface p-8 w-full max-w-xs">
                        <p class="text-xs font-semibold uppercase tracking-widest text-text-muted mb-5">What's included</p>
                        <div class="space-y-3">
                            @forelse($freeFeats->take(3) as $feat)
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                                <span class="text-sm text-text-body">{{ $feat['label'] }}</span>
                                <span class="ml-auto text-[10px] font-semibold text-emerald-600 uppercase tracking-wide">Free</span>
                            </div>
                            @empty
                            @endforelse

                            @forelse($proFeats->take(2) as $feat)
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-violet flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
                                <span class="text-sm text-text-body">{{ $feat['label'] }}</span>
                                <span class="ml-auto text-[10px] font-semibold text-violet uppercase tracking-wide">Pro</span>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Tile image ──────────────────────────────────────────────────────────── --}}
@if($tileImg)
<section class="bg-bg pb-4">
    <x-container>
        <x-reveal>
            <div class="rounded-2xl overflow-hidden border border-border shadow-xl">
                <img
                    src="{{ $tileImg }}"
                    alt="{{ $app->title }}"
                    class="w-full h-auto max-h-[400px] object-cover"
                    width="600"
                    height="400"
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
            <div class="rounded-2xl overflow-hidden border border-border h-48 flex items-center justify-center"
                 style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.12)">
                    <x-svg-icon :name="$app->icon ?? 'squares-2x2'" class="w-7 h-7 text-white" />
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Description ─────────────────────────────────────────────────────────── --}}
@if($app->description)
<section class="py-20 bg-bg">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto prose prose-lg prose-a:text-violet prose-headings:font-heading prose-headings:text-indigo-ink prose-headings:font-semibold">
                {!! $app->description !!}
            </div>
        </x-reveal>
    </x-container>
</section>
@endif

{{-- ── Feature list ─────────────────────────────────────────────────────────── --}}
@if($hasFeatures)
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">What you get</p>
                <h2 class="font-heading font-bold text-3xl text-indigo-ink mb-10">Free features & pro upgrades</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Free column --}}
                    @if($freeFeats->isNotEmpty())
                    <div class="rounded-2xl border border-border bg-bg p-6">
                        <div class="flex items-center gap-2 mb-5">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-700">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                                Free
                            </span>
                            <span class="text-xs text-text-muted">Open to everyone</span>
                        </div>
                        <ul class="space-y-3">
                            @foreach($freeFeats as $feat)
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                <span class="text-sm text-text-body">{{ $feat['label'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Pro column --}}
                    @if($proFeats->isNotEmpty())
                    <div class="rounded-2xl border border-violet/20 bg-bg p-6 relative overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
                        <div class="flex items-center gap-2 mb-5">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold text-white" style="background: var(--gradient-brand)">
                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
                                Pro
                            </span>
                            <span class="text-xs text-text-muted">Requires subscription</span>
                        </div>
                        <ul class="space-y-3">
                            @foreach($proFeats as $feat)
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-violet flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
                                <span class="text-sm text-text-body">{{ $feat['label'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
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
                @if($isLive)
                    <h2 class="font-heading font-bold text-3xl text-indigo-ink">
                        Ready to try <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $app->title }}</span>?
                    </h2>
                    <p class="mt-4 text-text-muted leading-relaxed">Free features are open to everyone. Create an account to get started.</p>
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                        <x-button-primary href="{{ route('apps.show', $app) }}/use">Try it free</x-button-primary>
                        <x-button-secondary href="{{ route('customer.register') }}">Create account</x-button-secondary>
                    </div>
                @else
                    <h2 class="font-heading font-bold text-3xl text-indigo-ink">
                        {{ $app->title }} is coming soon
                    </h2>
                    <p class="mt-4 text-text-muted leading-relaxed">We're putting the finishing touches on this one. Get in touch if you'd like to be first to know.</p>
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                        <x-button-primary href="{{ route('contact') }}">Get notified</x-button-primary>
                        <x-button-secondary href="{{ route('apps.index') }}">See all apps</x-button-secondary>
                    </div>
                @endif
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

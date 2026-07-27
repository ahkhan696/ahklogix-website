<x-layouts.app
    title="Apps — AHKLOGIX"
    description="Mini-apps built by AHKLOGIX — tools that automate, calculate, and accelerate your business. Free to use, with pro features available.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">Apps</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Tools & mini-apps</p>
                <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                    Apps that work as hard as you do
                </h1>
                <p class="mt-6 text-lg text-text-muted leading-relaxed max-w-2xl">
                    Free-to-use tools built for business owners — calculators, automations, and utilities. Free tier is open to everyone; pro features unlock with a subscription.
                </p>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Apps grid ────────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg">
    <x-container>
        @if($apps->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($apps as $app)
            @php
                $isLive       = $app->status === 'live';
                $tileImg      = $app->getFirstMediaUrl('tile_image', 'card') ?: $app->getFirstMediaUrl('tile_image');
                $freeFeatures = collect($app->feature_list ?? [])->where('tier', 'free')->count();
                $proFeatures  = collect($app->feature_list ?? [])->where('tier', 'pro')->count();
            @endphp
            <x-reveal :delay="$loop->index % 3 * 80">
                @if($isLive)
                <a
                    href="{{ route('apps.show', $app) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-bg overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                @else
                <div class="flex flex-col rounded-2xl border border-border bg-bg overflow-hidden h-full opacity-70">
                @endif

                    {{-- Tile image / gradient banner --}}
                    <div class="relative h-40 overflow-hidden flex-shrink-0">
                        @if($tileImg)
                            <img
                                src="{{ $tileImg }}"
                                alt="{{ $app->title }}"
                                class="w-full h-full object-cover {{ $isLive ? 'transition-transform duration-500 group-hover:scale-105' : '' }}"
                                loading="lazy"
                                width="600"
                                height="400"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center"
                                 style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                                <x-svg-icon :name="$app->icon ?? 'squares-2x2'" class="w-10 h-10 text-white/70" />
                            </div>
                        @endif

                        {{-- Status badge --}}
                        @if(!$isLive)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 backdrop-blur-sm px-2.5 py-1 text-[11px] font-semibold text-text-muted">
                                <span class="w-1.5 h-1.5 rounded-full bg-text-muted inline-block"></span>
                                Coming soon
                            </span>
                        </div>
                        @else
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 backdrop-blur-sm px-2.5 py-1 text-[11px] font-semibold text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                Live
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Card body --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h2 class="font-heading font-semibold text-lg text-indigo-ink {{ $isLive ? 'group-hover:text-violet transition-colors duration-200' : '' }} leading-snug">
                            {{ $app->title }}
                        </h2>

                        @if($app->tagline)
                        <p class="mt-2 text-sm text-text-muted leading-relaxed flex-1">
                            {{ $app->tagline }}
                        </p>
                        @endif

                        {{-- Free / Pro feature count --}}
                        @if($freeFeatures || $proFeatures)
                        <div class="mt-5 flex items-center gap-3 flex-wrap">
                            @if($freeFeatures)
                            <span class="inline-flex items-center gap-1 rounded-full border border-border bg-surface px-2.5 py-1 text-xs font-medium text-text-body">
                                <svg class="w-3 h-3 text-emerald-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                                {{ $freeFeatures }} free
                            </span>
                            @endif
                            @if($proFeatures)
                            <span class="inline-flex items-center gap-1 rounded-full border border-border bg-surface px-2.5 py-1 text-xs font-medium text-text-body">
                                <svg class="w-3 h-3 text-violet" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
                                {{ $proFeatures }} pro
                            </span>
                            @endif
                        </div>
                        @endif

                        @if($isLive)
                        <div class="mt-5 flex items-center gap-1.5 text-sm font-semibold text-violet group-hover:gap-2.5 transition-all duration-200">
                            View app
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                @if($isLive)
                </a>
                @else
                </div>
                @endif
            </x-reveal>
            @endforeach
        </div>
        @else
        <x-reveal>
            <div class="py-24 flex flex-col items-center text-center gap-5">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: var(--gradient-brand)">
                    <x-svg-icon name="squares-2x2" class="w-8 h-8 text-white" />
                </div>
                <h2 class="font-heading font-semibold text-xl text-indigo-ink">Apps coming soon</h2>
                <p class="text-text-muted text-sm max-w-xs leading-relaxed">We're building tools to help your business run smarter. Check back soon.</p>
                <x-button-primary href="{{ route('contact') }}">Get notified</x-button-primary>
            </div>
        </x-reveal>
        @endif
    </x-container>
</section>

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Need a custom tool for your business?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    We build bespoke automation, calculators, and internal tools. Tell us what you're trying to automate.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a conversation</x-button-primary>
                    <x-button-secondary href="{{ route('services.index') }}">Our services</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

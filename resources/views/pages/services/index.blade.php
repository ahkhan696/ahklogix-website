<x-layouts.app
    title="Services"
    description="Custom web apps, API integration, Zoho, GoHighLevel, Make.com automation, AI chatbots, mobile apps, and digital marketing — built by AHKLOGIX.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">Services</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">What we do</p>
                <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                    Everything you need to build, automate, and grow
                </h1>
                <p class="mt-6 text-lg text-text-muted leading-relaxed max-w-2xl">
                    We cover the full stack of modern business technology — from custom software to CRM implementation to AI integration. One studio. No handoffs.
                </p>
                <div class="mt-8">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Services grid ───────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg">
    <x-container>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <x-reveal :delay="$loop->index % 3 * 80">
                <a
                    href="{{ route('services.show', $service->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-bg p-7 h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    {{-- Icon --}}
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5 flex-shrink-0" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$service->icon ?? 'code-bracket'" class="w-6 h-6 text-white" />
                    </div>

                    <h2 class="font-heading font-semibold text-lg text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug">
                        {{ $service->title }}
                    </h2>
                    <p class="mt-3 text-sm text-text-muted leading-relaxed flex-1">
                        {{ $service->short_description }}
                    </p>

                    <div class="mt-6 flex items-center gap-1.5 text-sm font-semibold text-violet group-hover:gap-2.5 transition-all duration-200">
                        Learn more
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Not sure which service fits?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Tell us what you're trying to achieve — we'll recommend the right approach, no commitment required.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a conversation</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our work</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

<x-layouts.app
    title="Pricing Calculator — AHKLOGIX Apps"
    description="Calculate your true e-commerce margins across Amazon, Shopify, and eBay — instantly, for free.">

{{-- ── Page header ──────────────────────────────────────────────────────────── --}}
<section class="pt-14 pb-10 bg-bg border-b border-border">
    <x-container>
        <nav class="flex items-center gap-2 text-xs text-text-muted mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('apps.index') }}" class="hover:text-violet transition-colors duration-200">Apps</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('apps.show', $app) }}" class="hover:text-violet transition-colors duration-200">{{ $app->title }}</a>
            <span aria-hidden="true">›</span>
            <span class="text-indigo-ink font-medium">Calculator</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$app->icon ?? 'calculator'" class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h1 class="font-heading font-bold text-2xl text-indigo-ink leading-tight">{{ $app->title }}</h1>
                        <p class="text-sm text-text-muted">{{ $app->tagline }}</p>
                    </div>
                </div>
            </div>
            <a
                href="{{ route('apps.show', $app) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-text-muted hover:text-violet transition-colors duration-150 flex-shrink-0"
            >
                <svg class="w-4 h-4 rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                About this app
            </a>
        </div>
    </x-container>
</section>

{{-- ── Calculator ───────────────────────────────────────────────────────────── --}}
<section class="py-12 bg-surface min-h-[60vh]">
    <x-container>
        <livewire:pricing-calculator />
    </x-container>
</section>

</x-layouts.app>

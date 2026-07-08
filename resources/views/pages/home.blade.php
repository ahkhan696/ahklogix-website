<x-layouts.app title="Software Engineering Studio">

    {{-- Placeholder hero — replaced in Phase 4 with full 12-section home page --}}
    <section class="min-h-[80vh] flex items-center bg-bg">
        <x-container class="py-24">

            <x-reveal>
                <p class="text-sm font-semibold text-violet tracking-wide uppercase mb-4">Phase 2 — Design System</p>
                <h1 class="text-5xl lg:text-6xl font-bold text-indigo-ink leading-tight max-w-3xl">
                    We build <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">software</span><br>
                    that moves businesses forward.
                </h1>
            </x-reveal>

            <x-reveal :delay="80">
                <p class="mt-6 text-lg text-text-muted max-w-xl leading-relaxed">
                    Custom web apps, API integrations, Zoho, GoHighLevel, Make.com automations, AI chatbots — built properly, by engineers who care about quality.
                </p>
            </x-reveal>

            <x-reveal :delay="160">
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our work</x-button-secondary>
                </div>
            </x-reveal>

            {{-- Design system preview --}}
            <x-reveal :delay="240">
                <div class="mt-20 pt-12 border-t border-border">
                    <p class="text-xs text-text-muted uppercase tracking-widest font-semibold mb-8">Design system components — Phase 2 scaffold</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- Color swatches --}}
                        <div class="bg-surface rounded-2xl border border-border p-6">
                            <p class="text-xs text-text-muted font-semibold uppercase tracking-wide mb-4">Brand colors</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach([
                                    ['bg-indigo-ink',  '#1E1B4B', ''],
                                    ['bg-indigo-deep', '#2D1B69', ''],
                                    ['bg-violet',      '#7C3AED', ''],
                                    ['bg-magenta',     '#EC1FC4', ''],
                                    ['bg-blue-brand',  '#2E8BE6', ''],
                                    ['bg-surface',     '#F7F7FB', 'border border-border'],
                                ] as [$tw, $hex, $extra])
                                <div
                                    class="w-8 h-8 rounded-lg {{ $tw }} {{ $extra }}"
                                    title="{{ $hex }}"
                                ></div>
                                @endforeach
                                <div class="w-8 h-8 rounded-lg" style="background: var(--gradient-brand)" title="Brand gradient"></div>
                            </div>
                        </div>

                        {{-- Typography --}}
                        <div class="bg-surface rounded-2xl border border-border p-6">
                            <p class="text-xs text-text-muted font-semibold uppercase tracking-wide mb-4">Typography</p>
                            <p class="font-heading font-bold text-xl text-indigo-ink">Space Grotesk 700</p>
                            <p class="font-heading font-semibold text-lg text-indigo-ink">Space Grotesk 600</p>
                            <p class="font-heading font-medium text-base text-text-body">Space Grotesk 500</p>
                            <p class="font-body text-sm text-text-body mt-2">Inter 400 — body copy sits here, comfortable at 16px with 1.7 line-height.</p>
                        </div>

                        {{-- Buttons --}}
                        <div class="bg-surface rounded-2xl border border-border p-6 flex flex-col gap-3 justify-center">
                            <p class="text-xs text-text-muted font-semibold uppercase tracking-wide mb-1">Buttons</p>
                            <x-button-primary href="#">Primary CTA</x-button-primary>
                            <x-button-secondary href="#">Secondary CTA</x-button-secondary>
                        </div>

                    </div>
                </div>
            </x-reveal>

        </x-container>
    </section>

</x-layouts.app>

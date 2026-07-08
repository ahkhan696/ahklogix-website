<x-layouts.app
    title="Portfolio"
    description="250+ projects delivered — custom web apps, CRM implementations, automation, AI chatbots, and mobile apps. Browse our case studies.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">Portfolio</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Our work</p>
                <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                    Projects that prove the point
                </h1>
                <p class="mt-6 text-lg text-text-muted leading-relaxed max-w-2xl">
                    A selection of what we've built — web apps, CRM implementations, automations, and AI integrations. Code that works. Results that matter.
                </p>
            </div>

            {{-- Stats strip --}}
            <div class="mt-10 flex flex-wrap items-center gap-8">
                @foreach(['250+ projects delivered', '50+ happy clients', 'Fiverr · Upwork · Direct'] as $stat)
                <span class="text-sm font-semibold text-text-body">{{ $stat }}</span>
                @endforeach
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Filter + grid ───────────────────────────────────────────────────────── --}}
<section
    class="py-20 bg-bg"
    x-data="{ active: 'all' }"
>
    <x-container>

        {{-- Category filter pills --}}
        @if($categories->isNotEmpty())
        <x-reveal>
            <div class="flex flex-wrap items-center gap-2 mb-12" role="group" aria-label="Filter by category">
                <button
                    @click="active = 'all'"
                    :class="active === 'all'
                        ? 'text-white'
                        : 'bg-surface border-border text-text-muted hover:text-violet hover:border-violet'"
                    class="relative px-4 py-2 rounded-full text-sm font-semibold border transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 overflow-hidden"
                >
                    <span
                        class="absolute inset-0 rounded-full transition-opacity duration-200"
                        :class="active === 'all' ? 'opacity-100' : 'opacity-0'"
                        style="background: var(--gradient-brand)"
                        aria-hidden="true"
                    ></span>
                    <span class="relative">All</span>
                </button>

                @foreach($categories as $cat)
                <button
                    @click="active = '{{ $cat }}'"
                    :class="active === '{{ $cat }}'
                        ? 'text-white'
                        : 'bg-surface border-border text-text-muted hover:text-violet hover:border-violet'"
                    class="relative px-4 py-2 rounded-full text-sm font-semibold border transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 overflow-hidden"
                >
                    <span
                        class="absolute inset-0 rounded-full transition-opacity duration-200"
                        :class="active === '{{ $cat }}' ? 'opacity-100' : 'opacity-0'"
                        style="background: var(--gradient-brand)"
                        aria-hidden="true"
                    ></span>
                    <span class="relative">{{ $cat }}</span>
                </button>
                @endforeach
            </div>
        </x-reveal>
        @endif

        {{-- Project grid --}}
        @if($projects->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
            <div
                x-show="active === 'all' || active === '{{ $project->category }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <a
                    href="{{ route('portfolio.show', $project->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-white overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    {{-- Cover image --}}
                    <div class="relative h-48 overflow-hidden flex-shrink-0">
                        @if($project->getFirstMediaUrl('cover'))
                            <img
                                src="{{ $project->getFirstMediaUrl('cover') }}"
                                alt="{{ $project->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy" width="600" height="384"
                            >
                        @else
                            <div class="w-full h-full flex items-end p-5" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 55%, #7C3AED 100%)">
                                <span class="font-heading font-bold text-lg text-white/80 leading-tight">{{ $project->title }}</span>
                            </div>
                        @endif

                        @if($project->category)
                        <div class="absolute top-3 left-3">
                            <span class="inline-block rounded-full px-2.5 py-1 text-[11px] font-semibold bg-white/90 text-indigo-ink backdrop-blur-sm">
                                {{ $project->category }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Card body --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h2 class="font-heading font-semibold text-base text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug">
                            {{ $project->title }}
                        </h2>
                        @if($project->client)
                        <p class="mt-1 text-xs text-text-muted">{{ $project->client }}</p>
                        @endif
                        @if($project->problem)
                        <p class="mt-3 text-sm text-text-muted leading-relaxed line-clamp-2 flex-1">
                            {{ $project->problem }}
                        </p>
                        @endif

                        @if($project->tags)
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach(array_slice((array)$project->tags, 0, 3) as $tag)
                            <span class="rounded-full border border-border px-2.5 py-0.5 text-[11px] font-medium text-text-muted">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div class="mt-4 flex items-center gap-1.5 text-sm font-semibold text-violet group-hover:gap-2.5 transition-all duration-200">
                            View case study
                            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-24 flex flex-col items-center text-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: var(--gradient-brand)">
                <x-svg-icon name="rectangle-stack" class="w-8 h-8 text-white" />
            </div>
            <h2 class="font-heading font-semibold text-xl text-indigo-ink">Projects coming soon</h2>
            <p class="text-text-muted text-sm max-w-xs leading-relaxed">We're adding case studies here. Reach out to see our full portfolio in the meantime.</p>
            <x-button-primary href="{{ route('contact') }}">Get in touch</x-button-primary>
        </div>
        @endif

    </x-container>
</section>

{{-- ── CTA band ─────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Want results like these?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Tell us what you're building. We'll tell you how we'd approach it.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('services.index') }}">View services</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

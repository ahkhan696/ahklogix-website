<x-layouts.app title="Software Engineering Studio — Custom Web Apps, Automation & AI">
<x-slot:head>
@include('partials.jsonld.organization')
</x-slot:head>

{{-- ════════════════════════════════════════════════════════════════
     §2.2  HERO
     ════════════════════════════════════════════════════════════════ --}}
<section id="hero" class="relative flex items-center min-h-[calc(100vh-73px)] overflow-hidden bg-bg">

    {{-- Canvas background (§8.1) --}}
    <canvas id="hero-bg" class="absolute inset-0 w-full h-full" aria-hidden="true"></canvas>

    {{-- Subtle white wash so text stays legible over canvas --}}
    <div class="absolute inset-0 bg-white/65 pointer-events-none" aria-hidden="true"></div>

    <x-container class="relative z-10 py-20 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-20 items-center">

            {{-- Left: headline + CTAs --}}
            <div>
                {{-- Eyebrow pill --}}
                <div class="hero-enter hero-enter-1 inline-flex items-center gap-2 rounded-full border border-border bg-surface px-4 py-1.5 mb-7">
                    <span class="inline-block w-1.5 h-1.5 rounded-full flex-shrink-0" style="background: var(--gradient-brand)"></span>
                    <span class="text-xs font-semibold text-text-muted tracking-wide">Software Engineering Studio</span>
                </div>

                {{-- Headline with rotating gradient word (§8.3) --}}
                <h1 class="hero-enter hero-enter-2 font-heading font-bold text-5xl lg:text-[3.5rem] text-indigo-ink leading-[1.12]">
                    We build<br>
                    <span
                        x-data="{
                            words: ['software', 'automation', 'AI tools', 'integrations'],
                            i: 0,
                            flipping: false,
                        }"
                        x-init="setInterval(() => {
                            flipping = true;
                            setTimeout(() => { i = (i + 1) % words.length; flipping = false; }, 240);
                        }, 3200)"
                        class="inline-block"
                    >
                        <span
                            x-text="words[i]"
                            :class="flipping
                                ? 'opacity-0 -translate-y-1'
                                : 'opacity-100 translate-y-0'"
                            class="inline-block transition-all duration-[220ms] ease-out"
                            style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"
                        >software</span>
                    </span><br>
                    that moves businesses<br>
                    forward.
                </h1>

                <p class="hero-enter hero-enter-3 mt-6 text-lg text-text-muted max-w-[480px] leading-relaxed">
                    Custom web apps, API integrations, Zoho, GoHighLevel, Make.com, and AI chatbots — built properly, by engineers who care about quality.
                </p>

                <div class="hero-enter hero-enter-4 mt-10 flex flex-wrap items-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our work</x-button-secondary>
                </div>
            </div>

            {{-- Right: dashboard metrics card --}}
            <div class="hidden lg:flex justify-center items-center">
                <div class="hero-enter hero-enter-4 relative w-full max-w-[340px]">

                    {{-- Main card --}}
                    <div class="relative rounded-2xl border border-border bg-white shadow-2xl p-6 overflow-hidden">
                        {{-- Gradient top accent --}}
                        <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>

                        {{-- Browser chrome dots --}}
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-400/70"></div>
                            <div class="ml-2 flex-1 h-5 rounded-full bg-surface border border-border"></div>
                        </div>

                        {{-- Metric chips --}}
                        <div class="grid grid-cols-3 gap-2.5 mb-5">
                            @foreach([['250+', 'Projects'], ['50+', 'Clients'], ['4.9★', 'Rating']] as [$val, $lbl])
                            <div class="rounded-xl bg-surface border border-border p-3 text-center">
                                <div class="text-xl font-bold text-violet font-heading">{{ $val }}</div>
                                <div class="text-[11px] text-text-muted mt-0.5">{{ $lbl }}</div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Progress bars --}}
                        <div class="space-y-3">
                            @foreach([['Custom Web Apps', 98], ['Automation', 95], ['AI Integration', 92]] as [$lbl, $pct])
                            <div>
                                <div class="flex justify-between text-[11px] text-text-muted mb-1.5">
                                    <span>{{ $lbl }}</span><span>{{ $pct }}%</span>
                                </div>
                                <div class="h-1.5 bg-surface rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width:{{ $pct }}%; background: var(--gradient-brand)"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Floating badge: deployed --}}
                    <div class="absolute -top-3 -right-4 bg-white rounded-xl shadow-lg border border-border px-3 py-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></span>
                        <span class="text-xs font-semibold text-text-body">Just deployed</span>
                    </div>

                    {{-- Floating badge: rating --}}
                    <div class="absolute -bottom-3 -left-4 bg-white rounded-xl shadow-lg border border-border px-3 py-2 flex items-center gap-2">
                        <span class="text-amber-400 text-sm leading-none tracking-tight">★★★★★</span>
                        <span class="text-xs font-semibold text-text-body">5.0 rated</span>
                    </div>

                </div>
            </div>
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.3  TRUST BAR  — count-up stats (§8.5) + platform strip
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-14 bg-surface border-y border-border">
    <x-container>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 text-center divide-y sm:divide-y-0 sm:divide-x divide-border">
            @foreach([
                ['target' => 250, 'suffix' => '+', 'label' => 'Projects delivered'],
                ['target' => 50,  'suffix' => '+', 'label' => 'Happy clients'],
                ['target' => 10,  'suffix' => '+', 'label' => 'Platforms integrated'],
            ] as $stat)
            <div
                class="pt-8 sm:pt-0 sm:px-10 first:pt-0 first:sm:pl-0 last:sm:pr-0"
                x-data="{ count: 0, done: false }"
                x-intersect.once="
                    if (!done) {
                        done = true;
                        const target = {{ $stat['target'] }};
                        const dur = 1200;
                        const start = performance.now();
                        const run = (now) => {
                            const p = Math.min((now - start) / dur, 1);
                            count = Math.round(target * (1 - Math.pow(1 - p, 3)));
                            if (p < 1) requestAnimationFrame(run);
                        };
                        requestAnimationFrame(run);
                    }
                "
            >
                <div class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink">
                    <span x-text="count + '{{ $stat['suffix'] }}'">0{{ $stat['suffix'] }}</span>
                </div>
                <p class="mt-2 text-sm font-medium text-text-muted">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-10 pt-10 border-t border-border flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
            <span class="text-[10px] text-text-muted uppercase tracking-widest font-semibold">Trusted by clients on</span>
            @foreach(['Fiverr', 'Upwork', 'Direct', 'GoHighLevel Marketplace', 'Zoho Partner Network'] as $platform)
            <span class="text-sm font-semibold text-text-body">{{ $platform }}</span>
            @endforeach
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.4  SERVICES GRID  — from DB (§8.6 card hover)
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-bg">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">What we do</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">Services built around your goals</h2>
                <p class="mt-4 text-text-muted leading-relaxed">From custom software to AI automation — we cover the full stack of modern business technology.</p>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($services as $service)
            <x-reveal :delay="$loop->index % 4 * 70">
                <a
                    href="{{ route('services.show', $service->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-bg p-6 h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    {{-- Icon badge --}}
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-5 flex-shrink-0" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$service->icon ?? 'code-bracket'" class="w-5 h-5 text-white" />
                    </div>

                    <h3 class="font-heading font-semibold text-base text-indigo-ink group-hover:text-violet transition-colors duration-200">
                        {{ $service->title }}
                    </h3>
                    <p class="mt-2 text-sm text-text-muted leading-relaxed flex-1">
                        {{ $service->short_description }}
                    </p>

                    <div class="mt-5 flex items-center gap-1.5 text-sm font-semibold text-violet group-hover:gap-2.5 transition-all duration-200">
                        Learn more
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </a>
            </x-reveal>
            @endforeach
        </div>

        <x-reveal>
            <div class="mt-12 text-center">
                <x-button-secondary href="{{ route('services.index') }}">View all services</x-button-secondary>
            </div>
        </x-reveal>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.5  PORTFOLIO HIGHLIGHTS  — featured projects from DB
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-surface">
    <x-container>
        <x-reveal>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-14">
                <div>
                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Our work</p>
                    <h2 class="font-heading font-bold text-4xl text-indigo-ink">Selected projects</h2>
                    <p class="mt-4 text-text-muted max-w-xl leading-relaxed">A snapshot of what we've built — from SaaS products to AI-powered automations.</p>
                </div>
                <x-button-secondary href="{{ route('portfolio.index') }}" class="flex-shrink-0">View all work</x-button-secondary>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($projects as $project)
            <x-reveal :delay="$loop->index % 3 * 80">
                <a
                    href="{{ route('portfolio.show', $project->slug) }}"
                    class="card-hover group flex flex-col rounded-2xl border border-border bg-white overflow-hidden h-full no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    {{-- Cover image or gradient placeholder --}}
                    <div class="relative h-44 overflow-hidden">
                        @if($project->getFirstMediaUrl('cover'))
                            <img
                                src="{{ $project->getFirstMediaUrl('cover') }}"
                                alt="{{ $project->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                                width="600" height="340"
                            >
                        @else
                            <div class="w-full h-full flex items-end p-5" style="background: linear-gradient(135deg, #1E1B4B 0%, #2D1B69 60%, #7C3AED 100%)">
                                <span class="font-heading font-bold text-xl text-white/80 leading-tight">{{ $project->title }}</span>
                            </div>
                        @endif
                        {{-- Category badge --}}
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
                        <h3 class="font-heading font-semibold text-base text-indigo-ink group-hover:text-violet transition-colors duration-200 leading-snug">
                            {{ $project->title }}
                        </h3>
                        @if($project->client)
                        <p class="mt-1 text-xs text-text-muted">{{ $project->client }}</p>
                        @endif
                        @if($project->problem)
                        <p class="mt-3 text-sm text-text-muted leading-relaxed line-clamp-2 flex-1">{{ $project->problem }}</p>
                        @endif

                        {{-- Tags --}}
                        @if($project->tags)
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @foreach(array_slice((array)$project->tags, 0, 3) as $tag)
                            <span class="rounded-full border border-border px-2.5 py-0.5 text-[11px] font-medium text-text-muted">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </a>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.6  WHY CHOOSE US  — 4 static differentiators
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-bg">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Why AHKLOGIX</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">The studio that actually delivers</h2>
                <p class="mt-4 text-text-muted leading-relaxed">We're not an order-taker agency. We're engineers who care about your outcome.</p>
            </div>
        </x-reveal>

        @php
        $whys = [
            ['icon' => 'check-badge', 'title' => 'Engineers, not order-takers', 'desc' => 'You speak directly with the architect. We push back when something won\'t work, and propose a better path.'],
            ['icon' => 'rectangle-stack', 'title' => 'Full-stack delivery', 'desc' => 'Web, mobile, CRM, automation, and AI under one roof. No handoffs, no finger-pointing.'],
            ['icon' => 'sparkles', 'title' => '250+ projects of proof', 'desc' => 'Hundreds of completed projects on Fiverr and Upwork — reviews you can read, not claims you have to trust.'],
            ['icon' => 'globe-alt', 'title' => 'Async-first, timezone-adaptive', 'desc' => 'Clear written communication, structured updates, and delivery that doesn\'t depend on being in the same time zone.'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($whys as $i => $why)
            <x-reveal :delay="$i * 80">
                <div class="flex flex-col p-6 rounded-2xl border border-border bg-surface h-full">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$why['icon']" class="w-5 h-5 text-white" />
                    </div>
                    <h3 class="font-heading font-semibold text-base text-indigo-ink mb-2">{{ $why['title'] }}</h3>
                    <p class="text-sm text-text-muted leading-relaxed flex-1">{{ $why['desc'] }}</p>
                </div>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.7  PROCESS  — 4-step timeline with line-draw animation (§8.7)
     ════════════════════════════════════════════════════════════════ --}}
@php
$steps = [
    ['n' => '01', 'title' => 'Discovery',          'desc' => 'We learn your goals, constraints, and users before writing a single line of code.'],
    ['n' => '02', 'title' => 'Planning',            'desc' => 'Scope, architecture, and timeline agreed in writing — no surprises.'],
    ['n' => '03', 'title' => 'Build & Test',        'desc' => 'Sprints with regular demos. You see progress, not just the final result.'],
    ['n' => '04', 'title' => 'Launch & Support',    'desc' => 'Deployment, training, and a support plan that keeps things running.'],
];
@endphp

<section
    class="py-24 bg-indigo-ink overflow-hidden"
    x-data="{ drawn: false }"
    x-intersect.once="drawn = true"
>
    <x-container>
        <x-reveal>
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-wide mb-3" style="color: rgba(124,58,237,0.8)">How we work</p>
                <h2 class="font-heading font-bold text-4xl text-white">Our process, in plain English</h2>
                <p class="mt-4 max-w-xl mx-auto leading-relaxed" style="color: rgba(255,255,255,0.55)">Four stages. No jargon. No black box.</p>
            </div>
        </x-reveal>

        {{-- Desktop: horizontal timeline --}}
        <div class="hidden lg:block relative">
            {{-- Background rail --}}
            <div class="absolute top-5 left-[12.5%] right-[12.5%] h-px" style="background: rgba(255,255,255,0.10)">
                {{-- Animated gradient line --}}
                <div
                    class="timeline-line absolute inset-0"
                    :class="drawn ? 'is-drawn' : ''"
                    style="background: var(--gradient-brand)"
                    aria-hidden="true"
                ></div>
            </div>

            <div class="grid grid-cols-4 gap-6">
                @foreach($steps as $i => $step)
                <div class="flex flex-col items-center text-center">
                    {{-- Dot --}}
                    <div
                        class="relative z-10 w-10 h-10 rounded-full border-2 flex items-center justify-center font-heading font-bold text-sm mb-6"
                        style="
                            background: #1E1B4B;
                            border-color: #7C3AED;
                            color: #7C3AED;
                            transition: transform 350ms ease-out {{ 280 + $i * 160 }}ms, opacity 350ms ease-out {{ 280 + $i * 160 }}ms;
                        "
                        :style="drawn
                            ? 'transform: scale(1); opacity: 1; background: #1E1B4B; border-color: #7C3AED; color: #7C3AED;'
                            : 'transform: scale(0); opacity: 0; background: #1E1B4B; border-color: #7C3AED; color: #7C3AED;'"
                    >{{ $step['n'] }}</div>

                    <h3 class="font-heading font-semibold text-white text-base mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm leading-relaxed max-w-[170px]" style="color: rgba(255,255,255,0.55)">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Mobile: vertical stacked --}}
        <div class="lg:hidden relative pl-8">
            {{-- Vertical line --}}
            <div class="absolute left-[15px] top-0 bottom-0 w-px" style="background: rgba(255,255,255,0.12)" aria-hidden="true">
                <div
                    class="timeline-line absolute inset-0 origin-top"
                    :class="drawn ? 'is-drawn' : ''"
                    style="background: var(--gradient-brand); transform-origin: top; width: 1px;"
                    aria-hidden="true"
                ></div>
            </div>

            <div class="space-y-10">
                @foreach($steps as $i => $step)
                <div class="relative">
                    {{-- Dot --}}
                    <div
                        class="absolute -left-8 top-0 w-8 h-8 rounded-full border-2 flex items-center justify-center font-heading font-bold text-xs"
                        style="
                            background: #1E1B4B;
                            border-color: #7C3AED;
                            color: #7C3AED;
                            transition: transform 350ms ease-out {{ 200 + $i * 120 }}ms, opacity 350ms ease-out {{ 200 + $i * 120 }}ms;
                        "
                        :style="drawn
                            ? 'transform: scale(1); opacity: 1; background: #1E1B4B; border-color: #7C3AED; color: #7C3AED;'
                            : 'transform: scale(0); opacity: 0; background: #1E1B4B; border-color: #7C3AED; color: #7C3AED;'"
                    >{{ $step['n'] }}</div>

                    <h3 class="font-heading font-semibold text-white text-base mb-1">{{ $step['title'] }}</h3>
                    <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.55)">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.8  POSR TEASER  — product spotlight
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-surface">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-20 items-center">

            {{-- Left: text --}}
            <x-reveal>
                <div>
                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Our product</p>
                    <h2 class="font-heading font-bold text-4xl text-indigo-ink leading-tight">Point of Sale built for restaurants</h2>
                    <p class="mt-5 text-text-muted leading-relaxed max-w-lg">
                        POSR is our own restaurant management platform — table management, kitchen display, inventory, and real-time reporting in one place. No bloat, no learning curve.
                    </p>

                    <ul class="mt-8 space-y-3">
                        @foreach([
                            'Table & order management with kitchen display',
                            'Real-time inventory tracking and alerts',
                            'Daily, weekly, and monthly revenue reports',
                            'Multi-user with role-based access',
                        ] as $feature)
                        <li class="flex items-start gap-3 text-sm text-text-body">
                            <svg class="w-5 h-5 text-violet flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="mt-10">
                        <x-button-primary href="{{ route('posr') }}">Explore POSR</x-button-primary>
                    </div>
                </div>
            </x-reveal>

            {{-- Right: device mockup (CSS-only) --}}
            <x-reveal :delay="120">
                <div class="flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-sm">
                        {{-- Screen --}}
                        <div class="rounded-2xl border border-border bg-white shadow-2xl overflow-hidden">
                            {{-- Gradient header bar --}}
                            <div class="h-12 flex items-center px-5 gap-3" style="background: var(--gradient-brand)">
                                <div class="w-2 h-2 rounded-full bg-white/50"></div>
                                <div class="text-sm font-semibold text-white font-heading">POSR Dashboard</div>
                                <div class="ml-auto text-xs text-white/70">Table 7 active</div>
                            </div>

                            {{-- Mock content area --}}
                            <div class="p-5 space-y-3">
                                {{-- Table grid --}}
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach([
                                        ['T1', 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                                        ['T2', 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                                        ['T3', 'bg-amber-50 border-amber-200 text-amber-700'],
                                        ['T4', 'bg-surface border-border text-text-muted'],
                                        ['T5', 'bg-emerald-50 border-emerald-200 text-emerald-700'],
                                        ['T6', 'bg-surface border-border text-text-muted'],
                                        ['T7', 'bg-violet/10 border-violet/30 text-violet'],
                                        ['T8', 'bg-surface border-border text-text-muted'],
                                    ] as [$label, $cls])
                                    <div class="rounded-lg border {{ $cls }} h-10 flex items-center justify-center text-xs font-bold">{{ $label }}</div>
                                    @endforeach
                                </div>

                                {{-- Order summary --}}
                                <div class="mt-2 rounded-xl border border-border bg-surface p-3">
                                    <div class="text-xs font-semibold text-text-muted mb-2">Table 7 — Active order</div>
                                    <div class="space-y-1.5">
                                        @foreach([['Grilled Salmon', 'AED 85'], ['Caesar Salad', 'AED 42'], ['Still Water x2', 'AED 24']] as [$item, $price])
                                        <div class="flex justify-between text-xs text-text-body">
                                            <span>{{ $item }}</span><span class="font-medium">{{ $price }}</span>
                                        </div>
                                        @endforeach
                                        <div class="pt-1.5 border-t border-border flex justify-between text-xs font-bold text-indigo-ink">
                                            <span>Total</span><span>AED 151</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Floating stat --}}
                        <div class="absolute -bottom-3 -right-4 bg-white rounded-xl shadow-lg border border-border px-3 py-2">
                            <div class="text-xs text-text-muted">Today's revenue</div>
                            <div class="text-base font-bold text-indigo-ink font-heading">AED 12,480</div>
                        </div>
                    </div>
                </div>
            </x-reveal>
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.9  REVIEWS  — featured from DB
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-bg">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Client reviews</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">What clients say</h2>
                <p class="mt-4 text-text-muted leading-relaxed">Real feedback from real projects — on Fiverr, Upwork, and direct engagements.</p>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-5">
            @foreach($reviews as $review)
            <x-reveal :delay="$loop->index % 4 * 80">
                <div class="flex flex-col rounded-2xl border border-border bg-surface p-6 h-full">
                    {{-- Rating stars --}}
                    <div class="flex gap-0.5 mb-4" aria-label="{{ $review->rating }} out of 5 stars">
                        @for($s = 1; $s <= 5; $s++)
                        <svg class="w-4 h-4 {{ $s <= $review->rating ? 'text-amber-400' : 'text-border' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        @endfor
                    </div>

                    {{-- Quote --}}
                    <blockquote class="text-sm text-text-body leading-relaxed flex-1">
                        "{{ $review->quote }}"
                    </blockquote>

                    {{-- Reviewer --}}
                    <div class="mt-5 flex items-center gap-3 pt-5 border-t border-border">
                        @if($review->getFirstMediaUrl('photo'))
                            <img
                                src="{{ $review->getFirstMediaUrl('photo') }}"
                                alt="{{ $review->name }}"
                                class="w-10 h-10 rounded-full object-cover flex-shrink-0"
                                loading="lazy"
                            >
                        @else
                            {{-- Initials fallback --}}
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center font-heading font-bold text-sm text-white flex-shrink-0"
                                style="background: var(--gradient-brand)"
                                aria-hidden="true"
                            >{{ mb_strtoupper(mb_substr($review->name, 0, 1)) }}</div>
                        @endif
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-indigo-ink truncate">{{ $review->name }}</div>
                            @if($review->company)
                            <div class="text-xs text-text-muted truncate">{{ $review->company }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.10  FAQ PREVIEW  — from DB, Alpine accordion
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-surface">
    <x-container>
        <x-reveal>
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12">
                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">FAQ</p>
                    <h2 class="font-heading font-bold text-4xl text-indigo-ink">Common questions</h2>
                    <p class="mt-4 text-text-muted leading-relaxed">Quick answers to what most clients ask before starting.</p>
                </div>

                <div class="space-y-3" role="list">
                    @foreach($faqs as $faq)
                    <div
                        x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }"
                        class="rounded-xl border border-border bg-white overflow-hidden"
                        role="listitem"
                    >
                        <button
                            x-on:click="open = !open"
                            :aria-expanded="open"
                            class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-inset"
                        >
                            <span class="font-heading font-semibold text-sm text-indigo-ink leading-snug">{{ $faq->question }}</span>
                            <svg
                                :class="open ? 'rotate-45' : 'rotate-0'"
                                class="w-5 h-5 text-text-muted flex-shrink-0 transition-transform duration-200 ease-out"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            x-cloak
                        >
                            <div class="px-6 pb-5 pt-0 text-sm text-text-muted leading-relaxed border-t border-border">
                                <div class="pt-4 prose prose-sm prose-a:text-violet max-w-none">{!! $faq->answer !!}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <x-button-secondary href="{{ route('faq') }}">View all FAQs</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>


{{-- ════════════════════════════════════════════════════════════════
     §2.11  FINAL CTA BAND
     ════════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-bg relative overflow-hidden">
    {{-- Top gradient accent line --}}
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>

    {{-- Subtle gradient wash --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background: var(--gradient-brand)" aria-hidden="true"></div>

    <x-container class="relative z-10">
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink">
                    Ready to ship something
                    <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">great?</span>
                </h2>
                <p class="mt-5 text-lg text-text-muted leading-relaxed">
                    Tell us what you're building. We'll tell you how to make it better, faster, and more scalable — no commitment required.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our work first</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

<x-layouts.app
    title="About AHKLOGIX"
    description="AHKLOGIX is a software engineering studio building custom web apps, automations, AI integrations, and mobile apps for businesses that want real results.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-24 bg-bg border-b border-border">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <x-reveal>
                <div>
                    <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                        <span aria-hidden="true">›</span>
                        <span class="text-indigo-ink font-medium">About</span>
                    </nav>

                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">About AHKLOGIX</p>
                    <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                        A studio that builds what it promises
                    </h1>
                    <p class="mt-6 text-lg text-text-muted leading-relaxed">
                        We're a small team of engineers and designers who believe software should solve real problems — clearly scoped, honestly priced, and delivered on time.
                    </p>
                </div>
            </x-reveal>

            {{-- Numbers --}}
            <x-reveal :delay="100">
                <div class="grid grid-cols-2 gap-6">
                    @foreach([
                        ['250+', 'Projects delivered', 'Across Fiverr, Upwork, and direct clients globally.'],
                        ['50+', 'Happy clients', 'Many return for their next project. Some refer us before they\'ve even launched.'],
                        ['5+', 'Years in practice', 'Started as a freelancer, grew into a multi-discipline studio.'],
                        ['8', 'Service areas', 'Web, mobile, CRM, automation, AI, marketing, SEO, and POSR.'],
                    ] as [$num, $label, $desc])
                    <div class="rounded-2xl border border-border bg-surface p-6">
                        <p class="font-heading font-bold text-4xl text-indigo-ink mb-1"
                           style="-webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; background-image: var(--gradient-brand)">{{ $num }}</p>
                        <p class="text-sm font-semibold text-indigo-ink mb-1">{{ $label }}</p>
                        <p class="text-xs text-text-muted leading-relaxed">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </x-reveal>
        </div>
    </x-container>
</section>

{{-- ── Story ─────────────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg">
    <x-container>
        <div class="max-w-3xl mx-auto">
            <x-reveal>
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Our story</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink leading-tight mb-8">
                    Built on real projects, not pitch decks
                </h2>
            </x-reveal>
            <x-reveal :delay="80">
                <div class="space-y-5 text-text-muted leading-relaxed text-[1.0625rem]">
                    <p>
                        AHKLOGIX started with a single developer and a promise: deliver what's scoped, on time, without the agency runaround. That promise turned into a track record — over 250 projects, repeat clients, and a growing catalogue of tools we've built for ourselves as much as for our clients.
                    </p>
                    <p>
                        As the team grew, so did the scope. What began as web development expanded into CRM implementation, marketing automation, AI integration, and eventually our own product — POSR, a point-of-sale system built because restaurant operators kept telling us nothing on the market worked the way their kitchens did.
                    </p>
                    <p>
                        We don't try to be a hundred-person agency. We're precise where it matters: clean architecture, honest timelines, and code that clients can maintain or hand off without a year of explanation.
                    </p>
                </div>
            </x-reveal>
        </div>
    </x-container>
</section>

{{-- ── Capabilities ──────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="mb-12">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">What we do well</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink max-w-2xl leading-tight">Our capabilities</h2>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['code-bracket', 'Custom web apps', 'Full-stack applications — Laravel, Next.js, REST & GraphQL APIs. Built to scale, designed to last.'],
                ['arrow-path', 'Automation & integration', 'Make.com, n8n, Zapier, or custom webhook flows. Data where it needs to be, when it needs to be there.'],
                ['cpu-chip', 'AI integration', 'LLM-powered features, chatbots, document processing, and AI-augmented workflows — OpenAI, Anthropic, and custom models.'],
                ['device-phone-mobile', 'Mobile apps', 'React Native cross-platform apps. Companion apps, field tools, and customer-facing mobile experiences.'],
                ['building-office', 'CRM & platforms', 'Zoho, GoHighLevel, HubSpot — implementation, customisation, and automation that makes the platform earn its seat.'],
                ['magnifying-glass', 'SEO & digital marketing', 'Technical SEO, content strategy, Google Ads, and analytics — performance marketing tied to your revenue, not vanity metrics.'],
            ] as [$icon, $title, $desc])
            <x-reveal :delay="$loop->index % 3 * 70">
                <div class="card-hover rounded-2xl border border-border bg-bg p-6 h-full">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$icon" class="w-5 h-5 text-white" />
                    </div>
                    <h3 class="font-heading font-semibold text-sm text-indigo-ink mb-2">{{ $title }}</h3>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $desc }}</p>
                </div>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>

{{-- ── Values ────────────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg border-t border-border">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <x-reveal>
                <div>
                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">How we work</p>
                    <h2 class="font-heading font-bold text-4xl text-indigo-ink leading-tight">
                        Principles we don't negotiate on
                    </h2>
                    <p class="mt-5 text-text-muted leading-relaxed">
                        These aren't aspirational values on a wall. They're the ground rules we set with every client before a line of code is written.
                    </p>
                </div>
            </x-reveal>

            <div class="space-y-6">
                @foreach([
                    ['Scope first', 'We write the spec before we quote. Every deliverable is agreed in writing — so "done" means the same thing to both of us.'],
                    ['Engineers on the call', 'You speak to the person doing the work. Not a project manager relaying messages between you and a developer you\'ve never met.'],
                    ['Honest timelines', 'We give you the real date, not the date we think you want to hear. If something changes, we tell you before it hits the deadline.'],
                    ['Delivered, not abandoned', 'We stay accountable after launch. Bug in week two? We fix it. Question about the code six months later? We answer it.'],
                ] as [$title, $desc])
                <x-reveal :delay="$loop->index * 70">
                    <div class="flex items-start gap-4">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-heading font-bold text-sm text-white" style="background: var(--gradient-brand)">
                            {{ $loop->index + 1 }}
                        </span>
                        <div>
                            <h3 class="font-heading font-semibold text-base text-indigo-ink mb-1">{{ $title }}</h3>
                            <p class="text-sm text-text-muted leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                </x-reveal>
                @endforeach
            </div>
        </div>
    </x-container>
</section>

{{-- ── Process recap ─────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto mb-14">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">How a project starts</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">From first message to first commit</h2>
            </div>
        </x-reveal>

        <div class="relative">
            {{-- Desktop connecting line --}}
            <div class="hidden lg:block absolute top-5 left-0 right-0 h-px mx-[calc(100%/10)]" aria-hidden="true">
                <div
                    class="h-full timeline-line"
                    style="background: var(--gradient-brand)"
                    x-data="{ drawn: false }"
                    x-intersect.once="drawn = true"
                    :class="drawn ? 'is-drawn' : ''"
                ></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                @foreach([
                    ['chat-bubble-left-right', 'Discovery call', '30 minutes to understand your goal, constraints, and timeline — no sales script.'],
                    ['document-text', 'Scope & quote', 'A written spec within 48 hours. Every feature named. Price agreed before we start.'],
                    ['code-bracket-square', 'Build & review', 'Regular check-ins, a staging link from day one, and you can ask questions any time.'],
                    ['rocket-launch', 'Launch & support', 'We deploy, monitor the first week, and stay available for anything that comes up.'],
                ] as [$icon, $step, $desc])
                <x-reveal :delay="$loop->index * 90">
                    <div class="text-center relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-5 relative z-10 bg-bg border-2 border-violet/30"
                             x-data="{ drawn: false }"
                             x-intersect.once="drawn = true"
                             :style="drawn ? 'animation: dotPop 350ms cubic-bezier(0.34,1.56,0.64,1) both; animation-delay: {{ 280 + $loop->index * 160 }}ms' : 'opacity: 0; transform: scale(0)'">
                            <x-svg-icon :name="$icon" class="w-5 h-5 text-violet" />
                        </div>
                        <h3 class="font-heading font-semibold text-sm text-indigo-ink mb-2">{{ $step }}</h3>
                        <p class="text-xs text-text-muted leading-relaxed">{{ $desc }}</p>
                    </div>
                </x-reveal>
                @endforeach
            </div>
        </div>
    </x-container>
</section>

{{-- ── CTA ───────────────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg border-t border-border relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">Let's build something together</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Tell us what you're working on. Discovery call is free, no commitment, and you'll walk away with a clearer picture of the project even if we don't work together.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Start a project</x-button-primary>
                    <x-button-secondary href="{{ route('portfolio.index') }}">See our work</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

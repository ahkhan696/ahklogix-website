<x-layouts.app
    title="FAQ — Frequently Asked Questions"
    description="Answers to the most common questions about working with AHKLOGIX — process, timelines, pricing, technologies, and how we approach projects.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-20 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <nav class="flex items-center gap-2 text-xs text-text-muted mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-violet transition-colors duration-200">Home</a>
                <span aria-hidden="true">›</span>
                <span class="text-indigo-ink font-medium">FAQ</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Frequently asked questions</p>
                <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                    Questions we get all the time
                </h1>
                <p class="mt-6 text-lg text-text-muted leading-relaxed">
                    Can't find what you're looking for? <a href="{{ route('contact') }}" class="text-violet underline underline-offset-2 hover:text-indigo-ink transition-colors duration-200">Send us a message</a> — we typically reply within a business day.
                </p>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── FAQ accordion ─────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-bg">
    <x-container>
        <div class="max-w-3xl mx-auto">

            @if($grouped->isNotEmpty())
                @foreach($grouped as $category => $faqs)
                <x-reveal>
                    <div class="mb-14">
                        {{-- Category heading --}}
                        @if($category)
                        <div class="flex items-center gap-3 mb-8">
                            <div class="h-px flex-1 bg-border"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-violet">{{ $category }}</span>
                            <div class="h-px flex-1 bg-border"></div>
                        </div>
                        @endif

                        {{-- Accordion items --}}
                        <div class="divide-y divide-border border border-border rounded-2xl overflow-hidden">
                            @foreach($faqs as $faq)
                            <div
                                x-data="{ open: {{ $loop->parent->first && $loop->first ? 'true' : 'false' }} }"
                            >
                                <button
                                    @click="open = !open"
                                    :aria-expanded="open"
                                    class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left bg-bg hover:bg-surface transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-violet"
                                >
                                    <span class="font-heading font-semibold text-base text-indigo-ink leading-snug pr-4">
                                        {{ $faq->question }}
                                    </span>
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center transition-transform duration-300"
                                        :class="open ? 'rotate-45' : 'rotate-0'"
                                        style="background: var(--gradient-brand)"
                                        aria-hidden="true"
                                    >
                                        <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </span>
                                </button>

                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                >
                                    <div class="px-6 pb-6 bg-surface border-t border-border">
                                        <div class="pt-5 text-sm text-text-muted leading-relaxed prose prose-sm prose-a:text-violet prose-a:underline prose-a:underline-offset-2 max-w-none">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </x-reveal>
                @endforeach

            @else
                {{-- Fallback when no FAQs in DB yet --}}
                <x-reveal>
                    <div class="mb-14">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="h-px flex-1 bg-border"></div>
                            <span class="text-xs font-bold uppercase tracking-widest text-violet">General</span>
                            <div class="h-px flex-1 bg-border"></div>
                        </div>

                        <div class="divide-y divide-border border border-border rounded-2xl overflow-hidden">
                            @foreach([
                                ['How do I start a project with AHKLOGIX?', 'Send us a message through the contact page with a brief description of what you want to build. We\'ll schedule a free 30-minute discovery call, then send you a written scope and quote within 48 hours.'],
                                ['What\'s your typical project timeline?', 'It depends on scope. A focused web app or automation takes 2–6 weeks. A full CRM implementation with custom integrations typically runs 4–8 weeks. We give you a real timeline in the scope document before you commit.'],
                                ['Do you work with clients outside your region?', 'Yes. Most of our clients are remote. We work across time zones using async-first communication and scheduled check-ins when needed.'],
                                ['What happens after the project is delivered?', 'We stay available for questions and minor fixes in the two weeks after launch. For ongoing support, we offer monthly retainers that cover updates, hosting management, and priority response.'],
                                ['Can I see your previous work?', 'Yes — our portfolio has selected case studies with problem/solution breakdowns. For specific technology or industry examples, ask during the discovery call and we\'ll share relevant work.'],
                                ['Do you sign NDAs?', 'Absolutely. We\'re happy to sign a mutual NDA before any sensitive project details are shared.'],
                            ] as [$q, $a])
                            <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }">
                                <button
                                    @click="open = !open"
                                    :aria-expanded="open"
                                    class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left bg-bg hover:bg-surface transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-violet"
                                >
                                    <span class="font-heading font-semibold text-base text-indigo-ink leading-snug pr-4">{{ $q }}</span>
                                    <span
                                        class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center transition-transform duration-300"
                                        :class="open ? 'rotate-45' : 'rotate-0'"
                                        style="background: var(--gradient-brand)"
                                        aria-hidden="true"
                                    >
                                        <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </span>
                                </button>
                                <div
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                >
                                    <div class="px-6 pb-6 bg-surface border-t border-border">
                                        <p class="pt-5 text-sm text-text-muted leading-relaxed">{{ $a }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </x-reveal>
            @endif

        </div>
    </x-container>
</section>

{{-- ── CTA ───────────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto">
                <h2 class="font-heading font-bold text-3xl text-indigo-ink">Still have questions?</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    We're happy to answer anything specific to your project — no pressure, no sales pitch.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Ask us directly</x-button-primary>
                    <x-button-secondary href="{{ route('services.index') }}">View our services</x-button-secondary>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

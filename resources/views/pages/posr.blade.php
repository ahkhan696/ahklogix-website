<x-layouts.app
    title="POSR — Point of Sale for Restaurants"
    description="POSR is a purpose-built POS system for restaurants — order management, table tracking, kitchen display, and real-time reporting, all in one.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-24 bg-bg border-b border-border overflow-hidden">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <x-reveal>
                <div>
                    {{-- Product badge --}}
                    <div class="inline-flex items-center gap-2 rounded-full border border-violet/30 bg-violet/5 px-4 py-1.5 mb-6">
                        <span class="w-2 h-2 rounded-full bg-violet"></span>
                        <span class="text-xs font-semibold text-violet">Product by AHKLOGIX</span>
                    </div>

                    <h1 class="font-heading font-bold text-5xl lg:text-6xl text-indigo-ink leading-tight">
                        A POS built the way restaurants actually work
                    </h1>
                    <p class="mt-6 text-lg text-text-muted leading-relaxed">
                        POSR handles orders, tables, the kitchen display, and live reporting — all in one system designed for the speed of real service.
                    </p>
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <x-button-primary href="{{ route('contact') }}">Book a demo</x-button-primary>
                        <x-button-secondary href="#features">See the features</x-button-secondary>
                    </div>
                </div>
            </x-reveal>

            {{-- CSS mockup --}}
            <x-reveal :delay="120">
                <div class="relative">
                    {{-- Screen frame --}}
                    <div class="rounded-2xl border border-border shadow-2xl overflow-hidden bg-white">
                        {{-- Topbar --}}
                        <div class="flex items-center justify-between px-5 py-3 border-b border-border bg-surface">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-magenta"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-brand/60"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-violet/40"></div>
                            </div>
                            <span class="text-xs font-semibold text-text-muted">POSR · Table View</span>
                            <div class="text-xs text-text-muted">19:42</div>
                        </div>

                        {{-- Sidebar + content --}}
                        <div class="flex h-64">
                            {{-- Sidebar nav --}}
                            <div class="w-12 bg-indigo-ink flex flex-col items-center py-4 gap-4 flex-shrink-0">
                                @foreach(['squares-2x2', 'list-bullet', 'chart-bar', 'cog-6-tooth'] as $ico)
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ $loop->first ? 'bg-violet' : 'bg-white/10' }}">
                                    <x-svg-icon :name="$ico" class="w-3.5 h-3.5 text-white" />
                                </div>
                                @endforeach
                            </div>

                            {{-- Table grid --}}
                            <div class="flex-1 p-4 grid grid-cols-4 gap-2 content-start">
                                @foreach([
                                    ['T1', 'occupied', '3 items'],
                                    ['T2', 'occupied', '7 items'],
                                    ['T3', 'free', ''],
                                    ['T4', 'occupied', '2 items'],
                                    ['T5', 'free', ''],
                                    ['T6', 'occupied', '5 items'],
                                    ['T7', 'free', ''],
                                    ['T8', 'occupied', '1 item'],
                                ] as [$label, $state, $info])
                                <div class="rounded-xl border p-2.5 flex flex-col gap-1
                                    {{ $state === 'occupied'
                                        ? 'border-violet/40 bg-violet/5'
                                        : 'border-border bg-surface' }}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold {{ $state === 'occupied' ? 'text-violet' : 'text-text-muted' }}">{{ $label }}</span>
                                        <span class="w-1.5 h-1.5 rounded-full {{ $state === 'occupied' ? 'bg-violet' : 'bg-border' }}"></span>
                                    </div>
                                    @if($info)
                                    <span class="text-[9px] text-text-muted">{{ $info }}</span>
                                    @else
                                    <span class="text-[9px] text-border">Available</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            {{-- Order panel --}}
                            <div class="w-28 border-l border-border bg-surface flex flex-col p-3">
                                <p class="text-[10px] font-semibold text-indigo-ink mb-2">Order · T2</p>
                                <div class="flex flex-col gap-1.5 flex-1">
                                    @foreach(['Margherita', 'Garlic bread', 'Coke ×2', 'Tiramisu', 'House wine', 'Latte', 'Risotto'] as $item)
                                    <div class="flex items-center justify-between">
                                        <span class="text-[9px] text-text-muted truncate">{{ $item }}</span>
                                        <span class="text-[9px] text-indigo-ink font-medium">${{ rand(6,24) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="border-t border-border pt-2 mt-2">
                                    <div class="flex justify-between">
                                        <span class="text-[10px] font-bold text-indigo-ink">Total</span>
                                        <span class="text-[10px] font-bold text-violet">$98</span>
                                    </div>
                                    <div class="mt-2 rounded-lg py-1.5 text-center text-[9px] font-bold text-white" style="background: var(--gradient-brand)">Charge</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating stat cards --}}
                    <div class="absolute -bottom-4 -left-4 rounded-xl border border-border bg-white shadow-lg p-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: var(--gradient-brand)">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-text-muted">Revenue today</p>
                            <p class="text-sm font-bold text-indigo-ink">$3,241</p>
                        </div>
                    </div>

                    <div class="absolute -top-4 -right-4 rounded-xl border border-border bg-white shadow-lg p-3 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-50">
                            <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-text-muted">Orders served</p>
                            <p class="text-sm font-bold text-indigo-ink">47 today</p>
                        </div>
                    </div>
                </div>
            </x-reveal>
        </div>
    </x-container>
</section>

{{-- ── Features ─────────────────────────────────────────────────────────────── --}}
<section id="features" class="py-24 bg-bg">
    <x-container>
        <x-reveal>
            <div class="text-center max-w-2xl mx-auto mb-16">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Features</p>
                <h2 class="font-heading font-bold text-4xl text-indigo-ink">Every tool your floor needs</h2>
                <p class="mt-4 text-text-muted leading-relaxed">
                    Built with real restaurant operators, not theoretical workflows. POSR cuts the friction between taking an order and getting paid.
                </p>
            </div>
        </x-reveal>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['table-cells', 'Table management', 'See every table at a glance. Merge, split, reassign in seconds — no juggling paper floor plans.'],
                ['clipboard-document-list', 'Order taking', 'Fast item search, modifier groups, quantity adjustments, and special notes — all touchscreen-native.'],
                ['fire', 'Kitchen display', 'Orders hit the KDS the moment they\'re placed. Cooks see status, elapsed time, and course sequences.'],
                ['credit-card', 'Payment & split billing', 'Card, cash, or split any way — by seat, by item, or custom amount. Stripe and Square ready.'],
                ['chart-bar', 'Live reporting', 'Revenue, average cover, item performance, and hourly trends — refreshed in real time, no spreadsheets.'],
                ['swatch', 'Menu builder', 'Add, price, and 86 items from any device. Seasonal menus, categories, and modifier stacks — all yours to own.'],
            ] as [$icon, $title, $desc])
            <x-reveal :delay="$loop->index % 3 * 70">
                <div class="card-hover rounded-2xl border border-border bg-bg p-7 h-full">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5" style="background: var(--gradient-brand)">
                        <x-svg-icon :name="$icon" class="w-5 h-5 text-white" />
                    </div>
                    <h3 class="font-heading font-semibold text-base text-indigo-ink mb-2">{{ $title }}</h3>
                    <p class="text-sm text-text-muted leading-relaxed">{{ $desc }}</p>
                </div>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>

{{-- ── Who it's for ─────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-surface border-t border-border">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <x-reveal>
                <div>
                    <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-4">Who it's for</p>
                    <h2 class="font-heading font-bold text-4xl text-indigo-ink leading-tight">
                        Designed for restaurants that can't afford downtime
                    </h2>
                    <p class="mt-5 text-text-muted leading-relaxed">
                        POSR is built for independent and small-chain restaurants that need reliable, fast technology without enterprise price tags or month-long implementations.
                    </p>
                    <div class="mt-8 space-y-4">
                        @foreach([
                            ['Fine dining & bistros', 'Elegant table management and per-seat billing that matches your service style.'],
                            ['Fast-casual & QSR', 'Speed-first order taking, counter mode, and quick-pay flows built for volume.'],
                            ['Cafes & coffee shops', 'Item modifiers, loyalty tracking, and quick payment — from espresso to large orders.'],
                            ['Food trucks & pop-ups', 'Lightweight, works offline, syncs when you\'re back online. No fixed installation.'],
                        ] as [$who, $detail])
                        <div class="flex items-start gap-3">
                            <span class="mt-1 w-5 h-5 flex-shrink-0 rounded-full flex items-center justify-center" style="background: var(--gradient-brand)">
                                <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-indigo-ink">{{ $who }}</p>
                                <p class="text-xs text-text-muted mt-0.5 leading-relaxed">{{ $detail }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-reveal>

            {{-- Kitchen display mockup --}}
            <x-reveal :delay="100">
                <div class="rounded-2xl border border-border overflow-hidden shadow-xl bg-indigo-ink">
                    <div class="flex items-center justify-between px-5 py-3 border-b border-white/10">
                        <span class="text-xs font-semibold text-white/70">Kitchen Display · 19:44</span>
                        <span class="text-xs text-emerald-400 font-semibold">● Live</span>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        @foreach([
                            ['T2', 'New', '3:12', ['Margherita (extra basil)', 'Garlic bread ×2', 'Tiramisu'], '#7C3AED'],
                            ['T6', 'Cooking', '7:48', ['Risotto (no parsley)', 'House red wine', 'Seafood pasta', 'Panna cotta'], '#EC1FC4'],
                            ['T4', 'Ready', '12:05', ['Chicken salad', 'Lemonade'], '#10b981'],
                            ['T1', 'Cooking', '4:30', ['Cheeseburger', 'Fries', 'Milkshake'], '#2E8BE6'],
                        ] as [$table, $status, $elapsed, $items, $color])
                        <div class="rounded-xl border p-3 flex flex-col gap-2" style="border-color: {{ $color }}33; background: {{ $color }}11">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-white">{{ $table }}</span>
                                <span class="text-[10px] font-semibold rounded-full px-2 py-0.5" style="background: {{ $color }}33; color: {{ $color }}">{{ $status }}</span>
                            </div>
                            <p class="text-[9px] text-white/40">{{ $elapsed }} elapsed</p>
                            <ul class="space-y-1">
                                @foreach($items as $item)
                                <li class="text-[10px] text-white/80 leading-tight">— {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-reveal>
        </div>
    </x-container>
</section>

{{-- ── Stats ─────────────────────────────────────────────────────────────────── --}}
<section class="py-20 bg-bg border-t border-border">
    <x-container>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            @foreach([
                ['< 2s', 'Average order-to-kitchen time'],
                ['99.9%', 'Uptime SLA'],
                ['30 min', 'Typical staff onboarding'],
                ['Zero', 'Monthly fee for the first restaurant'],
            ] as [$stat, $label])
            <x-reveal :delay="$loop->index * 80">
                <div>
                    <p class="font-heading font-bold text-4xl text-indigo-ink" style="-webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; background-image: var(--gradient-brand)">{{ $stat }}</p>
                    <p class="mt-2 text-sm text-text-muted">{{ $label }}</p>
                </div>
            </x-reveal>
            @endforeach
        </div>
    </x-container>
</section>

{{-- ── CTA ───────────────────────────────────────────────────────────────────── --}}
<section class="py-24 bg-indigo-ink relative overflow-hidden">
    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
    {{-- Subtle radial glow --}}
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse 60% 60% at 50% 0%, rgba(124,58,237,0.18) 0%, transparent 70%)"></div>
    <x-container>
        <x-reveal>
            <div class="text-center max-w-xl mx-auto relative">
                <h2 class="font-heading font-bold text-4xl text-white">Ready to run your floor with POSR?</h2>
                <p class="mt-4 text-white/60 leading-relaxed">
                    Book a 30-minute live demo. We'll walk you through setup, show the kitchen display live, and answer every question you have.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <x-button-primary href="{{ route('contact') }}">Book a demo</x-button-primary>
                    <a
                        href="{{ route('contact') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 focus-visible:ring-offset-2 focus-visible:ring-offset-indigo-ink"
                    >
                        Request pricing
                    </a>
                </div>
            </div>
        </x-reveal>
    </x-container>
</section>

</x-layouts.app>

<div class="space-y-8">

    {{-- ── Platform selector ─────────────────────────────────────────────────── --}}
    <div class="rounded-2xl border border-border bg-bg p-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-text-muted mb-4">Marketplace / platform</p>

        <div class="flex flex-wrap gap-2 mb-6" role="group" aria-label="Select platform">
            @foreach(['amazon' => 'Amazon', 'shopify' => 'Shopify', 'ebay' => 'eBay'] as $key => $label)
            <button
                type="button"
                wire:click="$set('platform', '{{ $key }}')"
                @if($platform === $key) wire:click.stop @endif
                class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition-all duration-150
                       {{ $platform === $key
                           ? 'text-white shadow-sm'
                           : 'border border-border bg-surface text-text-body hover:border-violet hover:text-violet' }}"
                @if($platform === $key) style="background: var(--gradient-brand)" @endif
                aria-pressed="{{ $platform === $key ? 'true' : 'false' }}"
            >
                @if($key === 'amazon')
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M.045 18.02c.072-.116.187-.124.348-.022 3.636 2.11 7.594 3.166 11.87 3.166 2.852 0 5.668-.533 8.447-1.595l.315-.14c.138-.06.234-.1.293-.13.226-.088.39-.046.525.13.12.174.086.336-.12.48-.183.122-.36.234-.53.336a20.696 20.696 0 0 1-9.842 2.499c-4.127 0-7.867-1.099-11.22-3.296-.14-.092-.21-.179-.21-.26 0-.058.04-.12.124-.167zM11.99 14.56c-1.84 0-3.7-.463-5.58-1.386-1.882-.924-3.493-2.16-4.83-3.707-.112-.13-.168-.254-.168-.37 0-.11.05-.2.15-.27l.81-.535c.177-.118.345-.138.503-.06.217.104.35.175.394.21 1.106 1.065 2.305 1.93 3.595 2.59 1.29.66 2.585.99 3.886.99 1.302 0 2.597-.33 3.887-.99 1.29-.66 2.49-1.525 3.595-2.59.044-.035.177-.106.394-.21a.523.523 0 0 1 .503.06l.81.535c.1.07.15.16.15.27 0 .116-.056.24-.168.37-1.337 1.547-2.948 2.783-4.83 3.707-1.88.923-3.74 1.385-5.58 1.385h-.02zM21.1 8.29c0-.35-.04-.703-.12-1.06a7.498 7.498 0 0 0-.332-1.015.37.37 0 0 1 .022-.338c.054-.093.14-.14.257-.14h.033l1.655.252c.225.032.366.16.42.385.046.182.064.403.054.66-.02.577-.196 1.063-.53 1.462-.113.134-.24.2-.383.2h-.064a.37.37 0 0 1-.327-.2l-.072-.148a5.2 5.2 0 0 0-.633-.058z"/></svg>
                @elseif($key === 'shopify')
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.337 23.979l7.216-1.561s-2.604-17.613-2.625-17.73c-.018-.116-.116-.193-.214-.193-.098 0-1.87-.039-1.87-.039s-1.251-1.231-1.387-1.367v20.89zm-2.492.521L12.633 0S11.4.348 10.71.541c-.038 0-.077.019-.116.019-.463-1.154-1.27-2.23-2.7-2.23h-.135C7.372-1.3 6.88-1.96 6.32-1.96c-4.166 0-6.163 5.205-6.78 7.86-.155.655-.269 1.329-.346 2.02H.9l-1.038 3.226H.9v.789c0 4.744 2.624 7.256 7.368 7.256 1.038 0 2.23-.212 3.017-.616l.905 4.92h3.654zm-7.33-9.083c-2.288-.636-3.073-2.154-3.073-4.344 0-3.303 2.038-5.842 4.847-6.44V4.71c.193.04.386.06.578.06 1.482 0 2.702-1.02 3.035-2.4h.136c.347 0 .617.116.83.309v-.039l-6.354 12.777z"/></svg>
                @else
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.248l-1.97 9.289c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.932z"/></svg>
                @endif
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- Fee override --}}
        <div class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-medium text-text-muted mb-1.5">Referral / transaction fee (%)</label>
                <div class="relative">
                    <input
                        type="number"
                        wire:model.live="feePercent"
                        step="0.1"
                        min="0"
                        max="100"
                        class="w-32 rounded-xl border border-border bg-surface px-3 py-2 pr-7 text-sm text-text-body focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                    >
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">%</span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-text-muted mb-1.5">Flat fee per sale</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">$</span>
                    <input
                        type="number"
                        wire:model.live="flatFee"
                        step="0.01"
                        min="0"
                        class="w-28 rounded-xl border border-border bg-surface pl-6 pr-3 py-2 text-sm text-text-body focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                    >
                </div>
            </div>
            <p class="text-xs text-text-muted pb-2 self-end">Edit to match your actual plan or category fees.</p>
        </div>
    </div>

    {{-- ── Product rows ───────────────────────────────────────────────────────── --}}
    <div class="space-y-4">
        @foreach($products as $i => $product)
        @php $result = $this->results[$i]; @endphp
        <div class="rounded-2xl border border-border bg-bg overflow-hidden">

            {{-- Inputs --}}
            <div class="p-6 pb-5">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-indigo-ink">
                        Product {{ $i + 1 }}
                        @if($product['name'])
                            <span class="text-text-muted font-normal"> · {{ $product['name'] }}</span>
                        @endif
                    </p>
                    @if(count($products) > 1)
                    <button
                        type="button"
                        wire:click="removeProduct({{ $i }})"
                        class="text-xs text-text-muted hover:text-red-500 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-red-400 rounded"
                        aria-label="Remove product {{ $i + 1 }}"
                    >
                        Remove ×
                    </button>
                    @endif
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="col-span-2 lg:col-span-1">
                        <label class="block text-xs font-medium text-text-muted mb-1.5">Product name <span class="text-text-muted font-normal">(optional)</span></label>
                        <input
                            type="text"
                            wire:model.live="products.{{ $i }}.name"
                            placeholder="e.g. Blue T-shirt"
                            class="w-full rounded-xl border border-border bg-surface px-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-1.5">Selling price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">$</span>
                            <input
                                type="number"
                                wire:model.live="products.{{ $i }}.selling_price"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full rounded-xl border border-border bg-surface pl-6 pr-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-1.5">Cost (COGS)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">$</span>
                            <input
                                type="number"
                                wire:model.live="products.{{ $i }}.cogs"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full rounded-xl border border-border bg-surface pl-6 pr-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-text-muted mb-1.5">Shipping cost</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-muted pointer-events-none">$</span>
                            <input
                                type="number"
                                wire:model.live="products.{{ $i }}.shipping"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full rounded-xl border border-border bg-surface pl-6 pr-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Results strip --}}
            @if($result['hasData'])
            <div class="border-t border-border bg-surface px-6 py-4">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs font-medium text-text-muted mb-0.5">Platform fees</p>
                        <p class="text-base font-semibold text-indigo-ink">${{ number_format($result['fees'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-text-muted mb-0.5">Net revenue</p>
                        <p class="text-base font-semibold {{ $result['net'] >= 0 ? 'text-indigo-ink' : 'text-red-500' }}">${{ number_format($result['net'], 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-text-muted mb-0.5">Profit</p>
                        <p class="text-lg font-bold {{ $result['profit'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $result['profit'] >= 0 ? '+' : '' }}${{ number_format($result['profit'], 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-text-muted mb-0.5">Margin</p>
                        <p class="text-lg font-bold {{ $result['margin'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $result['margin'] >= 0 ? '+' : '' }}{{ number_format($result['margin'], 1) }}%
                        </p>
                    </div>
                </div>

                {{-- Breakeven note --}}
                @if($result['breakeven'] > 0 && $result['breakeven'] > $result['price'])
                <p class="mt-3 text-xs text-red-500">
                    ⚠ Selling below breakeven. You need to charge at least <strong>${{ number_format($result['breakeven'], 2) }}</strong> to cover COGS after platform fees.
                </p>
                @elseif($result['breakeven'] > 0)
                <p class="mt-3 text-xs text-text-muted">
                    Breakeven selling price: <strong>${{ number_format($result['breakeven'], 2) }}</strong>
                    (COGS ÷ (1 − fee%))
                </p>
                @endif
            </div>
            @else
            <div class="border-t border-border bg-surface px-6 py-4">
                <p class="text-xs text-text-muted">Enter a selling price to see results.</p>
            </div>
            @endif

        </div>
        @endforeach
    </div>

    {{-- ── Add product / reset ─────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap items-center gap-3">
        @if(count($products) < 3)
        <button
            type="button"
            wire:click="addProduct"
            class="inline-flex items-center gap-2 rounded-xl border border-border bg-bg px-4 py-2 text-sm font-medium text-text-body hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Add product
        </button>
        @else
        <div class="inline-flex items-center gap-2 rounded-xl border border-border bg-surface px-4 py-2 text-sm text-text-muted cursor-default select-none">
            <svg class="w-4 h-4 text-violet" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
            3-product limit on free tier
            <a href="{{ route('customer.register') }}" class="text-violet font-semibold hover:underline underline-offset-2 ml-1">Upgrade →</a>
        </div>
        @endif

        <button
            type="button"
            wire:click="resetAll"
            wire:confirm="Reset all inputs?"
            class="text-sm text-text-muted hover:text-red-500 transition-colors duration-150 px-2 py-2 focus-visible:outline-none focus-visible:rounded"
        >
            Reset all
        </button>
    </div>

    {{-- ── Free-tier footer note ───────────────────────────────────────────────── --}}
    <div class="rounded-xl border border-border bg-surface px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-sm font-semibold text-indigo-ink">Free tier</p>
            <p class="text-xs text-text-muted mt-0.5">Up to 3 products · Amazon, Shopify & eBay defaults · Instant calculations</p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <span class="text-xs text-text-muted">Pro: saved scenarios, multi-marketplace comparison, Excel export</span>
            <a
                href="{{ route('customer.register') }}"
                class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white whitespace-nowrap"
                style="background: var(--gradient-brand)"
            >
                Upgrade
            </a>
        </div>
    </div>

</div>

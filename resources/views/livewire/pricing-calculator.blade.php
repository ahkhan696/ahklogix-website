<div
    class="space-y-8"
    x-data="{
        showUpgradeModal: false,
        showScenarioSave: false,
        scenarioSaved: null,
    }"
    @pro-required.window="showUpgradeModal = true"
    @scenario-saved.window="(e) => { scenarioSaved = e.detail.name; setTimeout(() => scenarioSaved = null, 3000); }"
>

{{-- ── Pro upgrade modal ────────────────────────────────────────────────────── --}}
<div
    x-show="showUpgradeModal"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4"
    style="display: none"
    @click.self="showUpgradeModal = false"
    role="dialog"
    aria-modal="true"
    aria-label="Pro feature required"
>
    <div class="absolute inset-0 bg-indigo-ink/20 backdrop-blur-sm"></div>
    <div
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="relative z-10 w-full max-w-sm rounded-2xl border border-border bg-bg p-6 shadow-xl"
    >
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--gradient-brand)">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.006Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-semibold text-indigo-ink" style="font-family: var(--font-heading);">Pro feature</h3>
                <p class="text-sm text-text-muted mt-1">This feature is included in AHKLOGIX Pro — saved scenarios, unlimited products, multi-platform comparison, and CSV export.</p>
                <div class="mt-4 flex items-center gap-3">
                    @if($isGuest)
                        <a
                            href="{{ route('customer.register') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                            style="background: var(--gradient-brand)"
                        >
                            Create free account
                        </a>
                        <a href="{{ route('customer.login') }}" class="text-sm font-medium text-violet hover:underline underline-offset-2">Sign in</a>
                    @else
                        <a
                            href="{{ route('customer.account') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                            style="background: var(--gradient-brand)"
                        >
                            Upgrade to Pro
                        </a>
                    @endif
                    <button
                        type="button"
                        @click="showUpgradeModal = false"
                        class="text-sm text-text-muted hover:text-text-body transition-colors duration-150 focus-visible:outline-none"
                    >
                        Dismiss
                    </button>
                </div>
            </div>
            <button
                type="button"
                @click="showUpgradeModal = false"
                class="flex-shrink-0 text-text-muted hover:text-indigo-ink transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-violet rounded"
                aria-label="Close"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>

{{-- ── Platform selector + comparison toggle ───────────────────────────────── --}}
<div class="rounded-2xl border border-border bg-bg p-6">
    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
        <p class="text-xs font-semibold uppercase tracking-widest text-text-muted">Marketplace / platform</p>

        {{-- Comparison mode toggle (pro) --}}
        @if($isPro)
            <button
                type="button"
                wire:click="toggleComparison"
                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all duration-150 {{ $comparisonMode ? 'text-white shadow-sm' : 'border border-border bg-surface text-text-muted hover:border-violet hover:text-violet' }}"
                @if($comparisonMode) style="background: var(--gradient-brand)" @endif
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h18M3 18h18"/>
                </svg>
                Compare all platforms
            </button>
        @else
            @if(config('billing.enabled'))
                <button
                    type="button"
                    @click="showUpgradeModal = true"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-border bg-surface px-3 py-1.5 text-xs font-semibold text-text-muted opacity-60 cursor-pointer hover:opacity-80 transition-opacity duration-150"
                    title="Pro feature"
                >
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
                    Compare all platforms
                </button>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-lg border border-violet/30 bg-violet/5 px-3 py-1.5 text-xs font-semibold text-violet">
                    Free during beta
                </span>
            @endif
        @endif
    </div>

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

{{-- ── Product rows ───────────────────────────────────────────────────────────── --}}
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

        {{-- Results strip — single platform --}}
        @if(! $comparisonMode)
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

                @if($result['breakeven'] > 0 && $result['breakeven'] > $result['price'])
                <p class="mt-3 text-xs text-red-500">
                    ⚠ Selling below breakeven. You need to charge at least <strong>${{ number_format($result['breakeven'], 2) }}</strong> to cover COGS after platform fees.
                </p>
                @elseif($result['breakeven'] > 0)
                <p class="mt-3 text-xs text-text-muted">
                    Breakeven selling price: <strong>${{ number_format($result['breakeven'], 2) }}</strong>
                    (COGS + shipping ÷ (1 − fee%))
                </p>
                @endif
            </div>
            @else
            <div class="border-t border-border bg-surface px-6 py-4">
                <p class="text-xs text-text-muted">Enter a selling price to see results.</p>
            </div>
            @endif

        {{-- Results strip — comparison mode (pro) --}}
        @else
            @php $compData = $this->comparison; @endphp
            @if($result['hasData'])
            <div class="border-t border-border bg-surface px-6 py-4 overflow-x-auto">
                <table class="w-full text-sm min-w-[420px]">
                    <thead>
                        <tr>
                            <th class="text-left text-xs font-medium text-text-muted pb-3 pr-4 w-28"></th>
                            @foreach($compData as $plt)
                            <th class="text-right text-xs font-semibold text-indigo-ink pb-3 pr-4">{{ $plt['label'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach([
                            ['key' => 'fees',   'label' => 'Platform fees', 'prefix' => '$', 'suffix' => ''],
                            ['key' => 'net',    'label' => 'Net revenue',   'prefix' => '$', 'suffix' => ''],
                            ['key' => 'profit', 'label' => 'Profit',        'prefix' => '$', 'suffix' => ''],
                            ['key' => 'margin', 'label' => 'Margin',        'prefix' => '',  'suffix' => '%'],
                        ] as $row)
                        <tr>
                            <td class="text-xs font-medium text-text-muted py-2 pr-4">{{ $row['label'] }}</td>
                            @foreach($compData as $plt)
                            @php $r = $plt['rows'][$i]; @endphp
                            <td class="text-right py-2 pr-4 font-semibold
                                {{ in_array($row['key'], ['profit','margin'])
                                    ? ($r[$row['key']] >= 0 ? 'text-emerald-600' : 'text-red-500')
                                    : ($row['key'] === 'net' && $r['net'] < 0 ? 'text-red-500' : 'text-indigo-ink') }}">
                                @if($r['hasData'])
                                    {{ $row['prefix'] }}{{ number_format($r[$row['key']], $row['key'] === 'margin' ? 1 : 2) }}{{ $row['suffix'] }}
                                @else
                                    <span class="text-text-muted font-normal">—</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="border-t border-border bg-surface px-6 py-4">
                <p class="text-xs text-text-muted">Enter a selling price to see comparison.</p>
            </div>
            @endif
        @endif

    </div>
    @endforeach
</div>

{{-- ── Add product / actions bar ───────────────────────────────────────────── --}}
<div class="flex flex-wrap items-center gap-3">

    {{-- Add product --}}
    @if($isPro ? count($products) < 20 : count($products) < 3)
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
    @elseif(! $isPro)
    <div class="inline-flex items-center gap-2 rounded-xl border border-border bg-surface px-4 py-2 text-sm text-text-muted cursor-default select-none">
        <svg class="w-4 h-4 text-violet" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
        3-product limit on free tier
        @if(config('billing.enabled'))
            <button type="button" @click="showUpgradeModal = true" class="text-violet font-semibold hover:underline underline-offset-2 ml-1 focus-visible:outline-none">Upgrade →</button>
        @else
            <span class="text-violet font-semibold ml-1">Free during beta</span>
        @endif
    </div>
    @endif

    {{-- Export CSV (pro) --}}
    @if($isPro)
    <button
        type="button"
        wire:click="exportCsv"
        class="inline-flex items-center gap-2 rounded-xl border border-border bg-bg px-4 py-2 text-sm font-medium text-text-body hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Export CSV
    </button>

    {{-- Print / PDF --}}
    <button
        type="button"
        onclick="window.print()"
        class="inline-flex items-center gap-2 rounded-xl border border-border bg-bg px-4 py-2 text-sm font-medium text-text-body hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
        </svg>
        Print / PDF
    </button>
    @else
    {{-- Locked export hint (free tier) --}}
    @if(config('billing.enabled'))
    <button
        type="button"
        @click="showUpgradeModal = true"
        class="inline-flex items-center gap-2 rounded-xl border border-border bg-surface px-4 py-2 text-sm font-medium text-text-muted opacity-60 hover:opacity-80 transition-opacity duration-150 focus-visible:outline-none"
        title="Pro feature — Export CSV"
    >
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
        Export CSV
    </button>
    @endif
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

{{-- ── Saved scenarios (pro) ──────────────────────────────────────────────── --}}
@if($isPro)
<div class="rounded-2xl border border-border bg-bg overflow-hidden">
    <div class="px-6 py-4 border-b border-border flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
            </svg>
            <p class="text-sm font-semibold text-indigo-ink">Saved scenarios</p>
        </div>

        <button
            type="button"
            x-on:click="showScenarioSave = !showScenarioSave"
            class="inline-flex items-center gap-1.5 rounded-xl border border-violet/30 px-3 py-1.5 text-xs font-semibold text-violet hover:bg-violet/5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
        >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Save current
        </button>
    </div>

    {{-- Save scenario form --}}
    <div x-show="showScenarioSave" x-collapse class="border-b border-border bg-surface px-6 py-4">
        <div class="flex items-center gap-3">
            <input
                type="text"
                wire:model="scenarioName"
                placeholder="Scenario name (optional)"
                class="flex-1 rounded-xl border border-border bg-bg px-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                @keydown.enter="$wire.saveScenario(); showScenarioSave = false"
            >
            <button
                type="button"
                wire:click="saveScenario"
                @click="showScenarioSave = false"
                class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                style="background: var(--gradient-brand)"
            >
                Save
            </button>
        </div>
    </div>

    {{-- Save confirmation toast --}}
    <div
        x-show="scenarioSaved !== null"
        x-transition.opacity
        class="border-b border-emerald-100 bg-emerald-50 px-6 py-3"
        style="display: none"
    >
        <p class="text-xs font-medium text-emerald-700">Saved "<span x-text="scenarioSaved"></span>"</p>
    </div>

    {{-- Scenario list --}}
    @php $scenarios = $this->scenarios; @endphp
    @if(count($scenarios) > 0)
    <ul class="divide-y divide-border">
        @foreach($scenarios as $scenario)
        <li class="flex items-center justify-between gap-4 px-6 py-3 hover:bg-surface transition-colors duration-100">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-indigo-ink truncate">{{ $scenario['name'] }}</p>
                <p class="text-xs text-text-muted">
                    {{ ucfirst($scenario['platform']) }} ·
                    {{ count($scenario['products']) }} product{{ count($scenario['products']) !== 1 ? 's' : '' }} ·
                    {{ \Carbon\Carbon::parse($scenario['created_at'])->diffForHumans() }}
                </p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button
                    type="button"
                    wire:click="loadScenario({{ $scenario['id'] }})"
                    class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-text-body hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-violet"
                >
                    Load
                </button>
                <button
                    type="button"
                    wire:click="deleteScenario({{ $scenario['id'] }})"
                    wire:confirm="Delete '{{ $scenario['name'] }}'?"
                    class="rounded-lg border border-border px-3 py-1.5 text-xs font-medium text-text-muted hover:border-red-300 hover:text-red-500 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-red-400"
                >
                    Delete
                </button>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <div class="px-6 py-8 text-center">
        <p class="text-sm text-text-muted">No saved scenarios yet. Set up your inputs and hit <strong>Save current</strong>.</p>
    </div>
    @endif
</div>

@else
{{-- Locked scenarios panel (free tier) --}}
<div class="rounded-2xl border border-border bg-bg overflow-hidden">
    <div class="px-6 py-5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-text-muted" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-indigo-ink">Saved scenarios</p>
                <p class="text-xs text-text-muted mt-0.5">Save unlimited setups and reload them in one click.</p>
            </div>
        </div>
        @if(config('billing.enabled'))
            <button
                type="button"
                @click="showUpgradeModal = true"
                class="flex-shrink-0 inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                style="background: var(--gradient-brand)"
            >
                Upgrade to Pro
            </button>
        @else
            <span class="flex-shrink-0 inline-flex items-center rounded-full border border-violet/30 bg-violet/5 px-3 py-1 text-xs font-semibold text-violet">
                Free during beta
            </span>
        @endif
    </div>
</div>
@endif

{{-- ── Footer note ─────────────────────────────────────────────────────────── --}}
<div class="rounded-xl border border-border bg-surface px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    @if($isPro)
    <div>
        <div class="flex items-center gap-1.5 mb-0.5">
            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold text-white" style="background: var(--gradient-brand)">
                <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.006Z" clip-rule="evenodd"/></svg>
                Pro
            </span>
            <p class="text-sm font-semibold text-indigo-ink">All features unlocked</p>
        </div>
        <p class="text-xs text-text-muted">Unlimited products · Saved scenarios · Multi-platform comparison · CSV export</p>
    </div>
    <a
        href="{{ route('customer.account') }}"
        class="inline-flex items-center gap-1.5 text-sm font-medium text-text-muted hover:text-violet transition-colors duration-150 flex-shrink-0"
    >
        Manage billing →
    </a>
    @elseif(! config('billing.enabled'))
    <div>
        <div class="flex items-center gap-1.5 mb-0.5">
            <span class="inline-flex items-center rounded-full border border-violet/30 bg-violet/5 px-2 py-0.5 text-xs font-semibold text-violet">Free during beta</span>
            <p class="text-sm font-semibold text-indigo-ink">All features available</p>
        </div>
        <p class="text-xs text-text-muted">Pro features will require a subscription when billing launches.</p>
    </div>
    @else
    <div>
        <p class="text-sm font-semibold text-indigo-ink">Free tier</p>
        <p class="text-xs text-text-muted mt-0.5">Up to 3 products · Amazon, Shopify & eBay defaults · Instant calculations</p>
    </div>
    <div class="flex items-center gap-3 flex-shrink-0">
        <span class="text-xs text-text-muted">Pro: saved scenarios, multi-platform comparison, CSV export</span>
        <a
            href="{{ $isGuest ? route('customer.register') : route('customer.account') }}"
            class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm font-semibold text-white whitespace-nowrap"
            style="background: var(--gradient-brand)"
        >
            Upgrade
        </a>
    </div>
    @endif
</div>

{{-- Print styles --}}
<style>
@media print {
    header, footer, nav, .no-print { display: none !important; }
    body { background: white; }
}
</style>

</div>

<x-layouts.app
    title="My account — AHKLOGIX"
    description="Manage your AHKLOGIX account and apps.">

{{-- ── Account header ───────────────────────────────────────────────────────── --}}
<section class="pt-14 pb-10 bg-bg border-b border-border">
    <x-container>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-violet mb-1">My account</p>
                <h1 class="text-3xl font-semibold text-indigo-ink" style="font-family: var(--font-heading);">
                    Welcome, {{ $customer->name }}
                </h1>
                <p class="mt-1 text-sm text-text-muted">{{ $customer->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($isSubscribed)
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold text-white" style="background: var(--gradient-brand)">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.006Z" clip-rule="evenodd"/>
                        </svg>
                        Pro
                    </span>
                @elseif(! $billingEnabled)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-violet/30 bg-violet/5 px-3 py-1 text-xs font-semibold text-violet">
                        Free during beta
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-border bg-surface px-3 py-1 text-xs font-semibold text-text-muted">
                        <span class="w-1.5 h-1.5 rounded-full bg-text-muted inline-block"></span>
                        Free plan
                    </span>
                @endif
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-xl border border-border px-4 py-2 text-sm font-medium text-text-muted hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                    >
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </x-container>
</section>

{{-- ── Flash messages ────────────────────────────────────────────────────────── --}}
@if(request('checkout') === 'success')
<div class="bg-emerald-50 border-b border-emerald-200" role="alert">
    <x-container>
        <div class="flex items-center gap-3 py-3">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-emerald-800">Payment received — your Pro plan will activate shortly. Refresh in a moment if you don't see it yet.</p>
        </div>
    </x-container>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-b border-red-200" role="alert">
    <x-container>
        <div class="flex items-center gap-3 py-3">
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </x-container>
</div>
@endif

{{-- ── Dashboard shell ─────────────────────────────────────────────────────── --}}
<section class="py-14 bg-surface">
    <x-container>

        {{-- Apps --}}
        <div class="mb-10">
            <h2 class="text-lg font-semibold text-indigo-ink mb-1" style="font-family: var(--font-heading);">Your apps</h2>
            <p class="text-sm text-text-muted mb-6">Apps you have access to will appear here.</p>
            <div class="rounded-2xl border border-dashed border-border bg-bg p-12 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-surface border border-border mb-4">
                    <svg class="w-5 h-5 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-indigo-ink">Apps coming soon</p>
                <p class="text-xs text-text-muted mt-1">Browse available apps on the <a href="{{ route('apps.index') }}" class="text-violet hover:underline underline-offset-2">apps page</a>.</p>
            </div>
        </div>

        {{-- Billing --}}
        <div>
            <h2 class="text-lg font-semibold text-indigo-ink mb-1" style="font-family: var(--font-heading);">Billing</h2>

            @if(! $billingEnabled)
                {{-- ── Beta mode — billing not yet active ───────────────────── --}}
                <p class="text-sm text-text-muted mb-6">All features are free during the beta period.</p>
                <div class="rounded-2xl border border-violet/20 bg-bg p-6 relative overflow-hidden">
                    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center rounded-full border border-violet/30 bg-violet/5 px-2.5 py-0.5 text-xs font-semibold text-violet">Free during beta</span>
                                <span class="text-sm font-semibold text-indigo-ink">All pro features unlocked</span>
                            </div>
                            <p class="text-xs text-text-muted">Billing will activate when the platform is ready. No card required now.</p>
                        </div>
                        <a
                            href="{{ route('apps.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-border px-4 py-2 text-sm font-medium text-text-muted hover:border-violet hover:text-violet transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                        >
                            Browse apps
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            @elseif($isSubscribed)
                {{-- ── Active subscriber ─────────────────────────────────── --}}
                <p class="text-sm text-text-muted mb-6">Your current plan and billing details.</p>
                <div class="rounded-2xl border border-violet/20 bg-bg p-6 relative overflow-hidden">
                    <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold text-white" style="background: var(--gradient-brand)">Pro</span>
                                <span class="text-sm font-semibold text-indigo-ink">AHKLOGIX Pro</span>
                            </div>
                            @if($subscription && $subscription->ends_at)
                                <p class="text-xs text-text-muted">Cancels on {{ $subscription->ends_at->format('M j, Y') }}</p>
                            @elseif($subscription && $subscription->status === 'active')
                                <p class="text-xs text-text-muted">Active</p>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('customer.billing-portal') }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl border border-violet/30 px-4 py-2 text-sm font-medium text-violet hover:bg-violet/5 transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                            >
                                Manage billing
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- ── Free plan — upgrade CTA ───────────────────────────── --}}
                <p class="text-sm text-text-muted mb-6">Upgrade to Pro to unlock saved scenarios, exports, and more.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Monthly --}}
                    <div class="rounded-2xl border border-border bg-bg p-6 flex flex-col">
                        <p class="text-xs font-semibold uppercase tracking-widest text-text-muted mb-3">Monthly</p>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="text-3xl font-bold text-indigo-ink" style="font-family: var(--font-heading);">$9</span>
                            <span class="text-sm text-text-muted">/month</span>
                        </div>
                        <ul class="space-y-2 mb-6 flex-1">
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                Saved scenarios & history
                            </li>
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                Multi-marketplace comparison
                            </li>
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                Export to CSV / PDF
                            </li>
                        </ul>
                        @if($checkoutMonthly)
                            <x-paddle-button
                                :checkout="$checkoutMonthly"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition-opacity hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                                style="background: var(--gradient-brand)"
                            >
                                Upgrade — $9/mo
                            </x-paddle-button>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold text-white opacity-40 cursor-not-allowed" style="background: var(--gradient-brand)">
                                Coming soon
                            </button>
                        @endif
                    </div>

                    {{-- Yearly --}}
                    <div class="rounded-2xl border border-violet/20 bg-bg p-6 flex flex-col relative overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-0.5" style="background: var(--gradient-brand)" aria-hidden="true"></div>
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold uppercase tracking-widest text-text-muted">Yearly</p>
                            <span class="inline-flex items-center rounded-full bg-violet/10 px-2.5 py-0.5 text-[10px] font-semibold text-violet uppercase tracking-wide">Save 27%</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="text-3xl font-bold text-indigo-ink" style="font-family: var(--font-heading);">$79</span>
                            <span class="text-sm text-text-muted">/year</span>
                        </div>
                        <ul class="space-y-2 mb-6 flex-1">
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                Everything in Monthly
                            </li>
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                2 months free
                            </li>
                            <li class="flex items-center gap-2 text-sm text-text-body">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                Priority support
                            </li>
                        </ul>
                        @if($checkoutYearly)
                            <x-paddle-button
                                :checkout="$checkoutYearly"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition-opacity hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
                                style="background: var(--gradient-brand)"
                            >
                                Upgrade — $79/yr
                            </x-paddle-button>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold text-white opacity-40 cursor-not-allowed" style="background: var(--gradient-brand)">
                                Coming soon
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </x-container>
</section>

{{-- Paddle.js — only loaded when billing is active --}}
@if($billingEnabled)
    @paddleJS
@endif

</x-layouts.app>

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
                    Welcome, {{ Auth::guard('customer')->user()->name }}
                </h1>
                <p class="mt-1 text-sm text-text-muted">{{ Auth::guard('customer')->user()->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Plan badge — updated in Phase S4/S5 --}}
                <span class="inline-flex items-center gap-1.5 rounded-full border border-border bg-surface px-3 py-1 text-xs font-semibold text-text-muted">
                    <span class="w-1.5 h-1.5 rounded-full bg-text-muted inline-block"></span>
                    Free plan
                </span>
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

{{-- ── Dashboard shell ─────────────────────────────────────────────────────── --}}
<section class="py-14 bg-surface">
    <x-container>

        {{-- Apps placeholder — populated in Phase S2 --}}
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
                <p class="text-xs text-text-muted mt-1">Browse available apps on the <a href="/apps" class="text-violet hover:underline underline-offset-2">/apps</a> page.</p>
            </div>
        </div>

        {{-- Billing placeholder — populated in Phase S4 --}}
        <div>
            <h2 class="text-lg font-semibold text-indigo-ink mb-1" style="font-family: var(--font-heading);">Billing</h2>
            <p class="text-sm text-text-muted mb-6">Subscription and billing details will appear here after upgrading.</p>
            <div class="rounded-2xl border border-border bg-bg p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-indigo-ink">Free plan</p>
                    <p class="text-xs text-text-muted mt-0.5">Access to free-tier features across all apps.</p>
                </div>
                {{-- Upgrade CTA — wired in Phase S4 --}}
                <button
                    disabled
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white opacity-40 cursor-not-allowed"
                    style="background: var(--gradient-brand)"
                    title="Coming soon"
                >
                    Upgrade to Pro
                </button>
            </div>
        </div>

    </x-container>
</section>

</x-layouts.app>

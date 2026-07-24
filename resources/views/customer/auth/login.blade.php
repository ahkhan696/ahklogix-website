<x-layouts.app
    title="Sign in — AHKLOGIX"
    description="Sign in to your AHKLOGIX account.">

<section class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-16 bg-surface">
    <div class="w-full max-w-md mx-auto px-4">

        {{-- Card --}}
        <div class="bg-bg rounded-2xl border border-border shadow-sm p-8">

            {{-- Logo + heading --}}
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl mb-4"
                     style="background: var(--gradient-brand)">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold text-indigo-ink" style="font-family: var(--font-heading);">
                    Welcome back
                </h1>
                <p class="mt-1 text-sm text-text-muted">
                    No account yet?
                    <a href="{{ route('customer.register') }}" class="text-violet hover:underline underline-offset-2">Create one free</a>
                </p>
            </div>

            {{-- Status message (e.g. after password reset) --}}
            @if (session('status'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('customer.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-indigo-ink mb-1.5">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full rounded-xl border border-border bg-surface px-4 py-2.5 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150 @error('email') border-red-400 @enderror"
                        placeholder="jane@company.com"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-indigo-ink mb-1.5">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-border bg-surface px-4 py-2.5 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                        placeholder="Your password"
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-text-muted cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-border text-violet focus:ring-violet"
                        >
                        Remember me
                    </label>
                </div>

                <button
                    type="submit"
                    class="btn-gradient w-full rounded-xl px-4 py-2.5 text-sm font-semibold text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    Sign in
                </button>
            </form>

        </div>

    </div>
</section>

</x-layouts.app>

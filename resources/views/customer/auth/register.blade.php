<x-layouts.app
    title="Create account — AHKLOGIX"
    description="Create your AHKLOGIX account to access apps and manage your subscription.">

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
                    Create your account
                </h1>
                <p class="mt-1 text-sm text-text-muted">
                    Already have one?
                    <a href="{{ route('customer.login') }}" class="text-violet hover:underline underline-offset-2">Sign in</a>
                </p>
            </div>

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
            <form method="POST" action="{{ route('customer.register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-indigo-ink mb-1.5">Full name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        class="w-full rounded-xl border border-border bg-surface px-4 py-2.5 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150 @error('name') border-red-400 @enderror"
                        placeholder="Jane Smith"
                    >
                </div>

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
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-border bg-surface px-4 py-2.5 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150 @error('password') border-red-400 @enderror"
                        placeholder="At least 8 characters"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-indigo-ink mb-1.5">Confirm password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-border bg-surface px-4 py-2.5 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150"
                        placeholder="Repeat password"
                    >
                </div>

                <button
                    type="submit"
                    class="btn-gradient w-full rounded-xl px-4 py-2.5 text-sm font-semibold text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                >
                    Create account
                </button>
            </form>

        </div>

        <p class="mt-6 text-center text-xs text-text-muted">
            By registering you agree to our
            <a href="/contact" class="underline underline-offset-2 hover:text-violet">terms</a>.
        </p>

    </div>
</section>

</x-layouts.app>

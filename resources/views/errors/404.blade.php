<x-layouts.app
    title="Page not found — AHKLOGIX"
    description="The page you're looking for doesn't exist. Head back home or contact us.">

<section class="min-h-[calc(100vh-73px)] flex items-center bg-bg">
    <x-container>
        <div class="max-w-lg mx-auto text-center py-24">

            {{-- Gradient 404 number --}}
            <div
                class="font-heading font-bold text-[9rem] lg:text-[12rem] leading-none select-none"
                style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"
                aria-hidden="true"
            >404</div>

            {{-- Thin accent line --}}
            <div class="h-0.5 w-16 mx-auto my-6 rounded-full" style="background: var(--gradient-brand)" aria-hidden="true"></div>

            <h1 class="font-heading font-bold text-2xl lg:text-3xl text-indigo-ink">
                Page not found
            </h1>
            <p class="mt-4 text-text-muted leading-relaxed">
                The page you're looking for doesn't exist or may have moved.
                Let's get you back on track.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <x-button-primary href="{{ route('home') }}">Back to home</x-button-primary>
                <x-button-secondary href="{{ route('contact') }}">Contact us</x-button-secondary>
            </div>

            {{-- Helpful links --}}
            <div class="mt-12 pt-8 border-t border-border">
                <p class="text-xs font-semibold text-text-muted uppercase tracking-wide mb-4">Or go directly to</p>
                <div class="flex flex-wrap justify-center gap-x-6 gap-y-2">
                    @foreach([
                        ['Services',  'services.index'],
                        ['Portfolio', 'portfolio.index'],
                        ['Blog',      'blog.index'],
                        ['About',     'about'],
                        ['FAQ',       'faq'],
                    ] as [$label, $route])
                    <a
                        href="{{ route($route) }}"
                        class="text-sm text-violet hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 rounded"
                    >{{ $label }}</a>
                    @endforeach
                </div>
            </div>

        </div>
    </x-container>
</section>

</x-layouts.app>

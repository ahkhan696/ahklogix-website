<x-layouts.app :title="$section">
    <section class="min-h-[60vh] flex items-center justify-center">
        <x-container class="py-24 text-center">
            <x-reveal>
                <p class="text-sm font-semibold text-violet tracking-wide uppercase mb-4">Coming in a future phase</p>
                <h1 class="text-4xl font-bold text-indigo-ink">{{ $section }}</h1>
                <p class="mt-4 text-text-muted max-w-sm mx-auto">This page is a route stub. Full content arrives in the corresponding build phase.</p>
                <div class="mt-8">
                    <x-button-secondary href="{{ route('home') }}">Back to home</x-button-secondary>
                </div>
            </x-reveal>
        </x-container>
    </section>
</x-layouts.app>

{{--
    Header — sticky nav with Alpine scroll-shrink (§8 item 9).
    Shrinks + gets backdrop-blur + hairline border after 50px scroll.
--}}
<header
    x-data="{ open: false, scrolled: false }"
    x-on:scroll.window="scrolled = window.scrollY > 50"
    :class="scrolled
        ? 'py-3 bg-white/90 backdrop-blur-md border-b border-border shadow-sm'
        : 'py-5 bg-white'"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
>
    <x-container class="flex items-center justify-between gap-6">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet rounded-lg" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="h-8 w-auto">
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden lg:flex items-center gap-7" aria-label="Main navigation">
            @php
                $navLinks = [
                    ['label' => 'Services',  'route' => 'services.index',   'match' => 'services*'],
                    ['label' => 'Portfolio', 'route' => 'portfolio.index',  'match' => 'portfolio*'],
                    ['label' => 'POSR',      'route' => 'posr',             'match' => 'posr'],
                    ['label' => 'Blog',      'route' => 'blog.index',       'match' => 'blog*'],
                    ['label' => 'About',     'route' => 'about',            'match' => 'about'],
                    ['label' => 'Contact',   'route' => 'contact',          'match' => 'contact'],
                ];
            @endphp

            @foreach($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="text-sm font-medium transition-colors duration-200
                           {{ request()->routeIs($link['match'])
                               ? 'text-violet'
                               : 'text-text-body hover:text-violet' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Desktop CTAs --}}
        <div class="hidden lg:flex items-center gap-3 flex-shrink-0">
            <x-book-a-call />
            <x-button-primary :href="'https://wa.me/' . config('services.whatsapp_number') . '?text=' . urlencode('Hi, I\'d like to start a project with AHKLOGIX.')">
                Start a project
            </x-button-primary>
        </div>

        {{-- Mobile hamburger --}}
        <button
            x-on:click="open = !open"
            :aria-expanded="open"
            aria-controls="mobile-nav"
            aria-label="Toggle navigation"
            class="lg:hidden p-2 rounded-lg text-text-body hover:text-violet hover:bg-surface transition-colors duration-200"
        >
            {{-- Animated hamburger → X --}}
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </x-container>

    {{-- Mobile nav drawer --}}
    <div
        id="mobile-nav"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        x-cloak
        class="lg:hidden border-t border-border bg-white"
    >
        <x-container class="py-4 flex flex-col gap-1">
            @foreach($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    x-on:click="open = false"
                    class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200
                           {{ request()->routeIs($link['match'])
                               ? 'text-violet bg-surface'
                               : 'text-text-body hover:text-violet hover:bg-surface' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="mt-4 pt-4 border-t border-border flex flex-col gap-3">
                <x-book-a-call class="w-full justify-center" />
                <x-button-primary
                    :href="'https://wa.me/' . config('services.whatsapp_number') . '?text=' . urlencode('Hi, I\'d like to start a project with AHKLOGIX.')"
                    class="w-full justify-center"
                >
                    Start a project
                </x-button-primary>
            </div>
        </x-container>
    </div>
</header>

{{-- Spacer so page content clears the fixed header --}}
<div class="h-[73px]"></div>

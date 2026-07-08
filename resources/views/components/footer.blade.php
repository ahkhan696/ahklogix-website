{{--
    Footer — dark bg-indigo-deep, mono/white logo, nav columns, contact, socials, copyright.
    Services list is static here; Phase 4 will pull from DB.
    TODO: wire email + WhatsApp to Settings table in Phase 3.
--}}
<footer class="bg-indigo-deep text-white/80">

    {{-- Main footer grid --}}
    <x-container class="py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">

            {{-- Brand column --}}
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home">
                    {{-- logo_black.png is monochrome; invert() makes it white on the dark footer --}}
                    <img
                        src="{{ asset('images/logo_black.png') }}"
                        alt="{{ config('app.name') }}"
                        class="h-10 w-auto invert"
                        width="228" height="100"
                    >
                </a>
                <p class="mt-5 text-sm leading-relaxed text-white/60 max-w-xs">
                    A software engineering studio building custom web apps, automations, and AI solutions that move businesses forward.
                </p>
                {{-- Socials --}}
                <div class="mt-6 flex items-center gap-4">
                    {{-- TODO: replace hrefs with real social URLs from Settings (Phase 3) --}}
                    <a href="#" aria-label="LinkedIn" class="text-white/50 hover:text-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter / X" class="text-white/50 hover:text-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="GitHub" class="text-white/50 hover:text-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Navigation --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-white/40 mb-5">Navigation</h3>
                <ul class="space-y-3 text-sm">
                    @foreach([
                        ['Services',  'services.index'],
                        ['Portfolio', 'portfolio.index'],
                        ['POSR',      'posr'],
                        ['Blog',      'blog.index'],
                        ['About',     'about'],
                        ['Contact',   'contact'],
                        ['FAQ',       'faq'],
                    ] as [$label, $routeName])
                    <li>
                        <a href="{{ route($routeName) }}" class="text-white/60 hover:text-white transition-colors duration-200">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-white/40 mb-5">Services</h3>
                {{-- TODO: Phase 4 replaces this with DB-driven list --}}
                <ul class="space-y-3 text-sm">
                    @foreach([
                        'Custom Web Apps',
                        'API Integration & Automation',
                        'Zoho Implementation',
                        'GoHighLevel Setup',
                        'Make.com Automation',
                        'AI Chatbots & Integration',
                        'Mobile Apps',
                        'Digital Marketing & SEO',
                    ] as $service)
                    <li>
                        <a href="{{ route('services.index') }}" class="text-white/60 hover:text-white transition-colors duration-200">
                            {{ $service }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-white/40 mb-5">Get in touch</h3>
                <ul class="space-y-4 text-sm">
                    <li>
                        {{-- TODO: wire to Settings email (Phase 3) --}}
                        <a href="mailto:{{ config('services.contact_email', 'hello@ahklogix.com') }}" class="flex items-start gap-3 text-white/60 hover:text-white transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ config('services.contact_email', 'hello@ahklogix.com') }}
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://wa.me/{{ config('services.whatsapp_number') }}?text={{ urlencode('Hi, I\'d like to start a project with AHKLOGIX.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-start gap-3 text-white/60 hover:text-white transition-colors duration-200"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.848L.054 23.764a.5.5 0 00.612.612l5.994-1.504A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.954 9.954 0 01-5.031-1.355l-.361-.214-3.741.937.955-3.665-.235-.376A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                            </svg>
                            WhatsApp
                        </a>
                    </li>
                </ul>

                <div class="mt-8">
                    <x-button-primary :href="route('contact')" class="text-sm px-5 py-2.5">
                        Start a project
                    </x-button-primary>
                </div>
            </div>

        </div>
    </x-container>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <x-container class="py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/40">
            <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            <div class="flex items-center gap-5">
                <a href="{{ route('faq') }}" class="hover:text-white/70 transition-colors duration-200">FAQ</a>
                {{-- TODO: add Privacy Policy and Terms pages in Phase 9 --}}
                <a href="#" class="hover:text-white/70 transition-colors duration-200">Privacy Policy</a>
                <a href="#" class="hover:text-white/70 transition-colors duration-200">Terms</a>
            </div>
        </x-container>
    </div>

</footer>

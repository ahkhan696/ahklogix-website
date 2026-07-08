<x-layouts.app
    title="Contact — AHKLOGIX"
    description="Get in touch with AHKLOGIX. Tell us about your project and we'll come back with a clear scope and honest timeline.">

{{-- ── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="pt-16 pb-14 bg-bg border-b border-border">
    <x-container>
        <x-reveal>
            <div class="max-w-2xl">
                <p class="text-sm font-semibold text-violet uppercase tracking-wide mb-3">Get in touch</p>
                <h1 class="font-heading font-bold text-4xl lg:text-5xl text-indigo-ink leading-tight">
                    Let's talk about<br>
                    <span style="background: var(--gradient-brand); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">your project</span>
                </h1>
                <p class="mt-5 text-lg text-text-muted leading-relaxed">
                    Tell us what you're building and we'll come back with a clear scope, honest timeline, and no sales fluff.
                </p>
            </div>
        </x-reveal>
    </x-container>
</section>

{{-- ── Main content ─────────────────────────────────────────────────────────── --}}
<section class="py-16 bg-bg">
    <x-container>
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

            {{-- ── Form (3 of 5 cols) ───────────────────────────────────────── --}}
            <div class="lg:col-span-3">
                <x-reveal>

                    {{-- Success state --}}
                    @if(session('success'))
                    <div
                        class="rounded-2xl border border-border bg-surface p-8 text-center"
                        x-data
                        x-intersect.once="$el.classList.add('animate-fade-in-up')"
                    >
                        <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-5" style="background: var(--gradient-brand)">
                            <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <h2 class="font-heading font-bold text-2xl text-indigo-ink mb-2">Message received!</h2>
                        <p class="text-text-muted leading-relaxed">
                            Thanks for reaching out. We'll review your message and get back to you within 24 hours.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-block mt-6 text-sm text-violet hover:underline">Send another message</a>
                    </div>

                    @else

                    {{-- Error summary --}}
                    @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 mb-6">
                        <p class="text-sm font-semibold text-red-700 mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                            <li class="text-sm text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form
                        action="{{ route('contact.submit') }}"
                        method="POST"
                        class="space-y-5"
                        x-data="{ submitting: false }"
                        @submit="submitting = true"
                    >
                        @csrf

                        {{-- Honeypot — invisible to humans, visible to bots --}}
                        <div style="position:absolute;left:-9999px;top:0;width:1px;height:1px;overflow:hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" value="">
                        </div>

                        {{-- Name + Email --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-indigo-ink mb-1.5">
                                    Name <span class="text-magenta" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    class="w-full rounded-xl border px-4 py-3 text-sm text-indigo-ink placeholder-text-muted bg-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet focus:ring-offset-0 focus:border-violet @error('name') border-red-400 @else border-border @enderror"
                                    placeholder="Your name"
                                >
                                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-indigo-ink mb-1.5">
                                    Email <span class="text-magenta" aria-hidden="true">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    class="w-full rounded-xl border px-4 py-3 text-sm text-indigo-ink placeholder-text-muted bg-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet focus:ring-offset-0 focus:border-violet @error('email') border-red-400 @else border-border @enderror"
                                    placeholder="you@company.com"
                                >
                                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Company --}}
                        <div>
                            <label for="company" class="block text-sm font-semibold text-indigo-ink mb-1.5">Company</label>
                            <input
                                type="text"
                                id="company"
                                name="company"
                                value="{{ old('company') }}"
                                autocomplete="organization"
                                class="w-full rounded-xl border border-border px-4 py-3 text-sm text-indigo-ink placeholder-text-muted bg-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet focus:ring-offset-0 focus:border-violet"
                                placeholder="Company or project name (optional)"
                            >
                        </div>

                        {{-- Service of interest --}}
                        <div>
                            <label for="service" class="block text-sm font-semibold text-indigo-ink mb-1.5">Service of interest</label>
                            <div class="relative">
                                <select
                                    id="service"
                                    name="service"
                                    class="w-full rounded-xl border border-border px-4 py-3 text-sm text-indigo-ink bg-white appearance-none transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet focus:ring-offset-0 focus:border-violet"
                                >
                                    <option value="">Select a service (optional)</option>
                                    @foreach($services as $svc)
                                    <option value="{{ $svc }}" {{ old('service') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                                    @endforeach
                                    <option value="Other" {{ old('service') === 'Other' ? 'selected' : '' }}>Other / Not sure yet</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center" aria-hidden="true">
                                    <svg class="w-4 h-4 text-text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-semibold text-indigo-ink mb-1.5">
                                Message <span class="text-magenta" aria-hidden="true">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                required
                                class="w-full rounded-xl border px-4 py-3 text-sm text-indigo-ink placeholder-text-muted bg-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet focus:ring-offset-0 focus:border-violet resize-y @error('message') border-red-400 @else border-border @enderror"
                                placeholder="Tell us about your project — what you're building, what problem it solves, where you're at, and what help you need."
                            >{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button
                                type="submit"
                                :disabled="submitting"
                                class="inline-flex items-center gap-2 rounded-xl px-7 py-3.5 text-sm font-semibold text-white transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed"
                                style="background: var(--gradient-brand)"
                                x-bind:style="submitting ? 'opacity:0.7' : ''"
                            >
                                <span x-show="!submitting">Send message</span>
                                <span x-show="submitting" x-cloak>Sending…</span>
                                <svg x-show="!submitting" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                                </svg>
                            </button>
                            <p class="mt-3 text-xs text-text-muted">
                                We typically respond within 24 hours. No spam — your info stays private.
                            </p>
                        </div>
                    </form>
                    @endif

                </x-reveal>
            </div>

            {{-- ── Sidebar (2 of 5 cols) ────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- WhatsApp --}}
                <x-reveal :delay="80">
                    <div class="rounded-2xl border border-border bg-surface p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: #25D366">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.853L.057 23.885a.5.5 0 0 0 .612.612l6.032-1.475A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.876 9.876 0 0 1-5.031-1.377l-.36-.214-3.733.913.934-3.617-.235-.373A9.838 9.838 0 0 1 2.118 12C2.118 6.54 6.54 2.118 12 2.118S21.882 6.54 21.882 12 17.46 21.882 12 21.882z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-indigo-ink">Chat on WhatsApp</p>
                                <p class="text-xs text-text-muted">Fastest way to reach us</p>
                            </div>
                        </div>
                        @if($whatsapp)
                        <a
                            href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Hi AHKLOGIX, I\'d like to discuss a project.') }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-[#25D366] text-[#25D366] px-4 py-2.5 text-sm font-semibold hover:bg-[#25D366] hover:text-white transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-2"
                        >
                            Open WhatsApp
                        </a>
                        @else
                        <p class="text-xs text-text-muted italic">WhatsApp number not yet configured.</p>
                        @endif
                    </div>
                </x-reveal>

                {{-- Book a call --}}
                <x-reveal :delay="160">
                    <div class="rounded-2xl border border-border bg-surface p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--gradient-brand)">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-indigo-ink">Book a call</p>
                                <p class="text-xs text-text-muted">30-minute discovery session</p>
                            </div>
                        </div>
                        @if($bookingUrl)
                        <a
                            href="{{ $bookingUrl }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold text-white transition-opacity duration-200 hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
                            style="background: var(--gradient-brand)"
                        >
                            Pick a time
                        </a>
                        @else
                        <p class="text-xs text-text-muted italic">Booking calendar coming soon — use the form or WhatsApp in the meantime.</p>
                        @endif
                    </div>
                </x-reveal>

                {{-- Email --}}
                @if($contactEmail)
                <x-reveal :delay="240">
                    <div class="rounded-2xl border border-border bg-surface p-6">
                        <p class="text-xs font-semibold text-text-muted uppercase tracking-wide mb-3">Email us directly</p>
                        <a
                            href="mailto:{{ $contactEmail }}"
                            class="text-sm font-semibold text-violet hover:underline break-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 rounded"
                        >{{ $contactEmail }}</a>
                        <p class="mt-2 text-xs text-text-muted">We reply to every email, typically within 24 hours.</p>
                    </div>
                </x-reveal>
                @endif

                {{-- FAQ link --}}
                <x-reveal :delay="320">
                    <div class="rounded-2xl border border-border bg-surface p-6">
                        <p class="text-xs font-semibold text-text-muted uppercase tracking-wide mb-2">Common questions</p>
                        <p class="text-sm text-text-muted mb-3 leading-relaxed">
                            Wondering about timelines, pricing, or how we work? Check the FAQ first.
                        </p>
                        <a
                            href="{{ route('faq') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-violet hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2 rounded"
                        >
                            Read the FAQ
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>
                </x-reveal>

            </div>
        </div>
    </x-container>
</section>

</x-layouts.app>

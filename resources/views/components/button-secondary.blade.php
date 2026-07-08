{{--
    Secondary CTA button — white bg, violet border, violet text.
    §8 item 8: fills violet on hover; active compresses 1px.
    Usage: <x-button-secondary href="/contact">Book a call</x-button-secondary>
--}}
@props(['href' => '#'])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'group inline-flex items-center gap-2 px-6 py-3 rounded-xl font-heading font-semibold text-violet text-sm border border-violet bg-white transition-all duration-200 hover:bg-violet hover:text-white active:scale-[0.99] no-underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2']) }}
>
    {{ $slot }}
    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-0.5"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2.5"
        aria-hidden="true"
    >
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>
</a>

{{--
    Book-a-call button — secondary button pointing to the booking URL.
    TODO: Phase 3 wires href to Settings table (key: booking_url).
    For now, falls back to BOOKING_URL env var, then '#'.
--}}
<x-button-secondary
    :href="config('services.booking_url', '#')"
    {{ $attributes }}
    target="{{ config('services.booking_url', '#') !== '#' ? '_blank' : '_self' }}"
    rel="noopener noreferrer"
>
    Book a call
</x-button-secondary>

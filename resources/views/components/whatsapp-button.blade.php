{{--
    Floating WhatsApp CTA — fixed bottom-right, above the chatbot bubble.
    TODO: Phase 3 wires the number to Settings table (key: whatsapp_number).
    For now, falls back to WHATSAPP_NUMBER env var.
--}}
@php
    $number  = config('services.whatsapp_number', '');
    $message = urlencode("Hi, I'd like to start a project with AHKLOGIX.");
    $href    = $number ? "https://wa.me/{$number}?text={$message}" : '#';
@endphp

<a
    href="{{ $href }}"
    @if($number) target="_blank" rel="noopener noreferrer" @endif
    aria-label="Start a project on WhatsApp"
    class="group fixed bottom-24 right-6 z-40 flex items-center gap-2.5 bg-[#25D366] text-white px-4 py-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 active:scale-100 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-2"
>
    {{-- WhatsApp icon --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.532 5.848L.054 23.764a.5.5 0 00.612.612l5.994-1.504A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.954 9.954 0 01-5.031-1.355l-.361-.214-3.741.937.955-3.665-.235-.376A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
    </svg>
    <span class="text-sm font-semibold">Start a project</span>
</a>

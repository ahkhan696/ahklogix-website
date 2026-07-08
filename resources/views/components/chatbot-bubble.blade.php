{{--
    AI chatbot bubble — fixed bottom-right, pulses every 8s (§8 item 10).
    If chatbot_embed is set in config (from Settings), renders the embed script.
    Otherwise shows a placeholder bubble with a TODO note.
    TODO: Phase 3 wires embed code to Settings table (key: chatbot_embed).
--}}
@php
    $embed = config('services.chatbot_embed');
@endphp

@if($embed)
    {{-- Render the real chatbot embed code from Settings --}}
    {!! $embed !!}
@else
    {{-- Placeholder bubble — replace with real chatbot embed in production --}}
    <button
        type="button"
        aria-label="Open chat"
        title="Chat with us (coming soon)"
        class="bubble-pulse fixed bottom-6 right-6 z-40 w-14 h-14 rounded-full bg-violet text-white shadow-lg hover:shadow-xl hover:scale-110 active:scale-100 transition-transform duration-200 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>
@endif

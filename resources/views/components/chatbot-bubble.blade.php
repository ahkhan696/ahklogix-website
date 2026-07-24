{{--
    AI chatbot bubble + streaming chat panel (Phase C2).
    All state managed by Alpine. Works identically on any ChatDriver (Gemini / Claude / RuleBasedDriver).
--}}
<div x-data="chatbot()" class="fixed bottom-6 right-4 sm:right-6 z-50">

    {{-- ── Chat panel ── --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        @keydown.escape.window="close()"
        role="dialog"
        aria-modal="true"
        aria-label="AHKLOGIX chat assistant"
        class="absolute bottom-full mb-3 right-0 origin-bottom-right
               w-[min(22rem,calc(100vw-2rem))] sm:w-96
               bg-bg rounded-2xl shadow-2xl border border-border
               flex flex-col overflow-hidden"
        style="max-height: min(32rem, calc(100vh - 6rem));"
    >
        {{-- 3 px gradient accent bar --}}
        <div class="h-0.5 flex-none" style="background: var(--gradient-brand)"></div>

        {{-- Header --}}
        <div class="flex items-center gap-3 px-4 py-3 border-b border-border flex-none bg-bg">
            <div class="relative flex-none">
                <div
                    class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-semibold"
                    style="background: var(--gradient-brand); font-family: var(--font-heading);"
                >AI</div>
                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 border-2 border-bg rounded-full"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm text-indigo-ink leading-none"
                   style="font-family: var(--font-heading);">AHKLOGIX AI</p>
                <p class="text-xs text-text-muted mt-0.5 transition-opacity duration-200"
                   x-text="sending ? 'Typing…' : 'Online'"></p>
            </div>
            <button
                @click="close()"
                type="button"
                aria-label="Close chat"
                class="flex-none w-7 h-7 rounded-full text-text-muted hover:bg-surface hover:text-indigo-ink transition-colors duration-150 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet"
            >
                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M3 3l10 10M13 3L3 13"/>
                </svg>
            </button>
        </div>

        {{-- Message list --}}
        <div
            x-ref="messageList"
            class="flex-1 overflow-y-auto p-4 flex flex-col gap-3 overscroll-contain"
        >
            <template x-for="(msg, i) in messages" :key="i">
                <div
                    class="flex flex-col"
                    :class="msg.role === 'user' ? 'items-end' : 'items-start'"
                >
                    <div
                        class="px-3.5 py-2.5 text-sm leading-relaxed break-words max-w-[85%]"
                        :class="msg.role === 'user'
                            ? 'text-white rounded-2xl rounded-br-sm'
                            : 'bg-surface border border-border text-text-body rounded-2xl rounded-bl-sm'"
                        :style="msg.role === 'user' ? 'background: var(--gradient-brand)' : ''"
                    >
                        <span x-text="msg.text"></span><span
                            x-show="msg.streaming"
                            class="chat-cursor"
                            aria-hidden="true"
                        ></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input row --}}
        <div class="flex-none border-t border-border p-3 bg-bg">
            <form @submit.prevent="send()" class="flex gap-2 items-end">
                <textarea
                    x-ref="input"
                    x-model="input"
                    @keydown="handleKeydown($event)"
                    @input="$el.style.height = '0px'; $el.style.height = Math.min($el.scrollHeight, 96) + 'px'"
                    :disabled="sending"
                    placeholder="Type a message…"
                    rows="1"
                    aria-label="Chat message"
                    class="flex-1 resize-none rounded-xl border border-border bg-surface px-3 py-2 text-sm text-text-body placeholder-text-muted focus:outline-none focus:border-violet focus:ring-1 focus:ring-violet transition-colors duration-150 disabled:opacity-50"
                    style="min-height: 2.25rem; max-height: 6rem; overflow-y: auto;"
                ></textarea>
                <button
                    type="submit"
                    :disabled="sending || !input.trim()"
                    aria-label="Send message"
                    class="flex-none w-9 h-9 rounded-xl flex items-center justify-center text-white transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed hover:brightness-110 active:scale-95 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-1"
                    style="background: var(--gradient-brand)"
                >
                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 8h12M9 3l5 5-5 5"/>
                    </svg>
                </button>
            </form>
            <p class="text-[10px] text-text-muted mt-1.5 text-center leading-tight">
                AI may make mistakes ·
                <a href="/contact" class="hover:text-violet underline underline-offset-2 transition-colors duration-150">Contact us directly</a>
            </p>
        </div>
    </div>

    {{-- ── Floating bubble ── --}}
    <button
        @click="toggle()"
        type="button"
        :aria-expanded="open.toString()"
        :aria-label="open ? 'Close chat' : 'Chat with AHKLOGIX AI'"
        :class="open ? '' : 'bubble-pulse'"
        class="relative w-14 h-14 rounded-full text-white shadow-lg hover:shadow-xl hover:scale-110 active:scale-100 transition-transform duration-200 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-violet focus-visible:ring-offset-2"
        style="background: var(--gradient-brand)"
    >
        {{-- Chat icon — visible when panel is closed --}}
        <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        {{-- X icon — visible when panel is open --}}
        <svg x-show="open" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
        </svg>

        {{-- Unread dot --}}
        <span
            x-show="hasUnread && !open"
            x-cloak
            class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-magenta rounded-full border-2 border-bg"
            aria-hidden="true"
        ></span>
    </button>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('chatbot', () => ({
        open:      false,
        messages:  [],
        input:     '',
        sending:   false,
        hasUnread: false,

        toggle() {
            this.open ? this.close() : this.openPanel();
        },

        openPanel() {
            this.open      = true;
            this.hasUnread = false;
            if (this.messages.length === 0) {
                this.messages.push({
                    role:      'bot',
                    text:      "Hi! I'm the AHKLOGIX AI assistant. Ask me anything about our services, POSR, or how we can help your business.",
                    streaming: false,
                });
            }
            this.$nextTick(() => {
                this.scrollToBottom();
                this.$refs.input?.focus();
            });
        },

        close() {
            this.open = false;
        },

        async send() {
            const text = this.input.trim();
            if (!text || this.sending) return;

            this.input   = '';
            this.sending = true;

            // Reset textarea height after clearing
            this.$nextTick(() => {
                if (this.$refs.input) this.$refs.input.style.height = '';
            });

            this.messages.push({ role: 'user', text, streaming: false });
            this.messages.push({ role: 'bot',  text: '', streaming: true });
            this.$nextTick(() => this.scrollToBottom());

            try {
                const response = await fetch('/api/chat', {
                    method:  'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ message: text }),
                });

                if (response.status === 429) {
                    this.setLastBotText("You're sending messages too quickly. Please wait a moment and try again.");
                    return;
                }

                if (!response.ok) {
                    this.setLastBotText('The assistant is temporarily unavailable. Please try again.');
                    return;
                }

                const reader  = response.body.getReader();
                const decoder = new TextDecoder();
                let   buffer  = '';

                outer: while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop() ?? '';

                    for (const line of lines) {
                        if (!line.startsWith('data: ')) continue;
                        const payload = line.slice(6).trim();
                        if (payload === '[DONE]') break outer;

                        try {
                            const event = JSON.parse(payload);
                            if (event.text) {
                                const bot = this.lastBotMessage();
                                if (bot) bot.text += event.text;
                                if (!this.open) this.hasUnread = true;
                                this.$nextTick(() => this.scrollToBottom());
                            } else if (event.error) {
                                this.setLastBotText(event.error);
                                break outer;
                            }
                        } catch (_) {}
                    }
                }

                const bot = this.lastBotMessage();
                if (bot) bot.streaming = false;

            } catch (_) {
                this.setLastBotText('Something went wrong. Please check your connection and try again.');
            } finally {
                this.sending = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        setLastBotText(text) {
            const bot = this.lastBotMessage();
            if (bot) { bot.text = text; bot.streaming = false; }
        },

        lastBotMessage() {
            for (let i = this.messages.length - 1; i >= 0; i--) {
                if (this.messages[i].role === 'bot') return this.messages[i];
            }
            return null;
        },

        scrollToBottom() {
            const el = this.$refs.messageList;
            if (el) el.scrollTop = el.scrollHeight;
        },

        handleKeydown(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.send();
            }
        },
    }));
});
</script>

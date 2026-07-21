<div class="fixed bottom-4 right-4 sm:bottom-5 sm:right-5 font-sans" style="z-index: 2147483647;">
    <!-- Chat Toggle Button -->
    <button 
        wire:click="toggleWidget" 
        class="flex items-center justify-center gap-2 w-14 h-14 rounded-full sm:w-auto sm:h-auto sm:px-4 sm:py-3 sm:rounded-full bg-primary hover:bg-[#c48a85] text-white font-semibold shadow-2xl transition-all duration-300 transform hover:scale-105 active:scale-95 border border-primary/40"
        aria-label="Toggle AI Assistant"
    >
        <!-- Green online status dot (hidden on mobile, visible on desktop) -->
        <span class="hidden sm:flex relative h-2.5 w-2.5 shrink-0">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
        </span>
        <!-- AI Spark Icon -->
        <svg class="w-6 h-6 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
        </svg>
        <span class="hidden sm:inline font-semibold">Ask Everyday</span>
    </button>

    <!-- Floating Chat Modal Window -->
    @if($isOpen)
    <div 
        x-data="{ showScrollBtn: false, isNearBottom: true }"
        x-init="$nextTick(() => {
            const c = $refs.chatContainer;
            if (!c) return;
            const checkBottom = () => isNearBottom = (c.scrollHeight - c.scrollTop - c.clientHeight) < 20;
            const scrollToNewMsg = () => {
                const msgs = c.querySelectorAll(':scope > div');
                const last = msgs[msgs.length - 1];
                if (last) { last.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
                showScrollBtn = (c.scrollHeight - c.scrollTop - c.clientHeight) > 20;
            };
            c.scrollTop = c.scrollHeight;
            c.addEventListener('scroll', () => { checkBottom(); showScrollBtn = !isNearBottom; });
            new MutationObserver(scrollToNewMsg).observe(c, { childList: true, subtree: true });
        })"
        class="fixed bottom-20 right-3 sm:right-5 w-[94vw] sm:w-[390px] h-[560px] max-h-[85vh] bg-white dark:bg-black rounded-2xl shadow-2xl border border-secondary dark:border-zinc-800 flex flex-col overflow-hidden transition-all duration-300 animate-in fade-in slide-in-from-bottom-4"
        style="z-index: 2147483647;"
    >
        <!-- Modal Header -->
        <div class="bg-primary p-4 text-white flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/25 flex items-center justify-center font-bold text-white shadow-inner">
                    ✨
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight text-white">Everyday Assistant</h3>
                    <p class="text-xs text-white/90 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span> Online (Free AI Help)
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button wire:click="clearChat" title="Clear Chat" class="p-1.5 hover:bg-white/20 rounded-lg transition-colors text-white/90 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <button wire:click="toggleWidget" title="Close" class="p-1.5 hover:bg-white/20 rounded-lg transition-colors text-white/90 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages Container -->
        <div x-ref="chatContainer" class="flex-1 p-4 overflow-y-auto space-y-3 bg-[#f8f9fe] dark:bg-zinc-950/80 text-xs">
            @foreach($messages as $msg)
                <div class="flex flex-col {{ $msg['role'] === 'user' ? 'items-end' : 'items-start' }}">
                    <div class="max-w-[88%] rounded-2xl px-3.5 py-2.5 shadow-sm leading-relaxed {{ $msg['role'] === 'user' ? 'bg-primary text-white font-medium rounded-br-none' : 'bg-white dark:bg-zinc-800 dark:text-zinc-100 text-zinc-800 border border-secondary dark:border-zinc-700/60 rounded-bl-none' }}">
                        @php
                            $formattedContent = e($msg['content']);

                            // ── 1. PRODUCT_CARD token → rich mini product card ──────────────────
                            $formattedContent = preg_replace_callback(
                                '/\[PRODUCT_CARD:\s*([^\|]+)\|([^\|]+)\|([^\|]*)\|([^\]]+)\]/i',
                                function ($m) {
                                    $title   = trim($m[1]);
                                    $price   = trim($m[2]);
                                    $imgSrc  = trim($m[3]);
                                    $url     = trim($m[4]);
                                    $imgHtml = $imgSrc
                                        ? '<img src="' . $imgSrc . '" alt="' . $title . '" class="w-full h-24 object-cover rounded-t-xl" loading="lazy">'
                                        : '<div class="w-full h-16 rounded-t-xl bg-secondary flex items-center justify-center text-2xl">🛍️</div>';
                                    return '<div class="border border-primary/20 rounded-xl overflow-hidden my-2 w-full shadow-sm bg-white dark:bg-zinc-900">'
                                        . $imgHtml
                                        . '<div class="p-2.5">'
                                        . '<p class="font-bold text-zinc-800 dark:text-zinc-100 text-[11px] leading-tight">' . $title . '</p>'
                                        . '<p class="text-primary font-semibold text-[11px] mt-0.5">' . $price . '</p>'
                                        . '<a href="' . $url . '" class="mt-1.5 flex items-center justify-center gap-1 bg-primary hover:bg-[#c48a85] text-white text-[10px] font-semibold px-3 py-1.5 rounded-lg transition-all">View Product ➔</a>'
                                        . '</div></div>';
                                },
                                $formattedContent
                            );

                            // ── 2. WHATSAPP tag → Green WhatsApp SVG Button ────────────────────
                            $whatsappBtn = '<a href="https://wa.me/$1" target="_blank" class="inline-flex items-center gap-1.5 bg-[#25D366] hover:bg-[#1ea952] text-white font-semibold text-xs px-3.5 py-2 rounded-full transition-all shadow-md my-1.5"><svg class="w-4 h-4 fill-current text-white shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>WhatsApp Us</a>';
                            $formattedContent = preg_replace('/\[WHATSAPP:\s*([^\]]+)\]/i', $whatsappBtn, $formattedContent);

                            // ── 3. PHONE tag → Blue Phone Call SVG Button ──────────────────────
                            $phoneBtn = '<a href="tel:$1" class="inline-flex items-center gap-1.5 bg-[#0284c7] hover:bg-[#0369a1] text-white font-semibold text-xs px-3.5 py-2 rounded-full transition-all shadow-md my-1.5"><svg class="w-4 h-4 fill-current text-white shrink-0" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>Call Us</a>';
                            $formattedContent = preg_replace('/\[PHONE:\s*([^\]]+)\]/i', $phoneBtn, $formattedContent);

                            // ── 4. URL tag → View Details Button ───────────────────────────────
                            $formattedContent = preg_replace('/\[URL:\s*([^\]]+)\]/i', '<a class="inline-flex items-center gap-1 underline text-primary dark:text-secondary font-semibold mt-1 hover:opacity-75 transition-opacity" href="$1">View Details ➔</a>', $formattedContent);

                            // ── 5. Markdown rendering ───────────────────────────────────────────
                            $formattedContent = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $formattedContent);
                            $formattedContent = preg_replace('/(?:^|\n)\s*[•\-]\s+(.+)/m', '<br><span class="inline-block mt-0.5">• $1</span>', $formattedContent);
                            $formattedContent = str_replace("\n\n", '<br><br>', $formattedContent);
                            $formattedContent = str_replace("\n", '<br>', $formattedContent);
                            $formattedContent = ltrim($formattedContent, '<br>');
                        @endphp
                        {!! $formattedContent !!}
                    </div>
                    <span class="text-[10px] text-zinc-400 mt-1 px-1">{{ $msg['timestamp'] }}</span>
                </div>
            @endforeach

            <!-- Typing indicator: shown client-side via wire:loading -->
            <div wire:loading wire:target="sendMessage, sendQuickPrompt" class="flex items-start">
                <div class="max-w-[88%] rounded-2xl px-3.5 py-3 shadow-sm bg-white dark:bg-zinc-800 border border-secondary dark:border-zinc-700/60 rounded-bl-none">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">AI is thinking</span>
                        <span class="flex gap-1">
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce"></span>
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce [animation-delay:0.2s]"></span>
                            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-bounce [animation-delay:0.4s]"></span>
                        </span>
                    </div>
                </div>
            </div>
            <!-- Scroll to bottom arrow button -->
            <button
                x-show="showScrollBtn"
                x-transition.opacity
                @click="$refs.chatContainer.scrollTo({ top: $refs.chatContainer.scrollHeight, behavior: 'smooth' }); showScrollBtn = false;"
                class="sticky bottom-2 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-primary/90 hover:bg-primary text-white shadow-lg flex items-center justify-center transition-all hover:scale-110 z-10"
                title="Scroll to latest"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </button>
        </div>

        <!-- Quick Prompts Pill Row (Expanded) -->
        <div class="px-3 py-2 bg-white dark:bg-black border-t border-secondary dark:border-zinc-800 flex gap-1.5 overflow-x-auto text-[10px] no-scrollbar">
            <button wire:click="sendQuickPrompt('Track my order')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                📦 Track Order
            </button>
            <button wire:click="sendQuickPrompt('List all products')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                🛒 All Products
            </button>
            <button wire:click="sendQuickPrompt('What categories do you have?')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                📁 Categories
            </button>
            <button wire:click="sendQuickPrompt('What is your return and refund policy?')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                🔄 Returns
            </button>
            <button wire:click="sendQuickPrompt('Free shipping policy')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                🚚 Shipping
            </button>
            <button wire:click="sendQuickPrompt('Show your best selling products')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                ⭐ Best Sellers
            </button>
            <button wire:click="sendQuickPrompt('Terms and conditions')" class="whitespace-nowrap bg-secondary dark:bg-zinc-800 hover:bg-primary/20 text-zinc-800 dark:text-zinc-200 hover:text-primary border border-primary/20 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                📋 Terms
            </button>
            <button wire:click="sendQuickPrompt('I need to talk to a human agent')" class="whitespace-nowrap bg-[#25D366]/10 hover:bg-[#25D366]/20 text-[#1ea952] dark:text-emerald-400 border border-[#25D366]/30 px-2.5 py-1.5 rounded-full transition-colors font-medium">
                💬 Talk to Human
            </button>
        </div>

        <!-- Message Input Form -->
        <form wire:submit.prevent="sendMessage" class="p-3 bg-white dark:bg-black border-t border-secondary dark:border-zinc-800 flex items-center gap-2">
            <input 
                type="text" 
                wire:model="inputMessage" 
                wire:loading.attr="disabled"
                wire:target="sendMessage, sendQuickPrompt"
                placeholder="Ask about products or order status..." 
                class="flex-1 bg-secondary dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 text-xs px-3.5 py-2.5 rounded-xl border border-primary/20 focus:ring-2 focus:ring-primary outline-none disabled:opacity-50"
            />
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                wire:target="sendMessage, sendQuickPrompt"
                class="bg-primary hover:bg-[#c48a85] text-white p-2.5 rounded-xl transition-all shadow-md active:scale-95 flex items-center justify-center shrink-0 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <!-- Send icon (default) -->
                <svg wire:loading.remove wire:target="sendMessage, sendQuickPrompt" class="w-4 h-4 rotate-90 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                </svg>
                <!-- Spinner icon (while loading) -->
                <svg wire:loading wire:target="sendMessage, sendQuickPrompt" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
    @endif
</div>


<div class="drawer drawer-end">
    <input id="mob-cart-side-bar" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content mt-[0.4rem] cursor-pointer">
        <label for="mob-cart-side-bar"
            class="drawer-button text-primary border border-solid border-secondary dark:border-slate-800 py-2 lg:px-6 md:px-6 sm:px-4 xs:px-4">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="text-black dark:text-white text-sm font-semibold">{{ $cart_count }}</span>
        </label>
    </div>

    <div class="drawer-side text-black z-50">
        <label for="mob-cart-side-bar" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="menu bg-white dark:bg-black min-h-full w-80 p-4 text-start flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center border-b border-b-secondary dark:border-b-slate-800 pb-2 mb-3">
                    <h1 class="uppercase text-base dark:text-white font-semibold">Your Cart ({{ $cart_count }})</h1>
                    <label for="mob-cart-side-bar" class="text-neutral-500 hover:text-black dark:hover:text-white cursor-pointer text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </label>
                </div>

                @if($cart_count > 0)
                    <div class="overflow-y-auto max-h-[calc(100vh-250px)] divide-y divide-secondary dark:divide-slate-800 pr-1">
                        @foreach ($cartItems as $index => $crt)
                            <div wire:key="mobile-cart-item-{{ $crt['slug'] }}-{{ $crt['color'] }}-{{ $crt['is_bundle'] ?? 0 }}"
                                class="py-3 relative">
                                <button type="button"
                                    wire:click="removeItem('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                    wire:loading.attr="disabled"
                                    class="text-neutral-400 hover:text-red-500 transition-colors cursor-pointer absolute top-3 right-0 p-1"
                                    title="Remove item">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                                <div class="grid grid-cols-[64px_1fr] gap-3 items-center pr-6">
                                    <div class="h-16 w-16 bg-neutral-50 dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden flex items-center justify-center">
                                        <img class="h-full w-full object-contain"
                                            src="{{ getWebsiteUrl() . '/storage/' . $crt['image'] }}"
                                            alt="{{ $crt['title'] }}" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold dark:text-white truncate" title="{{ $crt['title'] }}">{{ $crt['title'] }}</div>
                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                            {{ $crt['currency'] }} {{ number_format($crt['unit_amount'], 2) }}
                                        </div>
                                        @if (!empty($crt['color']))
                                            <div class="text-[11px] text-neutral-400 dark:text-neutral-500">
                                                Color: {{ $crt['color'] }}
                                            </div>
                                        @endif
                                        <div class="flex items-center justify-between mt-1">
                                            <div class="flex items-center border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-zinc-900">
                                                <button type="button"
                                                    wire:click="decreaseQty('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                                    wire:loading.attr="disabled"
                                                    class="px-2 py-0.5 text-xs text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors cursor-pointer">-</button>
                                                <span class="px-2 text-xs font-bold text-neutral-900 dark:text-white">{{ $crt['quantity'] }}</span>
                                                <button type="button"
                                                    wire:click="increaseQty('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                                    wire:loading.attr="disabled"
                                                    class="px-2 py-0.5 text-xs text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors cursor-pointer">+</button>
                                            </div>
                                            <span class="text-xs font-semibold dark:text-white">
                                                {{ $crt['currency'] }} {{ number_format($crt['total_amount'], 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center text-neutral-400 dark:text-neutral-500">
                        <i class="fa-solid fa-cart-shopping text-3xl mb-2 block opacity-40"></i>
                        <span>Your cart is currently empty.</span>
                    </div>
                @endif
            </div>

            @if($cart_count > 0)
                <div class="border-t border-secondary dark:border-slate-800 pt-3 mt-3">
                    <div class="text-sm font-semibold dark:text-white flex justify-between">
                        <span>Subtotal:</span>
                        <span>{{ getLocation()->currency }} {{ number_format($sub_total, 2) }}</span>
                    </div>
                    <div class="text-[11px] text-neutral-400 dark:text-neutral-500 mt-0.5">Taxes and shipping calculated at checkout</div>
                    <div class="mt-3 space-y-2">
                        <a href="{{ route('checkout') }}"
                            class="block uppercase text-xs font-semibold bg-primary hover:bg-primary/90 text-white w-full py-2.5 text-center transition-colors">
                            Check Out
                        </a>
                        <a href="{{ route('cart') }}"
                            class="block uppercase text-xs font-semibold bg-secondary hover:bg-neutral-200 dark:hover:bg-neutral-800 text-neutral-900 dark:text-white w-full py-2 text-center transition-colors">
                            View Cart
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

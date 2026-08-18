<div class="py-5 px-8">
    <div class="text-2xl font-semibold text-black dark:text-white mb-4">Your Cart</div>
    <div class="grid lg:grid-cols-[68%_30%] md:grid-cols-[68%_30%] sm:grid-cols-1 xs:grid-cols-1 gap-5">
        <div>
            @if(count($cartItems))
                <div class="divide-y divide-secondary dark:divide-slate-800">
                    @foreach ($cartItems as $crt)
                        <div wire:key="cart-page-item-{{ $crt['slug'] }}-{{ $crt['color'] }}-{{ $crt['is_bundle'] ?? 0 }}"
                            class="border-b py-4 border-secondary dark:text-white dark:border-slate-800 relative">
                            <button type="button"
                                wire:click="removeItem('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                wire:loading.attr="disabled"
                                class="text-neutral-400 hover:text-red-500 transition-colors cursor-pointer absolute right-4 top-4 p-1"
                                title="Remove item">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="grid grid-cols-[100px_1fr] gap-5 items-center pr-8">
                                <div class="h-24 w-24 bg-neutral-50 dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden flex items-center justify-center">
                                    <img class="h-full w-full object-contain"
                                        src="{{ getWebsiteUrl() . '/storage/' . $crt['image'] }}"
                                        alt="{{ $crt['title'] }}">
                                </div>
                                <div>
                                    <div class="py-1 text-sm font-bold dark:text-white">{{ $crt['title'] }}</div>
                                    <div class="py-1 text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ $crt['currency'] }} {{ number_format($crt['unit_amount'], 2) }}
                                    </div>
                                    @if (!empty($crt['color']))
                                        <div class="py-1 flex text-xs text-neutral-500 dark:text-neutral-400">
                                            Color: {{ $crt['color'] }}
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-zinc-900">
                                            <button type="button"
                                                wire:click="decreaseQty('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                                wire:loading.attr="disabled"
                                                class="px-3 py-1 text-xs text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors cursor-pointer">-</button>
                                            <span class="px-3 text-xs font-bold text-neutral-900 dark:text-white">{{ $crt['quantity'] }}</span>
                                            <button type="button"
                                                wire:click="increaseQty('{{ $crt['slug'] }}', '{{ $crt['color'] }}', {{ ($crt['is_bundle'] ?? false) ? 'true' : 'false' }})"
                                                wire:loading.attr="disabled"
                                                class="px-3 py-1 text-xs text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors cursor-pointer">+</button>
                                        </div>
                                        <span class="text-base font-semibold dark:text-white">
                                            {{ $crt['currency'] }} {{ number_format($crt['total_amount'], 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h3 class="text-black dark:text-white py-8">Your cart is currently empty.</h3>
            @endif
        </div>

        @if(count($cartItems))
            <div>
                <div class="flex justify-end">
                    <button type="button" wire:click="clearCart" wire:loading.attr="disabled"
                        class="text-sm font-semibold bg-primary hover:bg-primary/90 text-white px-3 py-2 cursor-pointer transition-colors">
                        <svg wire:loading wire:target="clearCart" aria-hidden="true" role="status"
                            class="inline mr-1 w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.9766 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
                        </svg>
                        Clear Cart
                    </button>  
                </div>
                <div class="mt-4 text-end bg-neutral-50 dark:bg-zinc-900 border border-secondary dark:border-slate-800 p-4">
                    <div class="text-lg font-semibold text-black dark:text-white flex justify-between">
                        <span>Subtotal:</span>
                        <span>{{ getLocation()->currency }} {{ number_format($sub_total, 2) }}</span>
                    </div>  
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Taxes and shipping calculated at checkout</div>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('checkout') }}"
                            class="block uppercase text-xs font-semibold bg-primary hover:bg-primary/90 text-white w-full py-3 text-center transition-colors">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


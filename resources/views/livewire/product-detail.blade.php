<div class="bg-white dark:bg-black"
    x-data="{ tab: 0, isVideoOpen: false, videoEmbed: '{{ addslashes(str_replace(["\r", "\n"], '', $product->youtube_link)) }}' }">
    <!-- Main Product Section -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-16 px-8 py-8 lg:py-16 text-black dark:text-secondary">

        <!-- Left Column: Product Gallery -->
        <div class="md:col-span-5 space-y-6">
            <!-- Desktop Gallery (Hidden on Mobile) -->
            <div class="hidden md:block">
                <!-- Large Active Image Card with Hover Zoom -->
                <div x-data="{ zoom: false, x: 0, y: 0 }" x-on:mouseenter="zoom = true" x-on:mouseleave="zoom = false"
                    x-on:mousemove="
                        const rect = $el.getBoundingClientRect();
                        x = (($event.clientX - rect.left) / rect.width) * 100;
                        y = (($event.clientY - rect.top) / rect.height) * 100;
                     "
                    class="bg-neutral-50 dark:bg-zinc-950 border border-secondary dark:border-slate-800 overflow-hidden shadow-sm relative aspect-square flex items-center justify-center cursor-zoom-in">

                    <!-- Video Play Overlay Icon (Desktop) -->
                    @if ($product->youtube_link)
                        <button x-on:click.stop="isVideoOpen = true"
                            class="absolute top-3 right-3 z-30 bg-white dark:bg-zinc-950 border border-secondary dark:border-slate-800 shadow-sm p-3 text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 cursor-pointer flex items-center justify-center"
                            title="Watch Video Review">
                            <i class="fa-solid fa-play text-lg"></i>
                        </button>
                    @endif

                    <img :style="zoom ? `transform: scale(2.5); transform-origin: ${x}% ${y}%;` : ''"
                        class="max-w-full max-h-full object-contain transition-transform duration-100 ease-out"
                        src="{{ $activeImage }}" alt="{{ $product['title'] }}" />
                </div>
                <!-- Thumbnails Grid -->
                <div class="flex flex-wrap justify-center gap-3 mt-4">
                    @foreach ($images as $media)
                        @if ($media)
                            <button wire:click="changeActiveImage('{{ $media }}')"
                                class="cursor-pointer border-2 transition-all duration-200 overflow-hidden h-16 w-16 flex items-center justify-center bg-neutral-50 dark:bg-zinc-900 {{ $activeImage == $media ? 'border-primary ring-2 ring-primary/20 scale-105' : 'border-transparent hover:border-neutral-300 dark:hover:border-neutral-700' }}">
                                <img class="object-cover h-full w-full" src="{{ $media }}" alt="Thumbnail" />
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Mobile Carousel Gallery (Visible on Mobile) -->
            <div class="block md:hidden relative">
                <!-- Video Play Overlay Icon (Mobile) -->
                @if ($product->youtube_link)
                    <button x-on:click.stop="isVideoOpen = true"
                        class="absolute top-3 right-3 z-30 bg-white dark:bg-zinc-950 border border-secondary dark:border-slate-800 shadow-sm p-3 text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 cursor-pointer flex items-center justify-center"
                        title="Watch Video Review">
                        <i class="fa-solid fa-play text-lg"></i>
                    </button>
                @endif
                <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-none gap-4">
                    @foreach ($images as $media)
                        @if ($media)
                            <div
                                class="snap-center shrink-0 w-full bg-neutral-50 dark:bg-zinc-950 border border-secondary dark:border-slate-800 overflow-hidden aspect-square flex items-center justify-center">
                                <img class="max-w-full max-h-full object-contain" src="{{ $media }}"
                                    alt="{{ $product['title'] }}" />
                            </div>
                        @endif
                    @endforeach
                </div>
                <!-- Mobile Thumbnails -->
                <div class="flex justify-center gap-2 mt-4 overflow-x-auto py-1">
                    @foreach ($images as $media)
                        @if ($media)
                            <button wire:click="changeActiveImage('{{ $media }}')"
                                class="shrink-0 transition-all duration-200 overflow-hidden h-12 w-12 border-2 {{ $activeImage == $media ? 'border-primary ring-2 ring-primary/20' : 'border-transparent' }}">
                                <img class="object-cover h-full w-full" src="{{ $media }}" alt="Thumbnail" />
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Product Details -->
        <div class="md:col-span-7 flex flex-col justify-start">
            <h1
                class="text-3xl md:text-4xl font-extrabold tracking-tight text-neutral-900 dark:text-white leading-tight mb-2">
                {{ $product->title }}
            </h1>

            <!-- Ratings and Reviews Header -->
            @php
                $review_count = $reviews->count();
                $review_mean = $review_count > 0 ? round($reviews->sum('rating') / $review_count) : 0;
            @endphp
            @if ($review_count > 0)
                <button
                    x-on:click.prevent="tab = 1; document.getElementById('tabs-section').scrollIntoView({ behavior: 'smooth' })"
                    class="flex items-center gap-2 mb-2 hover:opacity-85 transition-opacity focus:outline-none text-left cursor-pointer">
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < $review_mean; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endfor
                        @for ($i = 0; $i < 5 - $review_mean; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-neutral-300 dark:text-neutral-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-medium text-primary hover:underline">
                        ({{ $review_count }} {{ $review_count == 1 ? 'Review' : 'Reviews' }})
                    </span>
                </button>
            @else
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex text-neutral-300 dark:text-neutral-600">
                        @for ($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-neutral-300 dark:text-neutral-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                        ({{ $review_count }} {{ $review_count == 1 ? 'Review' : 'Reviews' }})
                    </span>
                </div>
            @endif

            <!-- Price and Status Block -->
            <div class="py-2">
                @if (count($product->stocks) == 0)
                    <span
                        class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-950/40 dark:text-red-400 uppercase tracking-wider">
                        Out Of Stock
                    </span>
                @elseif ($product->coming_soon)
                    <span
                        class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-400 uppercase tracking-wider">
                        Coming Soon
                    </span>
                @else
                    <div class="flex items-baseline gap-4">
                        @if ($product->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $product->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $product->price_detail->discount_to))
                            <span class="text-3xl font-extrabold text-primary">
                                {{ $product->price_detail->country->currency }}
                                {{ number_format(round($product->price_detail->price - ($product->price_detail->price / 100) * $product->price_detail->discount), 2) }}
                            </span>
                            <span class="text-lg text-neutral-400 line-through">
                                {{ $product->price_detail->country->currency }}
                                {{ number_format($product->price_detail->price, 2) }}
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-400 uppercase">
                                -{{ $product->price_detail->discount }}% off
                            </span>
                        @else
                            <span class="text-3xl font-extrabold text-primary">
                                {{ $product->price_detail->country->currency }}
                                {{ number_format($product->price_detail->price, 2) }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Short Description -->
            <p class="text-neutral-600 dark:text-neutral-300 text-base leading-relaxed mb-6">
                {{ $product->short_desc }}
            </p>

            <!-- Color Options -->
            @if (count($colors))
                <div class="mb-6">
                    <span class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                        Color: <span class="font-normal text-neutral-500 dark:text-neutral-400">{{ $current_color }}</span>
                    </span>
                    <div class="flex items-center gap-3">
                        @foreach ($colors as $key => $clr)
                            <button wire:click="fetchColorWiseImages('{{ $clr['id'] }}','{{ $clr['color_name'] }}')"
                                class="relative rounded-full h-8 w-8 focus:outline-none transition-all duration-200 {{ $clr['color_name'] == $current_color ? 'ring-2 ring-offset-2 ring-primary dark:ring-offset-black scale-105' : 'hover:scale-105 border border-neutral-200 dark:border-neutral-800' }}"
                                style="background-image: url({{ asset('storage/' . $clr['color_image']) }}); background-size: cover; background-position: center;"
                                title="{{ $clr['color_name'] }}">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quantity & Actions -->
            @if (!$product->coming_soon && $product->stocks->count() > 0)
                <div class="flex flex-col sm:flex-row items-center gap-4 py-4 mb-6">
                    <!-- Quantity Box -->
                    <div
                        class="flex items-center border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-zinc-900 p-1">
                        <button wire:click="decrementQty({{ $qty - 1 }})"
                            class="flex h-10 w-10 items-center justify-center text-neutral-500 hover:text-black dark:text-neutral-400 dark:hover:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors"
                            aria-label="subtract">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                            </svg>
                        </button>
                        <input wire:model="qty" value="{{ $qty }}" id="counterInput" type="text"
                            class="h-10 w-12 border-none bg-transparent text-center font-bold text-neutral-900 dark:text-white focus:ring-0 focus:outline-none"
                            readonly />
                        <button wire:click="incrementQty({{ $qty + 1 }})"
                            class="flex h-10 w-10 items-center justify-center text-neutral-500 hover:text-black dark:text-neutral-400 dark:hover:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800 transition-colors"
                            aria-label="add">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>

                    <!-- Add to Cart CTA -->
                    <button wire:click="addToCart('{{ $product['slug'] }}')" wire:loading.attr="disabled"
                        class="w-full sm:w-auto min-w-[200px] flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-semibold py-3.5 px-8 shadow-md hover:shadow-lg active:scale-[0.98] transition-all duration-200 cursor-pointer disabled:opacity-50">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Add to Cart</span>
                        <svg wire:loading wire:target="addToCart('{{ $product['slug'] }}')" aria-hidden="true" role="status"
                            class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.9766 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB"></path>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Badges Section -->
            @if(count($badges) > 0)
                <div class="flex flex-wrap items-center gap-3">
                    @foreach($badges as $badge)
                        <img height="40" width="40" src="{{ asset('storage/' . $badge->image) }}" alt="{{ $badge->title }}" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products Slider (Same Category, Trending) -->
    @if(count($relatedProducts) > 0)
        <div class="mt-16 text-center">
            <h2 class="font-bold lg:text-4xl md:text-4xl sm:text-2xl xs:text-2xl dark:text-secondary">Related Products</h2>
        </div>
        <section class="overflow-hidden">
            <div class="container xl:max-w-screen-xl 2xl:max-w-screen-2xl px-4 mx-auto sm:px-6">
                <!-- Swiper -->
                <div class="swiper related-products-swiper-container lg:px-6 md:px-6 sm:px-2 xs:px-2">
                    <div class="swiper-wrapper">
                        @foreach($relatedProducts as $pr)
                            <div class="swiper-slide bg-white dark:bg-black py-4">
                                @include('inc.product_box_trending')
                            </div>
                        @endforeach
                        @foreach($relatedProducts as $pr)
                            <div class="swiper-slide bg-white dark:bg-black py-4">
                                @include('inc.product_box_trending')
                            </div>
                        @endforeach
                        @foreach($relatedProducts as $pr)
                            <div class="swiper-slide bg-white dark:bg-black py-4">
                                @include('inc.product_box_trending')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Tabs Section -->
    <div id="tabs-section" class="mt-12 md:mt-20 border-t border-neutral-200 dark:border-neutral-800 pt-8">
        <div class="max-w-4xl mx-auto px-8">
            <!-- Tab Headers -->
            <div class="border-b border-neutral-200 dark:border-neutral-800 flex justify-center gap-8 mb-8">
                <button x-on:click.prevent="tab = 0"
                    :class="tab === 0 ? 'border-primary text-primary font-semibold' : 'border-transparent text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-base transition-all duration-200 focus:outline-none">
                    Description
                </button>
                <button x-on:click.prevent="tab = 1"
                    :class="tab === 1 ? 'border-primary text-primary font-semibold' : 'border-transparent text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-base transition-all duration-200 focus:outline-none">
                    Reviews ({{ $reviews->count() }})
                </button>
            </div>

            <!-- Tab Content: Description -->
            <div x-show="tab === 0"
                class="prose dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300 trix-editor leading-relaxed">
                {!! $product->description !!}
            </div>

            <!-- Tab Content: Reviews -->
            <div x-show="tab === 1" class="space-y-6">
                @if (count($reviews))
                    @foreach ($reviews as $review)
                        <div
                            class="bg-neutral-50 dark:bg-zinc-950 p-6 border border-secondary dark:border-slate-800 flex flex-col gap-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <!-- User Initials / Avatar placeholder -->
                                    <div
                                        class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm uppercase">
                                        @php
                                            $name = $review->user ? $review->user->name : 'Anonymous';
                                            $initials = collect(explode(' ', $name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                        @endphp
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-900 dark:text-white text-sm">
                                            {{ $name }}
                                        </h4>
                                        <span class="text-xs text-neutral-400 dark:text-neutral-500">
                                            {{ $review->created_at ? $review->created_at->diffForHumans() : '' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Star rating -->
                                <div class="flex text-amber-400">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endfor
                                    @for ($i = 0; $i < 5 - $review->rating; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="w-4 h-4 text-neutral-300 dark:text-neutral-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            <!-- Review text -->
                            <p class="text-neutral-700 dark:text-neutral-300 text-sm leading-relaxed">
                                {{ $review->review }}
                            </p>

                            <!-- Review attachments -->
                            @if ($review->image1 || $review->image2 || $review->image3)
                                <div class="flex gap-3 mt-1">
                                    @if ($review->image1)
                                        <div
                                            class="h-20 w-20 border border-secondary dark:border-slate-800 cursor-pointer bg-neutral-100 dark:bg-zinc-900 hover:opacity-90 transition-opacity">
                                            <img class="object-cover h-full w-full" src="{{ asset('storage/' . $review->image1) }}"
                                                alt="Review attachment" />
                                        </div>
                                    @endif
                                    @if ($review->image2)
                                        <div
                                            class="h-20 w-20 border border-secondary dark:border-slate-800 cursor-pointer bg-neutral-100 dark:bg-zinc-900 hover:opacity-90 transition-opacity">
                                            <img class="object-cover h-full w-full" src="{{ asset('storage/' . $review->image2) }}"
                                                alt="Review attachment" />
                                        </div>
                                    @endif
                                    @if ($review->image3)
                                        <div
                                            class="h-20 w-20 border border-secondary dark:border-slate-800 cursor-pointer bg-neutral-100 dark:bg-zinc-900 hover:opacity-90 transition-opacity">
                                            <img class="object-cover h-full w-full" src="{{ asset('storage/' . $review->image3) }}"
                                                alt="Review attachment" />
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12 text-neutral-400 dark:text-neutral-500">
                        <i class="fa-regular fa-comments text-4xl mb-3 block"></i>
                        <span>No reviews yet for this product.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Video Review Popup Modal -->
    <div x-show="isVideoOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 transition duration-300"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <!-- Overlay Close -->
        <div class="absolute inset-0 cursor-pointer" x-on:click="isVideoOpen = false"></div>

        <!-- Modal Content Container -->
        <div x-show="isVideoOpen" class="w-full max-w-4xl shadow-2xl relative z-10"
            x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100" x-transition:leave="ease-in duration-200 transform"
            x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-95 opacity-0">

            <!-- Close trigger -->
            <button x-on:click="isVideoOpen = false"
                class="absolute -top-10 right-0 text-white hover:text-primary transition-colors text-lg font-bold flex items-center gap-1 cursor-pointer">
                <i class="fa-solid fa-xmark"></i> Close
            </button>

            <!-- Aspect Ratio Video Frame -->
            <div class="w-full aspect-video [&_iframe]:w-full [&_iframe]:h-full [&_iframe]:border-0 bg-black"
                x-html="isVideoOpen ? videoEmbed : ''">
            </div>
        </div>
    </div>
</div>
<div>
    <div
        class="grid lg:grid-cols-[40%_60%] md:grid-cols-[40%_60%] sm:grid-cols-[40%_60%] xs:grid-cols-[100%] px-8 py-10 text-black">
        <div class="px-2">
            <div class="border border-secondary dark:border-slate-800  relative overflow-hidden">
                <img class="transition duration-300 ease-in-out hover:scale-110" src="{{ $activeImage }}"
                    alt="{{ $product['title'] }}" />
            </div>
            <div class="flex justify-center mt-2">
                @foreach ($images as $media)
                    @if ($media)
                        <img class="border border-solid h-16 w-16 mx-auto cursor-pointer" src="{{ $media }}"
                            wire:click="changeActiveImage('{{ $media }}')" />
                    @endif
                @endforeach
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-semibold py-2 dark:text-white">{{ $product->title }}</h2>
            <div class="inline-flex text-sm py-2 dark:text-white">
                @php
                    $review_mean = $reviews->sum('rating') / $reviews->count();
                @endphp
                @for ($i = 0; $i < $review_mean; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 text-primary cursor-pointer">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                            clip-rule="evenodd"></path>
                    </svg>
                @endfor
                @for ($i = 0; $i < 5 - $review_mean; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 cursor-pointer text-blue-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
                        </path>
                    </svg>
                @endfor
                <small>({{ $reviews->count() }} Reviews)</small>
            </div>
            <div class="py-2 dark:text-white">{{ $product->short_desc }}</div>
            @if (count($product->stocks) == 0)
                <div class="text-3xl font-semibold text-primary py-2 uppercase">
                    Out Of Stock
                </div>
            @endif
            @if ($product->coming_soon)
                <div class="text-2xl font-semibold text-primary py-2 uppercase">
                    Coming Soon...
                </div>
            @else
                <div class="text-2xl font-semibold text-primary py-2">
                    @if (
                        $product->price_detail->discount > 0 &&
                            ($product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() ||
                                $product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                        <b>{{ $product->price_detail->country->currency }}</b>{{ number_format(round($product->price_detail->price - ($product->price_detail->price / 100) * $product->price_detail->discount), 2) }}
                        <del class="text-gray-500 text-xs">
                            {{ number_format($product->price_detail->price, 2) }}
                        </del>

                        <sup class="uppercase">-{{ $product->price_detail->discount }}% off</sup>
                    @else
                        <b>{{ $product->price_detail->country->currency }}</b>{{ number_format($product->price_detail->price, 2) }}
                    @endif
                </div>
            @endif
            @if (count($colors))
                <div>
                    <b class="float-left mr-1 dark:text-white">Colors:</b>
                    <div class="inline-block">
                        @foreach ($colors as $key => $clr)
                            <span class="inline-block pr-2 cursor-pointer" x-data="{ tooltip: false }"
                                x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                <div wire:click="fetchColorWiseImages('{{ $clr['id'] }}','{{ $clr['color_name'] }}')"
                                    @class([
                                        'rounded-full h-6 w-6 text-center hover:border-gray-800 hover:border-2',
                                        'border-gray-800 border-2' =>
                                            $clr['color_name'] == $current_color ? true : false,
                                    ])
                                    :style="`background-image: url({{ env('APP_URL') . '/storage/' . $clr['color_image'] }})`">
                                </div>
                                <small x-show="tooltip"
                                    class="absolute bg-black px-2 py-1 text-white rounded mt-1 text-xs">
                                    {{ $clr['color_name'] }}
                                </small>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (!$product->coming_soon && $product->stocks->count() > 0)
                <div class="grid grid-cols-[25%_75%] py-2">
                    <div class="flex lg:flex-col md:flex-col sm:flex-col lg:gap-1 md:gap-1 sm:gap-1">
                        <div @dblclick.prevent class="flex items-center">
                            <button wire:click="decrementQty({{ $qty - 1 }})"
                                class="flex h-10 items-center justify-center  px-4 py-2 bg-primary text-white"
                                aria-label="subtract">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </button>
                            <input wire:model="qty" value="{{ $qty }}" id="counterInput" type="text"
                                class="border-x-none h-10 w-20 rounded-none border-y border-secondary bg-secondary text-center text-black"
                                readonly />
                            <button wire:click="incrementQty({{ $qty + 1 }})"
                                class="flex h-10 items-center justify-center  px-4 py-2 text-white bg-primary"
                                aria-label="add">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="2" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="text-start">
                        <button wire:click="addToCart('{{ $product['slug'] }}')" wire:loading.attr="disabled"
                            class="bg-primary text-white py-2 px-4 cursor-pointer w-1/3">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <svg wire:loading wire:target="addToCart('{{ $product['slug'] }}')" aria-hidden="true"
                                role="status" class="inline mr-1 w-4 h-4 text-primary animate-spin"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="#E5E7EB"></path>
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentColor"></path>
                            </svg>
                            Add to Cart
                        </button>
                    </div>

                </div>
            @endif

            <div class="py-2 dark:text-white">
                <b>Share on:</b>
                <iframe width="720" height="315"
                    src="https://www.youtube.com/embed/hxaCTjYS9vA?si=Gedd7Xnr-QuyRL08" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                @isset(website()->socialMedia)
                    @foreach (website()->socialMedia as $social)
                        <a class="mr-3 hover:text-primary" target="_blank" href="{{ $social->url }}"><i
                                class="{{ $social->class }}"></i></a>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
    <hr class="mt-5 dark:to-slate-800" />
    <div class="px-8 text-black" x-data="{ tab: 0 }">
        <div class="flex dark:text-white">
            <button class="px-4 py-2 w-full hover:text-primary focus:text-primary"
                x-on:click.prevent="tab = 0">Description</button>
            <button class="px-4 py-2 w-full hover:text-primary focus:text-primary"
                x-on:click.prevent="tab = 1">Reviews</button>
        </div>
        <div class="dark:text-white trix-editor" x-show="tab === 0">
            {!! $product->description !!}
        </div>
        <div x-show="tab === 1">
            @if (count($reviews))
                @foreach ($reviews as $review)
                    <div class="border-b py-2 border-secondary dark:text-white">
                        <div class="inline-flex text-sm">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 text-primary cursor-pointer">
                                    <path fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endfor
                            @if ($review->rating < 5)
                                @for ($i = 0; $i < 5 - $review->rating; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 cursor-pointer text-blue-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
                                        </path>
                                    </svg>
                                @endfor
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">Test User</div>
                        <div>{{ $review->review }}</div>
                        <div class="flex mt-1">
                            @if ($review->image1)
                                <img class="border border-solid h-16 mx-2 w-16 cursor-pointer"
                                    src="{{ asset('storage/' . $review->image1) }}" alt="" />
                            @endif
                            @if ($review->image2)
                                <img class="border border-solid h-16 mx-2 w-16 cursor-pointer"
                                    src="{{ asset('storage/' . $review->image2) }}" alt="" />
                            @endif
                            @if ($review->image3)
                                <img class="border border-solid h-16 mx-2 w-16 cursor-pointer"
                                    src="{{ asset('storage/' . $review->image3) }}" alt="" />
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

<div class="border border-secondary dark:border-slate-800">

    <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary group">
        @if ($product->price_detail && $product->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $product->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $product->price_detail->discount_to))
            <div
                class="absolute right-0 top-0 z-10 w-auto px-2 py-1 bg-green-600 text-white text-center text-1xl font-extrabold">
                - {{ $product->price_detail->discount }} %
            </div>
        @endif

        {{-- Primary image --}}
        <img src="{{ asset('storage/' . $product->image) }}" class="transition-opacity duration-300 ease-in-out hover:scale-110 w-full
                   {{ $product->image1 ? 'group-hover:opacity-0' : '' }}" alt="{{ $product->title }}" />

        {{-- Hover image (only rendered if image1 exists) --}}
        @if ($product->image1)
            <img src="{{ asset('storage/' . $product->image1) }}" class="absolute inset-0 w-full h-full object-cover
                           opacity-0 group-hover:opacity-100
                           transition-opacity duration-300 ease-in-out" alt="{{ $product->title }} - alternate view" />
        @endif
    </div>

    <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
        <h1>
            <a href="{{ route('product.detail', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
        </h1>
        @if($product->coming_soon)
            <h2 class="text-primary"><b>Coming Soon</b></h2>
        @else
            @if ($product->price_detail)
                <h2><b>
                        @if ($product->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $product->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $product->price_detail->discount_to))
                            {{ $product->price_detail->country->currency }}
                            {{ number_format(round($product->price_detail->price - ($product->price_detail->price / 100 * $product->price_detail->discount)), 2) }}
                        @else
                            {{ $product->price_detail->country->currency }} {{ number_format($product->price_detail->price, 2) }}
                        @endif
                    </b>
                    @if ($product->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $product->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $product->price_detail->discount_to))
                        <del class="text-gray-500">
                            {{ $product->price_detail->country->currency }} {{ number_format($product->price_detail->price, 2) }}
                        </del>
                    @endif
                </h2>
            @endif
        @endif
    </div>

</div>
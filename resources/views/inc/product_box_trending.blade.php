
<div class="text-center relative dark:text-secondary">
    @if (
        $pr->price_detail &&
            $pr->price_detail->discount > 0 &&
            (Carbon\Carbon::today()->toDateString() >= $pr->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $pr->price_detail->discount_to))
        <div
            class="absolute right-0 top-0 w-auto px-2  py-1 bg-green-600 text-white text-center text-1xl font-extrabold">
            - {{ $pr->price_detail->discount }} %
        </div>
    @endif
    <img src="{{ asset('storage/' . $pr->image) }}" {{-- class=" max-h-52" --}}
        alt="{{ $pr->title }}" />
    <div class="pt-2 overflow-hidden max-w-36 text-xs truncate text-left">
        {{ $pr->title }}
    </div>
    @if ($pr->coming_soon)
        <p class="text-primary text-xs text-left"><b>Coming Soon</b></p>
    @else
        @if ($pr->price_detail && $pr->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $pr->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $pr->price_detail->discount_to))
            <div class="text-xs text-left">
                <b>{{ $pr->price_detail->country->currency }}</b>
                {{ number_format(round($pr->price_detail->price - ($pr->price_detail->price / 100) * $pr->price_detail->discount), 2) }}
                <del class="text-gray-500">
                    {{ $pr->price_detail->country->currency }}
                    {{ number_format($pr->price_detail->price, 2) }}
                </del>
            </div>
        @else
            <div class="text-xs text-left">
                <b>{{ $pr->price_detail->country->currency }}</b>
                {{ number_format($pr->price_detail->price, 2) }}
            </div>
        @endif
        <div class="w-full">
            <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary my-2"
                href="{{ route('product.detail', ['slug' => $pr->slug]) }}">
                <i class="fa-regular fa-eye text-primary"></i>
                View Detail
            </a>
            {{-- <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary  my-2" href="">
                        <i class="fa-solid fa-cart-shopping text-primary"></i>
                        Add to Cart
                    </a> --}}
        </div>
    @endif
</div>
               
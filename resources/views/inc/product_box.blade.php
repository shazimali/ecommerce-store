<div class="border border-secondary dark:border-slate-800">

    <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
        @if ($product->price_detail && $product->price_detail->discount > 0 &&  ($product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
        <div
            class="absolute right-0 top-0 w-auto px-2  py-1 bg-green-600 text-white text-center text-1xl font-extrabold">
            - {{ $product->price_detail->discount }} <br/> %
        </div>
        @endif
        <img src="{{ asset('storage/'. $product->image) }}"
            class="transition duration-300 ease-in-out hover:scale-110" alt="title" />
    </div>
    <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
        <h1>
            <a href="{{ route('product.detail',['slug' => $product->slug]) }}">{{ $product->title }}</a>
        </h1>
        @if($product->coming_soon)
        <h2 class="text-primary"><b>Coming Soon</b></h2>
        @else
            @if ( $product->price_detail)
            <h2><b>
                @if ($product->price_detail->discount > 0 &&  ($product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                {{ $product->price_detail->country->currency }} {{ number_format(round($product->price_detail->price - ($product->price_detail->price/100*$product->price_detail->discount)),2)  }}
                @else
                {{ $product->price_detail->country->currency }} {{  number_format($product->price_detail->price,2)  }}
                @endif
                </b>
                @if ($product->price_detail->discount > 0 &&  ($product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                <del class="text-gray-500">
                    {{ $product->price_detail->country->currency }} {{ number_format($product->price_detail->price,2) }}
                </del>
                @endif
                
            </h2>  
            @endif
        @endif

    </div>

</div>
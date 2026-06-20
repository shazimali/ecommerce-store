<a href="{{ route('bundle.detail', ['slug' => $bundle->slug]) }}" class="block border border-secondary dark:border-slate-800 group hover:border-primary/60 dark:hover:border-primary/60 hover:shadow-lg hover:-translate-y-1 bg-white dark:bg-slate-950 transition-all duration-300">

    <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
        @if ($bundle->price_detail && $bundle->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $bundle->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $bundle->price_detail->discount_to))
            <div
                class="absolute right-0 top-0 z-10 w-auto px-2 py-1 bg-green-600 text-white text-center text-[10px] font-extrabold">
                - {{ $bundle->price_detail->discount }} %
            </div>
        @endif

        {{-- Primary image --}}
        <img src="{{ asset('storage/' . $bundle->image) }}" class="transition duration-300 ease-in-out group-hover:scale-110 w-full
                   {{ $bundle->image1 ? 'group-hover:opacity-0' : '' }}" alt="{{ $bundle->title }}" />

        {{-- Hover image (only rendered if image1 exists) --}}
        @if ($bundle->image1)
            <img src="{{ asset('storage/' . $bundle->image1) }}" class="absolute inset-0 w-full h-full object-cover
                           opacity-0 group-hover:opacity-100
                           transition-opacity duration-300 ease-in-out" alt="{{ $bundle->title }} - alternate view" />
        @endif
    </div>

    <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
        <h1 class="group-hover:text-primary transition-colors duration-300">
            {{ $bundle->title }}
        </h1>
        @if($bundle->coming_soon)
            <h2 class="text-primary"><b>Coming Soon</b></h2>
        @else
            @if ($bundle->price_detail)
                <h2><b>
                        @if ($bundle->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $bundle->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $bundle->price_detail->discount_to))
                            {{ $bundle->price_detail->country->currency }}
                            {{ number_format(round($bundle->price_detail->price - ($bundle->price_detail->price / 100 * $bundle->price_detail->discount)), 2) }}
                        @else
                            {{ $bundle->price_detail->country->currency }} {{ number_format($bundle->price_detail->price, 2) }}
                        @endif
                    </b>
                    @if ($bundle->price_detail->discount > 0 && (Carbon\Carbon::today()->toDateString() >= $bundle->price_detail->discount_from && Carbon\Carbon::today()->toDateString() <= $bundle->price_detail->discount_to))
                        <del class="text-gray-500">
                            {{ $bundle->price_detail->country->currency }} {{ number_format($bundle->price_detail->price, 2) }}
                        </del>
                    @endif
                </h2>
            @endif
        @endif
    </div>

</a>

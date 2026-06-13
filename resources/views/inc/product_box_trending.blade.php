<div class="text-center relative dark:text-secondary group">
    @php
        $prPrice = $pr['price_detail'] ?? null;
        $prCountry = $prPrice['country'] ?? null;
        $hasDiscount = $prPrice && ($prPrice['discount'] ?? 0) > 0 &&
            isset($prPrice['discount_from'], $prPrice['discount_to']) &&
            (Carbon\Carbon::today()->toDateString() >= $prPrice['discount_from'] &&
             Carbon\Carbon::today()->toDateString() <= $prPrice['discount_to']);
    @endphp

    @if ($hasDiscount)
        <div class="absolute right-0 top-0 z-10 w-auto px-2 py-1 bg-green-600 text-white text-center text-1xl font-extrabold">
            - {{ $prPrice['discount'] }} %
        </div>
    @endif

    {{-- Image wrapper --}}
    <div class="relative overflow-hidden">
        {{-- Primary image --}}
        <img src="{{ asset('storage/' . ($pr['image'] ?? '')) }}"
            class="w-full transition-opacity duration-300 ease-in-out {{ ($pr['image1'] ?? '') ? 'group-hover:opacity-0' : '' }}"
            alt="{{ $pr['title'] ?? '' }}" />

        {{-- Hover image --}}
        @if ($pr['image1'] ?? '')
            <img src="{{ asset('storage/' . $pr['image1']) }}"
                class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out"
                alt="{{ ($pr['title'] ?? '') }} - alternate view" />
        @endif
    </div>

    <div class="pt-2 overflow-hidden max-w-36 text-xs truncate text-left">
        {{ $pr['title'] ?? '' }}
    </div>
    @if ($pr['coming_soon'] ?? false)
        <p class="text-primary text-xs text-left"><b>Coming Soon</b></p>
    @else
        @if ($prPrice)
            @if ($hasDiscount)
                <div class="text-xs text-left">
                    <b>{{ $prCountry['currency'] ?? '' }}</b>
                    {{ number_format(round(($prPrice['price'] ?? 0) - (($prPrice['price'] ?? 0) / 100) * ($prPrice['discount'] ?? 0)), 2) }}
                    <del class="text-gray-500">
                        {{ $prCountry['currency'] ?? '' }}
                        {{ number_format($prPrice['price'] ?? 0, 2) }}
                    </del>
                </div>
            @else
                <div class="text-xs text-left">
                    <b>{{ $prCountry['currency'] ?? '' }}</b>
                    {{ number_format($prPrice['price'] ?? 0, 2) }}
                </div>
            @endif
        @endif
        <div class="w-full">
            <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary my-2"
                href="{{ route('product.detail', ['slug' => $pr['slug'] ?? '']) }}">
                <i class="fa-regular fa-eye text-primary"></i>
                View Detail
            </a>
        </div>
    @endif
</div>
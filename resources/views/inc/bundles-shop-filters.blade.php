<a class="text-xs cursor-pointer hover:text-primary 
    hover:underline dark:text-white dark:hover:text-primary"
    href="{{ route('bundles.shop') }}">
    clear all filters
</a>

@if(count($colors) > 0)
<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white mt-5">Filter by colors</h3>
<ul>
    @foreach ($colors as $clr)
        <li class="py-2">
            <input class=" hover:bg-primary checked:bg-primary 
                            focus:bg-primary focus:ring-opacity-25 
                            focus:ring-primary border-gray-500 dark:text-white" 
                            type="radio"
                            wire:click="updateFilter('color','{{ $clr->color_name }}')"
                            name="color"
                            wire:key="{{ $clr->color_name }}"
                            {{ $color == $clr->color_name ? 'checked' : '' }}
                            value="{{ $clr->color_name }}"
                            >
            <label class="lg:text-sm md:text-sm sm:text-xs xs:text-xs pl-2 font-semibold dark:text-white">{{ $clr->color_name }}</label>
        </li>
    @endforeach
</ul>
@endif

<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white mt-5">Filter by price</h3>
<div class="py-3 pr-5">
    <input type="range" min="0" max="10000" step="50" wire:model="price_from" wire:change="updateFilter('price_from',$event.target.value)" class="w-full">
    <div class="flex justify-between py-2 dark:text-white">
        <span><b>{{ getLocation()->currency }}</b> {{ $price_from }}</span>
        <span><b>{{ getLocation()->currency }}</b> {{ $price_to }}</span>
    </div>
</div>

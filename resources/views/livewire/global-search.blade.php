<div class="relative text-black dark:text-white">
    <div class="flex justify-center">
        <input wire:model.live="search" type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Search For Products"
            name="hs-trailing-button-add-on-multiple-add-ons"
            class="py-3 px-4 block text-sm border border-secondary lg:w-full md:w-full dark:bg-black dark:border-slate-800">
        <i class="-ml-7 mt-4 text-primary fas fa-search"></i>
    </div>
    <div wire:show="search" class="mx-1 p-1 absolute min-w-full bg-white dark:bg-black dark:text-white border border-secondary dark:border-slate-800 min-h-20 z-50">
        @if (count($products))
            @foreach ($products as $product)
            <div class="flex justify-start py-2">
                <img class="h-10 w-10" src="{{ asset('storage/'.$product->image) }}" alt="">
                <span class="text-sm">{{ $product->title }}</span>
            </div>
            @endforeach
        @else
        <span>No Record Found.</span> 
        @endif
       
    </div>
</div>

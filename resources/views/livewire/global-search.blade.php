<div class="relative text-black dark:text-white">
    <div class="flex justify-center">
        <input wire:model.live="search" type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Search For Products"
            name="hs-trailing-button-add-on-multiple-add-ons"
            class="placeholder-black dark:placeholder-white lg:py-3 md:py-3 sm:py-2 xs:py-2  lg:px-4 md:px-4 sm:px-2 xs:px-2 block text-sm border border-secondary w-full dark:bg-black dark:border-slate-800">
            <i class="lg:-ml-7 md:-ml-7 sm:-ml-[1.4rem] xs:-ml-[1.4rem] lg:mt-4 md:mt-4  sm:mt-[0.7rem] xs:mt-[0.7rem] text-primary fas fa-search"></i>
    </div>
    <div wire:show="search" class="mx-1 p-1 absolute min-w-full bg-white dark:bg-black dark:text-white border border-secondary dark:border-slate-800 min-h-20 z-50">
        @if (count($products))
            @foreach ($products as $product)
            <div class="flex justify-start py-2">
                <img class="h-10 w-10" src="{{ asset('storage/'.$product->image) }}" alt="">
                <a href="{{ route('product.detail',['slug' => $product->slug]) }}" class="text-sm pt-2">{{ $product->title }}</a>
            </div>
            @endforeach
        @else
        <span>No Record Found.</span> 
        @endif
       
    </div>
</div>

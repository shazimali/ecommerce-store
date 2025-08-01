<div class="grid lg:grid-cols-[25%_75%] md:grid-cols-[25%_75%] xs:grid-col-1 py-10 px-8 text-black">
    <div class="xs:hidden lg:block md:block">
       @include('inc.shop-filters')
    </div>
    <div>
        <div class="flex justify-between">
            <div class="drawer drawer-end lg:hidden md:hidden sm:block xs:block">
                <input id="shop-mobile-filter" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content mt-3 cursor-pointer">
                    <label for="shop-mobile-filter"
                        class="px-10 drawer-button text-primary border border-solid border-secondary dark:border-slate-800 py-3">
                        <i class="fa-solid fa-filter"></i>
                        <span class="text-black dark:text-white text-sm">Filters</span>
                    </label>
                </div>

                <div class="drawer-side text-black">
                    <label for="shop-mobile-filter" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="menu  bg-white dark:bg-black min-h-full w-1/2 p-4 text-start">
                        <div class="border-b border-b-secondary dark:border-b-slate-800">
                            <h1 class="uppercase text-1xl dark:text-white font-semibold pb-1">Shop Filters</h1>
                            @include('inc.shop-filters')
                        </div>           
                    </div>
                </div>
            </div>
            {{ $products->links() }}
            <select wire:model="sort_by" wire:change="updateSortBy($event.target.value)" name="sort_by" class="px-10 block text-sm  border border-secondary   dark:bg-black dark:text-white dark:border-slate-800">
                <option value="">Sort by</option>
                <option value="new">New</option>
                <option value="featured">Featured</option>
            </select>
        </div>
        <div class="mt-5 grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-2 gap-5">
            @foreach ($products as $key => $product)
            @include('inc.product_box')
            @endforeach
        </div>
    </div>
</div>


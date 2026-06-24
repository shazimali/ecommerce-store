<div class="grid grid-cols-1 md:grid-cols-[25%_75%] gap-8 py-10 px-8 text-black dark:text-white">
    <div class="hidden md:block pr-6 border-r border-slate-100 dark:border-slate-800">
       @include('inc.shop-filters')
    </div>
    <div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-4 mb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="drawer drawer-end md:hidden z-50">
                <input id="shop-mobile-filter" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content mt-1 cursor-pointer">
                    <label for="shop-mobile-filter"
                        class="px-6 drawer-button text-primary border border-solid border-slate-200 dark:border-slate-800 py-2.5 rounded-lg inline-flex items-center gap-2 bg-slate-50 dark:bg-slate-900">
                        <i class="fa-solid fa-filter"></i>
                        <span class="text-slate-800 dark:text-white text-sm font-semibold">Filters</span>
                    </label>
                </div>

                <div class="drawer-side text-black">
                    <label for="shop-mobile-filter" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="menu bg-white dark:bg-black min-h-full w-2/3 p-6 text-start shadow-xl">
                        <div class="border-b border-slate-200 dark:border-slate-800 mb-4 pb-2">
                            <h1 class="uppercase text-lg dark:text-white font-bold tracking-wider">Filters</h1>
                        </div>    
                        @include('inc.shop-filters')
                    </div>
                </div>
            </div>
            <select wire:model="sort_by" wire:change="updateSortBy($event.target.value)" name="sort_by" class="w-full md:w-auto px-6 py-2.5 block text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-slate-700 dark:text-slate-200 font-medium">
                <option value="">Sort by</option>
                <option value="new">New</option>
                <option value="featured">Featured</option>
                <option value="trending">Trending</option>
                <option value="sale">Sale</option>
            </select>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $key => $product)
            @include('inc.product_box')
            @endforeach
        </div>
        <div class="py-6">
            {{ $products->links() }}
        </div>

    </div>
</div>


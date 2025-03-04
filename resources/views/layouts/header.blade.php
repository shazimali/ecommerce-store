<div class="sticky lg:block md:block xs:hidden top-0 z-50">
    @include('inc.news')
    @include('inc.header_with_info')
    <div
        class="grid lg:grid-cols-3 md:grid-cols-3 py-5 px-8 bg-white border-secondary border-b dark:bg-black dark:border-b-slate-800">
        <div class="text-4xl font-semibold">
            <a href="{{ route('home') }}">
                <span class="text-primary dark:text-secondary">Every Day</span>
                <span class="dark:text-primary">{{ website()->title }}</span>
            </a>
        </div>
        <div class="flex justify-center">
            <input type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Search For Products"
                name="hs-trailing-button-add-on-multiple-add-ons"
                class="py-3 px-4 block text-sm border border-secondary lg:w-full md:w-full dark:bg-black dark:border-slate-800">
            <i class="-ml-7 mt-4 text-primary fas fa-search"></i>
        </div>
        <div class="text-end">
            {{-- <livewire:partials.cart-button /> --}}
            <div class="drawer drawer-end">
                <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content mt-3 cursor-pointer">
                    <label for="my-drawer-4"
                        class="drawer-button text-primary border border-solid border-secondary dark:border-slate-800 py-3 px-6">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="text-gray-500 text-sm font-semibold">0</span>
                    </label>
                </div>

                <div class="drawer-side">
                    <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
                    <div class="menu  bg-white dark:bg-black min-h-full w-96 p-4 text-start">
                        <div class="flex justify-between border-b border-b-secondary dark:border-b-slate-800">
                            <h1 class="uppercase text-1xl dark:text-white font-semibold pb-1">your Cart (0)</h1>
                        </div>
                        <h3 class=" dark:text-white">Your cart is currently empty.</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="sticky top-0 z-50 xs:block lg:hidden md:hidden">
    @include('inc.news')
    @include('inc.header_with_info')
    <div class="flex bg-white justify-between py-2 px-2 dark:bg-black dark:border-b-slate-800">
        {{-- <livewire:partials.wish-list /> --}}
        {{-- <livewire:partials.cart-button /> --}}
        <div
            class="text-primary cursor-pointer border border-solid border-secondary dark:border-slate-800 py-2 px-6 mx-3">
            <i class="fas fa-search"></i>
        </div>
        @include('inc.social_icons')
        @include('inc.theme_changer')
    </div>
</div>

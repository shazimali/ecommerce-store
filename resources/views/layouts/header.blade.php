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
          <livewire:cart-side-bar/>
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
        <div>
            <livewire:mobile-cart-side-bar/>
        </div>
        @include('inc.social_icons')
        @include('inc.theme_changer')
    </div>
</div>

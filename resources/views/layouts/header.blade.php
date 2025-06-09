<div class="sticky lg:block md:block xs:hidden top-0 z-50">
    @include('inc.news')
    @include('inc.header_with_info')
    <div
        class="grid lg:grid-cols-3 md:grid-cols-3 py-5 px-8 bg-white border-secondary border-b dark:bg-black dark:border-b-slate-800">
        <div class="text-4xl font-semibold">
            <a href="{{ route('home') }}">
                <span class="text-primary dark:text-secondary">Every Day</span>
                <span class="dark:text-primary text-black">{{ website()->title }}</span>
            </a>
        </div>
        <livewire:global-search/>
        <div class="text-end">
          <livewire:cart-side-bar/>
        </div>
    </div>
</div>

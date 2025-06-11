<div class="relative w-full overflow-hidden col-span-2 mt-6 lg:block md:block sm:hidden xs:hidden">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach (website()->banners as $banner)
            <div class="swiper-slide">
                <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}">
            </div> 
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="relative w-full overflow-hidden col-span-2 mt-6 lg:hidden md:hidden sm:block xs:block">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach (website()->banners as $banner)
            <div class="swiper-slide">
                <img src="{{ asset('storage/'.$banner->mob_image) }}" alt="{{ $banner->title }}">
            </div> 
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>


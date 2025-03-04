<div class="relative w-full overflow-hidden col-span-2 mt-6">
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

<!-- Slider Section -->
 <section class="overflow-hidden">

    <div class="swiper-container lg:px-6 md:px-6 sm:px-2 xs:px-2">
      <div class="swiper-wrapper">
        @foreach (website()->categories as $category)
        @foreach ($category->front_sub_categories as $sub_cat)
        <div class="swiper-slide">
          <div
            class="bg-white dark:bg-black overflow-hidden cursor-pointer group px-[12px] pt-[12px] pb-[32px]"
          >
            <div class="aspect-w-16 aspect-h-9 relative">
              <img
                src="{{ asset('storage/'.$sub_cat->image) }}"
                alt="{{ $sub_cat->title }}"
                class="w-full h-full object-cover"
              />
            </div>
            <div class="pt-4 px-0 pb-0 flex flex-col items-center">
              {{-- <span class="text-gray-500 text-sm">Products ({{ $sub_cat->product_heads->where('status','ACTIVE')->count() }})</span> --}}
              <a href="{{ route('sub-categories',[$sub_cat->slug]) }}">
                <h3 class="dark:text-secondary text-xl font-semibold mt-2 group-hover:text-primary transition-colors w-full">
                  {{ $sub_cat->title }}
                </h3>
              </a>
            </div>
          </div>
        </div>
      @endforeach

        @endforeach
      </div>
    </div>
  </section>

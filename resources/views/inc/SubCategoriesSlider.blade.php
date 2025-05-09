 <!-- Slider Section -->
 <section class="overflow-hidden">
    <div
      class="container xl:max-w-screen-xl 2xl:max-w-screen-2xl px-4 mx-auto sm:px-6"
    >
      <div class="mb-16">
        <div
          class="flex justify-end items-center gap-4 mt-6 md:flex-row flex-col text-center sm:text-left"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          <!-- Pagination -->
          <div class="relative flex justify-center items-center gap-2">
            <button
              class="custom-prev-btn whitespace-nowrap text-base leading-6 font-normal bg-transparent text-brand-blue hover:bg-primary hover:text-white border border-brand-blue rounded-full font-lato transition-all duration-300 ease-in-out px-4 py-4 cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="25"
                height="25"
                fill="none"
                style="transform: rotate(180deg)"
              >
                <path
                  d="M20.0001 11.9998L4.00012 11.9998"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M15.0003 17C15.0003 17 20.0002 13.3176 20.0002 12C20.0002 10.6824 15.0002 7 15.0002 7"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
            <button
              class="custom-next-btn whitespace-nowrap text-base leading-6 font-normal bg-transparent text-brand-blue hover:bg-primary hover:text-white border border-brand-blue rounded-full font-lato transition-all duration-300 ease-in-out px-4 py-4 cursor-pointer"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="25"
                height="25"
                fill="none"
              >
                <path
                  d="M20.0001 11.9998L4.00012 11.9998"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M15.0003 17C15.0003 17 20.0002 13.3176 20.0002 12C20.0002 10.6824 15.0002 7 15.0002 7"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Swiper -->
    <div class="swiper-container px-6 md:px-0">
      <div class="swiper-wrapper">
        @foreach (website()->categories as $category)
        @foreach ($category->sub_categories as $sub_cat)
        <div class="swiper-slide">
          <div
            class="bg-white border border-secondary overflow-hidden cursor-pointer group px-[12px] pt-[12px] pb-[32px]"
          >
            <div class="aspect-w-16 aspect-h-9 relative">
              <img
                src="{{ asset('storage/'.$sub_cat->image) }}"
                alt="{{ $sub_cat->title }}"
                class="w-full h-full object-cover"
              />
            </div>
            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
              {{-- <span class="text-gray-500 text-sm">Products ({{ $sub_cat->product_heads->where('status','ACTIVE')->count() }})</span> --}}
              <a href="{{ route('sub-categories',[$sub_cat->slug]) }}">
                <h3 class="text-center text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
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

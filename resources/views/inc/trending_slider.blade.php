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
    <div class="trending-swiper-container lg:px-6 md:px-6 sm:px-2 xs:px-2">
      <div class="swiper-wrapper">
        @foreach ($trending_products as $product)
        <div class="swiper-slide">
             <div class="bg-white dark:bg-black">
                @include('inc.product_box')
             </div>
        </div>
      @endforeach
      </div>
    </div>
  </section>

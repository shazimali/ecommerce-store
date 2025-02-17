@extends('layouts.app')
@section('content')
    <div class="lg:block md:block xs:hidden top-0 z-50">
        <div class="flex flex-col items-center justify-center">
            <marquee class="bg-primary">
                <small>
                    Everyday Plastic-Best Quality Products
                </small>
            </marquee>
        </div>

        <div
            class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 xs:grid-cols-1 bg-secondary dark:bg-black py-2 px-8 font-normal dark:border-b dark:border-b-slate-800">
            <div class="hidden md:block lg:block">
                <a class="hover:text-primary dark:text-secondary border-solid border-black dark:border-secondary }}  dark:hover:text-primary"
                    href="">
                    <i class="fa-solid fa-phone text-primary  dark:hover:text-primary"></i>&nbsp;
                    0345768656
                </a>
                <a class="hover:text-primary dark:text-secondary pl-3 dark:hover:text-primary" href="">
                    <i class="fa-solid fa-envelope text-primary  dark:hover:text-primary"></i>&nbsp;
                    plastic@gmail.com
                </a>
            </div>

            <div
                class="text-center bg-gradient-to-r from-orange-200  via-red-500 to-violet-600 bg-clip-text text-transparent font-semibold">
                Welcome to Every Day Plastic
            </div>
            <div class="hidden md:block lg:block text-end text-black dark:text-primary">
                <a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
                    href="https://www.facebook.com/everydayoffcl"><i class="fa-brands fa-facebook"></i></a>
                <a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
                    href="https://www.instagram.com/everydayoffcl/"><i class="fa-brands fa-instagram"></i></a>
                <a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
                    href="https://twitter.com/EverydayOffcl"><i class="fa-brands fa-x-twitter"></i></a>
                <a class="mr-3 dark:text-primary hover:text-primary py-2" target="_blank"
                    href="https://youtube.com/@everydayoffcl"><i class="fa-brands fa-youtube"></i></a>

                <button @click="darkMode = !darkMode"
                    class="border-l-2 border-solid border-black dark:border-primary dark:border-solid dark:border-l-2 pl-3">
                    <i x-show="!darkMode" class="fa-solid fa-moon text-black dark:text-primary"></i>
                    <i x-show="darkMode" class="fa-solid fa-sun text-secondary dark:text-primary"></i>
                </button>
            </div>
        </div>

        <div
            class="grid lg:grid-cols-3 md:grid-cols-3 py-5 px-8 bg-white border-secondary border-b dark:bg-black dark:border-b-slate-800">
            <div class="text-4xl font-semibold">
                <a href="">
                    <span class="text-primary dark:text-secondary">Rana Abid</span>
                    <span class="dark:text-primary">Ali</span>
                </a>
            </div>
            <div class="flex justify-center">
                <input type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Search For Products"
                    name="hs-trailing-button-add-on-multiple-add-ons"
                    class="py-3 px-4 block text-sm border border-secondary lg:w-full md:w-full dark:bg-black dark:border-slate-800">
                <i class="-ml-7 mt-4 text-primary fas fa-search"></i>
            </div>
            <div class="text-end">
                <div class="drawer drawer-end">
                    <input id="" type="checkbox" class="drawer-toggle" />
                    <div class="drawer-content mt-3 cursor-pointer">
                        <label for="my-drawer-4"
                            class="drawer-button text-primary border border-solid border-secondary dark:border-slate-800 py-3 px-6">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="text-gray-500 text-sm font-semibold">0</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>



        {{-- navbar code start --}}
        <div>
            <div x-data="{ menu: true, sideBarOpen: false, newArOpen: false }" class="lg:block md:block sm:hidden xs:hidden">
                <div class="grid lg:grid-cols-4 md:grid-cols-4 gap-5 px-8">
                    <div class="w-full">
                        <ul>
                            <li x-on:click="menu = ! menu"
                                class="bg-primary block py-5 font-normal pl-5 border-secondary dark:text-white dark:border-slate-800 border-b">
                                Collections
                                <div class="float-end inline-block pr-5">
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </li>
                            <li x-show="menu" x-transition.duration.300ms @class(['z-50'])>

                            </li>
                            <ul>
                                {{-- @foreach ($global_categories as $category) --}}
                                {{-- <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true;"
                                    x-on:mouseleave="sideBarOpen = false;"
                                    class="relative cursor-pointer pl-5 block font-normal py-2 border-secondary border-b border-l border-r dark:text-secondary dark:border-slate-800 dark:bg-black">
                                    Spice Rocks
                                    <div class="float-end inline-block pr-5">
                                        <i class="fa-solid fa-caret-right"></i>
                                    </div>

                                </li> --}}
                                {{-- @endforeach --}}
                            </ul>

                        </ul>
                    </div>

                    <div class="col-span-3 grid grid-cols-2 py-5 dark:bg-black relative">
                        <ul class="flex">
                            <li class="mr-6">
                                <a @class([
                                    'hover:text-primary dark:text-secondary dark:hover:text-primary',
                                    'text-primary',
                                ]) href="#">Home</a>
                            </li>
                            {{-- @if (count($global_new_products) > 0) --}}
                            <li x-on:click="newArOpen = ! newArOpen" class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">
                                    New Arrivals <i class="fa-solid fa-caret-down"></i>
                                </a>
                            </li>
                            {{-- @endif --}}
                            <li class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                                    href="#">Shop</a>
                            </li>
                            <li class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                                    href="#">Blogs</a>
                            </li>
                            <li class="mr-6">
                                <a @class([
                                    'hover:text-primary dark:text-secondary dark:hover:text-primary',
                                ]) href="#">About</a>
                            </li>
                            <li class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                                    href="#">Contact</a>
                            </li>
                        </ul>
                        <ul class="flex justify-end">
                            <li class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                                    href="#">Login</a>
                            </li>
                            <li class="mr-6">
                                <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                                    href="#">Register</a>
                            </li>
                        </ul>


                    </div>

                </div>
            </div>

        </div>
        {{-- navbar code  part end --}}


        {{-- carousel code part start --}}
        <div class="max-w-[1000px] mx-auto float-right">
            <div class="carousel w-[890px]">
                <div id="slide1" class="carousel-item relative w-full">
                    <img src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp"
                        class="w-[850px]" />
                    <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                        <a href="#slide4" class="btn btn-circle">❮</a>
                        <a href="#slide2" class="btn btn-circle mr-6">❯</a>
                    </div>
                </div>
                <div id="slide2" class="carousel-item relative w-full">
                    <img src="https://img.daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.webp"
                        class="w-[850px]" />
                    <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                        <a href="#slide1" class="btn btn-circle">❮</a>
                        <a href="#slide3" class="btn btn-circle mr-6">❯</a>
                    </div>
                </div>


            </div>

        </div>

        {{-- carousel code part end --}}

    </div>

    <div class="mt-[28%] grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 xs:grid-cols-2 gap-5 lg:px-8 md:px-8 xs:px-2 ">
        <div class=>
            <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-check text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">Product</h1>
            </div>

        </div>
        <div class="dark:text-secondary">
            <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-truck text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">Free Delivery</h1>
            </div>

        </div>
        <div class="dark:text-secondary">
            <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-arrow-right-arrow-left text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">7 Days Return</h1>
            </div>

        </div>
        <div class="dark:text-secondary">
            <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-phone text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">24/7 Support</h1>
            </div>

        </div>

    </div>

    {{-- categories section start --}}
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Categories</h1>
    </div>

    </div>
    <div class="grid md:grid-cols-3 lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mt-16 px-8 gap-5">

        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>

        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>
        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>
        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>
        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>
        <a href="" class="border border-secondary dark:border-slate-800">
            {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img src="{{ asset('images/chair.avif') }}"
                    class="transition duration-300 ease-in-out hover:scale-110 w-96 h-[386px]" alt="" />
            </div>
            <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">Table</h1>
        </a>


    </div>
    {{-- categories section end --}}

    {{-- Subcategories section start  --}}
    <div class="mt-16 text-center">
        <h1 class="font-bold lg:text-4xl md:text-4xl xs:text-3xl dark:text-secondary">Sub Categories Collection</h1>
    </div>

    <!-- Slider Section -->
    <section class="overflow-hidden">
        <div class="container xl:max-w-screen-xl 2xl:max-w-screen-2xl px-4 mx-auto sm:px-6">
            <div class="mb-16">
                <div class="flex justify-end items-center gap-4 mt-6 md:flex-row flex-col text-center sm:text-left"
                    data-aos="fade-up" data-aos-delay="100">
                    <!-- Pagination -->
                    <div class="relative flex justify-center items-center gap-2">
                        <button
                            class="custom-prev-btn whitespace-nowrap text-base leading-6 font-normal bg-transparent text-brand-blue hover:bg-primary hover:text-white border border-brand-blue rounded-full font-lato transition-all duration-300 ease-in-out px-4 py-4 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25"
                                fill="none" style="transform: rotate(180deg)">
                                <path d="M20.0001 11.9998L4.00012 11.9998" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M15.0003 17C15.0003 17 20.0002 13.3176 20.0002 12C20.0002 10.6824 15.0002 7 15.0002 7"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button
                            class="custom-next-btn whitespace-nowrap text-base leading-6 font-normal bg-transparent text-brand-blue hover:bg-primary hover:text-white border border-brand-blue rounded-full font-lato transition-all duration-300 ease-in-out px-4 py-4 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25"
                                fill="none">
                                <path d="M20.0001 11.9998L4.00012 11.9998" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M15.0003 17C15.0003 17 20.0002 13.3176 20.0002 12C20.0002 10.6824 15.0002 7 15.0002 7"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper -->
        <div class="swiper-container px-6 md:px-0">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="w-full flex items-center justify-center gap-4">
                        <div
                            class="bg-white border border-secondary overflow-hidden cursor-pointer px-[12px] pt-[12px] pb-[32px] group">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <img src="{{ asset('images/chair.avif') }}" alt=""
                                    class="w-52   h-52   object-cover" />
                            </div>
                            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
                                <span class="text-gray-500 text-sm">Products(1) </span>
                                <a href="" target="_blank">
                                    <h3
                                        class="text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
                                        Table
                                    </h3>

                            </div>

                        </div>
                        <div
                            class="bg-white border border-secondary overflow-hidden cursor-pointer px-[12px] pt-[12px] pb-[32px] group">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <img src="{{ asset('images/chair.avif') }}" alt=""
                                    class="w-52   h-52   object-cover" />
                            </div>
                            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
                                <span class="text-gray-500 text-sm">Products(3) </span>
                                <a href="" target="_blank">
                                    <h3
                                        class="text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
                                        Table
                                    </h3>

                            </div>

                        </div>
                        <div
                            class="bg-white border border-secondary overflow-hidden cursor-pointer px-[12px] pt-[12px] pb-[32px] group">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <img src="{{ asset('images/chair.avif') }}" alt=""
                                    class="w-52   h-52   object-cover" />
                            </div>
                            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
                                <span class="text-gray-500 text-sm">Products(9) </span>
                                <a href="" target="_blank">
                                    <h3
                                        class="text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
                                        Table
                                    </h3>

                            </div>

                        </div>
                        <div
                            class="bg-white border border-secondary overflow-hidden cursor-pointer px-[12px] pt-[12px] pb-[32px] group">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <img src="{{ asset('images/chair.avif') }}" alt=""
                                    class="w-52   h-52   object-cover" />
                            </div>
                            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
                                <span class="text-gray-500 text-sm">Products(6) </span>
                                <a href="" target="_blank">
                                    <h3
                                        class="text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
                                        Table
                                    </h3>

                            </div>

                        </div>
                        <div
                            class="bg-white border border-secondary overflow-hidden cursor-pointer px-[12px] pt-[12px] pb-[32px] group">
                            <div class="aspect-w-16 aspect-h-9 relative">
                                <img src="{{ asset('images/chair.avif') }}" alt=""
                                    class="w-52   h-52   object-cover" />
                            </div>
                            <div class="pt-4 px-0 pb-0 flex flex-col items-start">
                                <span class="text-gray-500 text-sm">Products(0) </span>
                                <a href="" target="_blank">
                                    <h3
                                        class="text-xl font-semibold mt-2 flex justify-between items-center group-hover:text-primary transition-colors w-full">
                                        Table
                                    </h3>

                            </div>

                        </div>


                    </div>

                </div>


            </div>
        </div>
    </section>


    {{-- Subcategories section end  --}}


    {{-- Feature product section start --}}

    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Featured Products</h1>
    </div>

    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52 h-52 object-cover " />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1550.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 0)</h2>
                <h2>PKR 1660.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1500.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 2)</h2>
                <h2>PKR 1475.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 3)</h2>
                <h2>PKR 1250.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 4)</h2>
                <h2>PKR 850.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 5)</h2>
                <h2>PKR 1100.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (9 in 6)</h2>
                <h2>PKR 950.00</h2>
            </div>
        </div>

    </div>
    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="#">Show More</a>
    </div>


    {{-- Feature product section end --}}

    <div class="bg-secondary text-center mt-16 py-10">
        <h1 class="text-4xl py-5 font-bold">Recommended Products</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam
            labore at justo ipsum eirmod duo labore labore.</p>
        <div class="mx-auto">
            <label for="hs-trailing-button-add-on-multiple-add-ons" class="sr-only">Label</label>
            <div class="flex justify-center mt-5">
                <input type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Email goes here"
                    name="hs-trailing-button-add-on-multiple-add-ons"
                    class="py-3 px-4 block text-sm border border-secondary">
                <button type="button"
                    class="py-3 px-4 items-center gap-x-2 text-sm font-semibold bg-primary text-white disabled:opacity-50 disabled:pointer-events-none">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    {{-- Just Arrived section start --}}
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Just Arrived</h1>
    </div>

    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1550.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 0)</h2>
                <h2>PKR 1660.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1500.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 2)</h2>
                <h2>PKR 1475.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 3)</h2>
                <h2>PKR 1250.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 4)</h2>
                <h2>PKR 850.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 5)</h2>
                <h2>PKR 1100.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (9 in 6)</h2>
                <h2>PKR 950.00</h2>
            </div>
        </div>
    </div>

    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="#">Show More</a>
    </div>

    {{-- Just Arrived section end --}}

    {{-- Footer section start --}}
    <div class="mt-16">
        <div class="bg-secondary py-10 border-b-2 border-white">
            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1  gap-10 px-8">
                <div>
                    <a class="block px-10" href="#">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="" class="border rounded-xl">
                    </a>
                    <a class="block" href="">
                        <h1 class="text-2xl font-semibold text-center my-2"><span
                                class="text-primary dark:text-secondary">Every Day</span><span
                                class="dark:text-primary ml-1"></span>Plastic</h1>
                    </a>
                    {{-- <div x-data="{ map: false }" class="mt-3"> --}}
                    <i class="fa-solid fa-location-dot text-primary"></i>
                    <span>Ali Pur Chowk, Raj Kot, Gondlanwala Road, Gujranwala </span>
                    <span x-on:click="map = !map" class="text-primary cursor-pointer">
                        <i class="fa-solid fa-map"></i>
                    </span>
                    {{-- <div x-show="map">
                            <iframe width="100%"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3376.742099062221!2d74.14975991104262!3d32.18422861393571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391f296cd6e20c8f%3A0xf7cd2b43e82153b1!2sEvery%20Day%20Plastic%20Industry!5e0!3m2!1sen!2s!4v1726393584794!5m2!1sen!2s"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div> --}}
                    {{-- </div> --}}
                    <div class="mt-3">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <a href="#" class="hover:text-primary">plastic@gmail.com</a>
                    </div>
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">phone</a>
                    </div>
                    {{-- @if (website()->phone1) --}}
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">phone1</a>
                    </div>
                    {{-- @endif --}}
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-3">Quick Links</h1>
                    <ul>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Home</a>
                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Shop</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Blogs</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">About us</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Contact us</a>

                        </li>

                    </ul>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-3">Support</h1>
                    <ul>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Refund Policy</a>
                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Privacy Policy</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Return Policy</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Terms & Conditions</a>

                        </li>
                    </ul>
                </div>
                <div class="">
                    <h1 class="font-bold text-2xl mb-3">Newsletter</h1>
                    <form action="">
                        <input type="text" placeholder="Your Name"
                            class="w-full p-2 py-3 my-2 border border-secondary" />
                        <input type="email" placeholder="Your Email"
                            class="w-full p-2 py-3 my-2 border border-secondary" />
                        <button class="bg-primary text-white p-2 my-2 w-full py-3">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="bg-secondary lg:px-8 md:px-8 sm:px-8 grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 py-5">
            <div class="lg:tex-start md:text-start sm:text-start xs:text-center">
                All reserved by <b>Every day plastic</b>
            </div>
            <div>
                <img class="block m-auto md:float-right lg:float-right sm:float-right"
                    src="https://themewagon.github.io/eshopper/img/payments.png" alt="">
            </div>
        </div>
    </div>


    {{-- Footer section end --}}
@endsection

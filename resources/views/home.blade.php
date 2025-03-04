@extends('layouts.app')
@section('content')
<section>
    <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 xs:grid-cols-2 gap-5 lg:px-8 md:px-8 xs:px-2 mt-10 dark:text-secondary">
                <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-check text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">Quality Products</h1>
            </div>
                        <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-truck text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">Free Delivery</h1>
            </div>
                        <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-arrow-right-arrow-left text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">7 Days Return</h1>
            </div>
                        <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="fa-solid fa-phone text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">24/7 Support</h1>
            </div>
    </div>
    @if(count(website()->categories)) 
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Categories</h1>
    </div>
        <div class="grid md:grid-cols-3 lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mt-16 px-8 gap-5">
            @foreach (website()->categories as $category)
                <a href="" class="border border-secondary dark:border-slate-800">
                    {{-- <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div> --}}
                    <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                        <img
                            src="{{ asset('storage/'.$category->image) }}"
                            class="transition duration-300 ease-in-out hover:scale-110"
                            alt="{{ $category->title }}" />
                    </div>
                    <h1 class="font-bold mt-5 text-center text-2xl dark:text-secondary p-5">{{ $category->title }}</h1>
                </a>
            @endforeach
            
        </div>
    @endif
    <x-sub-categories-slider/>
@if(count($featured_products))
<div class="mt-16 text-center">
    <h1 class="font-bold text-4xl dark:text-secondary">Featured Products</h1>
</div>
<div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
    @foreach ($featured_products as $featured_product)
        <div class="border border-secondary dark:border-slate-800">

            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
                @if ($featured_product->price_detail && $featured_product->price_detail->discount > 0 &&  ($featured_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $featured_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                <div
                    class="absolute right-0 top-0 w-auto px-2  py-2 bg-green-600 text-white text-center text-1xl font-extrabold">
                    - {{ $featured_product->price_detail->discount }}%
                </div>
                @endif
                <img src="{{ asset('storage/'. $featured_product->image) }}"
                    class="transition duration-300 ease-in-out hover:scale-110" alt="title" />
            </div>
            <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
                <h1>
                    <a href="">{{ $featured_product->title }}</a>
                </h1>
                @if ( $featured_product->price_detail)
                
                <h2><b>{{ 
                $featured_product->price_detail->discount > 0 &&  ($featured_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $featured_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()) 
                ?
                 number_format($featured_product->price_detail->price - ($featured_product->price_detail->price/100*$featured_product->price_detail->discount),2) 
                 : number_format($featured_product->price_detail->price,2) }}</b>
                    @if ($featured_product->price_detail->discount > 0 &&  ($featured_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $featured_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                    <del class="text-gray-500">
                        {{ number_format($featured_product->price_detail->price,2) }}
                    </del>
                    @endif
                    
                </h2>
                    
                @endif
                @if($featured_product->coming_soon)
                <h2><b>Coming Soon</b></h2>
                @endif

            </div>

        </div>
    @endforeach
    </div>
<div class="flex text-center justify-center pt-5">
    <a class="bg-primary text-white py-2 px-4" href="">Show More</a>
</div>
@endif
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
    @if(count($new_products))
<div class="mt-16 text-center">
    <h1 class="font-bold text-4xl dark:text-secondary">Just Arrived</h1>
</div>
<div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
    @foreach ($new_products as $new_product)
    <div class="border border-secondary dark:border-slate-800">

        <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
            @if ($new_product->price_detail && $new_product->price_detail->discount > 0 &&  ($new_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $new_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
            <div
                class="absolute right-0 top-0 w-auto px-2  py-2 bg-green-600 text-white text-center text-1xl font-extrabold">
                - {{ $new_product->price_detail->discount }}%
            </div>
            @endif
            <img src="{{ asset('storage/'. $new_product->image) }}"
                class="transition duration-300 ease-in-out hover:scale-110" alt="title" />
        </div>
        <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
            <h1>
                <a href="">{{ $new_product->title }}</a>
            </h1>
            @if ( $new_product->price_detail)
            
            <h2><b>{{ 
            $new_product->price_detail->discount > 0 &&  ($new_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $new_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()) 
            ?
             number_format($new_product->price_detail->price - ($new_product->price_detail->price/100*$new_product->price_detail->discount),2) 
             : number_format($new_product->price_detail->price,2) }}</b>
                @if ($new_product->price_detail->discount > 0 &&  ($new_product->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $new_product->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                <del class="text-gray-500">
                    {{ number_format($new_product->price_detail->price,2) }}
                </del>
                @endif
                
            </h2>
                
            @endif
            @if($new_product->coming_soon)
            <h2><b>Coming Soon</b></h2>
            @endif

        </div>

    </div>
    @endforeach
    </div>
<div class="flex text-center justify-center pt-5">
    <a class="bg-primary text-white py-2 px-4" href="">Show More</a>
</div>
@endif
</section>

@endsection

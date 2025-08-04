@extends('layouts.app')
@section('title','Home')
@section('content')

<section class="bg-white dark:bg-black text-black dark:text-secondary">
    @if(count(facilities()))
    <div class="lg:block md:block sm:block xs:hidden">
        <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 gap-5 lg:px-8 md:px-8 xs:px-2 mt-10 dark:text-secondary">
            @foreach (facilities() as $facility)
            <div class="p-5 border border-secondary flex justify-center dark:border-slate-800">
                <span><i class="{{ $facility->class }} text-primary text-5xl"></i></span>
                <h1 class="lg:text-2xl md:text-2xl xs:text-1xl mt-2 font-bold ml-3">{{ $facility->title }}</h1>
            </div>
            @endforeach    
        </div>
    </div>
    @endif
    @if(count($trending_products))
      <div class="mt-16 text-center">
        <h1 class="font-bold lg:text-4xl md:text-4xl sm:text-2xl xs:text-2xl dark:text-secondary uppercase">trending products</h1>
    </div>
    @include('inc.trending_slider')
    @endif
    {{-- @if(count(website()->categories)) 
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Categories</h1>
    </div>
        <div class="grid md:grid-cols-3 lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mt-16 lg:px-8 md:px-8 sm:px-2 xs:px-2 gap-5">
            @foreach (website()->categories as $category)
                <a href="{{ route('categories',['slug' => $category->slug]) }}" class="border border-secondary dark:border-slate-800">
                    <div class="text-gray-500 text-end">{{ $category->subCategories->count() }}  Sub Categories</div>
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
    @endif --}}
    <div class="mt-16 text-center">
        <h1 class="font-bold lg:text-4xl md:text-4xl sm:text-2xl xs:text-2xl dark:text-secondary">Our Collection</h1>
    </div>
    @include('inc.SubCategoriesSlider')
@if(count($featured_products))
<div class="mt-16 text-center">
    <h1 class="font-bold text-4xl dark:text-secondary">Featured Products</h1>
</div>
<div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-2 gap-5 lg:px-8 md:px-8 sm:px-2 xs:px-2">
    @foreach ($featured_products as $featured_product)
       @include('inc.product_box', ['product' => $featured_product])
    @endforeach
    </div>
<div class="flex text-center justify-center pt-5">
    <a class="bg-primary text-white py-2 px-4" href="{{ url('shop?sort_by=featured') }}">Show More</a>
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
<div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-2 gap-5 lg:px-8 md:px-8 sm:px-2 xs:px-2">
    @foreach ($new_products as $new_product)
    @include('inc.product_box', ['product' => $new_product])
    @endforeach
</div>
<div class="flex text-center justify-center pt-5">
    <a class="bg-primary text-white py-2 px-4" href="{{ url('shop?sort_by=new') }}">Show More</a>
</div>
@endif
</section>

@endsection

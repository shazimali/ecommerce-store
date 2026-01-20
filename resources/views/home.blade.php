@extends('layouts.app')
@section('title','Home')
@section('content')
@if($start_collection)
<div x-data="{ isOpen: true }">
    
    <dialog id="dialog" 
            aria-labelledby="dialog-title" 
            class="fixed inset-0 m-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent p-0 backdrop:bg-transparent z-50"
            :open="isOpen"> 
        
        <el-dialog-backdrop class="fixed inset-0 bg-gray-500/75 transition-opacity data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"></el-dialog-backdrop>

        <div tabindex="0" class="flex items-end justify-center p-4 text-center focus:outline focus:outline-0 sm:items-center sm:p-0">
            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-[closed]:translate-y-4 data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in sm:my-8 sm:w-full sm:max-w-lg data-[closed]:sm:translate-y-0 data-[closed]:sm:scale-95">
                <button type="button" 
                            command="close" 
                            commandfor="dialog" 
                            class="inline-flex justify-center rounded-sm bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto absolute top-0 right-0 z-50"
                            @click="isOpen = false">x</button>
                <a href="{{ route('collections',['slug' => $start_collection->slug]) }}" class="lg:block md:block sm:block xs:hidden w-full relative overflow-hidden bg-cover bg-no-repeat">
                    <img src="{{ asset('storage/'.$start_collection->image) }}"
                        alt="{{ $start_collection->title }}" />
                </a>
                <a href="{{ route('collections',['slug' => $start_collection->slug]) }}" class="lg:hidden md:hidden sm:hidden xs:block w-full relative overflow-hidden bg-cover bg-no-repeat">
                    <img src="{{ asset('storage/'.$start_collection->mob_image) }}"
                        alt="{{ $start_collection->title }}" />
                </a>
            </el-dialog-panel>
        </div>
    </dialog>
</div>
@endif
<section class="bg-white dark:bg-black text-black dark:text-secondary">
    @if(count(facilities()))
    <div class="lg:block md:block sm:block xs:hidden">
        <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-3 gap-5 lg:px-8 md:px-8 xs:px-2 mt-32 dark:text-secondary">
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
        <h1 class="font-bold lg:text-4xl md:text-4xl sm:text-2xl xs:text-2xl dark:text-secondary">Trending Products</h1>
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
        @if(count($collections)) 
        <div class="grid md:grid-cols-3 lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mt-16 lg:px-8 md:px-8 sm:px-2 xs:px-2 gap-5">
            @foreach ($collections as $collection)
                <a  href="{{ route('collections',['slug' => $collection->slug]) }}" class="border border-secondary dark:border-slate-800">
                    <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                        <img src="{{ asset('storage/'.$collection->image) }}"
                            class="transition duration-300 ease-in-out hover:scale-110"
                            alt="{{ $collection->title }}" />
                    </div>
                </a>
            @endforeach
        </div>
    @endif

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
@if($bottom_collection)
    <div class="py-10">
        <a href="{{ route('collections',['slug' => $bottom_collection->slug]) }}" class="lg:block md:block sm:block xs:hidden w-full relative overflow-hidden bg-cover bg-no-repeat">
            <img src="{{ asset('storage/'.$bottom_collection->image) }}"
                class="transition duration-300 ease-in-out hover:scale-110"
                alt="{{ $bottom_collection->title }}" />
        </a>
        <a href="{{ route('collections',['slug' => $bottom_collection->slug]) }}" class="lg:hidden md:hidden sm:hidden xs:block w-full relative overflow-hidden bg-cover bg-no-repeat">
            <img src="{{ asset('storage/'.$bottom_collection->mob_image) }}"
                class="transition duration-300 ease-in-out hover:scale-110"
                alt="{{ $bottom_collection->title }}" />
        </a>
    </div>
@endif
    @if(count($new_products))
<div class="text-center">
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

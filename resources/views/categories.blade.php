@extends('layouts.app')
@section('title',$category_title)
@section('content')
<div class="grid md:grid-cols-3 lg:grid-cols-3 sm:grid-cols-2 xs:grid-cols-1 mt-16 px-8 gap-5">
    @foreach ($subCategories as $category)
        <a href="{{ route('sub-categories',[$category->slug]) }}" class="border border-secondary dark:border-slate-800 p-5">
            <div x-show="{{ $category->product_heads->where('status','ACTIVE')->count() }}" class="text-gray-500 text-end">{{ $category->product_heads->where('status','ACTIVE')->count() }} Products</div>
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat">
                <img
                    src="{{ asset('storage/'.$category->image) }}"
                    class="transition duration-300 ease-in-out hover:scale-110"
                    alt="{{ $category->title }}" />
            </div>
            <h1 class="font-bold mt-5 text-2xl dark:text-secondary">{{ $category->title }}</h1>
        </a>
    @endforeach
</div>
@endsection
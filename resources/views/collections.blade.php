@extends('layouts.app')
@section('title','Collection')
@section('content')
<section class="bg-white dark:bg-black text-black dark:text-secondary">
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary uppercase">{{ $collection->title }}</h1>
    </div>
      <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-2 gap-5 lg:px-8 md:px-8 sm:px-2 xs:px-2">
        @foreach ($collection->products as $product)
           @include('inc.product_box')
        @endforeach
    </div>
</section>
@endsection
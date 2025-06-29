@extends('layouts.app')
@section('title',$sub_category_title)
@section('content')
<div class="mt-16 text-center">
    <h1 class="font-bold text-4xl text-black dark:text-secondary">{{ $sub_category_title }}</h1>
</div>
<div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
    @foreach ($products->where('status','ACTIVE') as $product)
    @include('inc.product_box', ['product' => $product])
    @endforeach
</div>
@endsection
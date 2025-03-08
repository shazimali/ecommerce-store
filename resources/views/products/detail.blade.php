@extends('layouts.app')
@section('title',$product->title)
@section('content')
<@livewire('product-detail', ['slug' => $product->slug])
@endsection
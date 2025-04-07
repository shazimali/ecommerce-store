@extends('layouts.app')
@section('title','Blog Detail')
@section('content')
<div class="px-8 py-10">
    <h1 class="text-4xl font-semibold">
        {{ $blog->title }}
    </h1>
    <img class="w-full py-5" src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}">
    <div class="py-5">
        {!! $blog->desc !!}
    </div>
</div>
@endsection
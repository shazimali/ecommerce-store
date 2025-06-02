@extends('layouts.app')
@section('title',$page->title)
@section('content')
<div class="px-8 py-10 text-black dark:text-white dark:bg-black">
    <div class="py-5">
        {!! $page->content !!}
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title',$page->title)
@section('content')
<div class="px-8 py-10">
    <div class="py-5">
        {!! $page->content !!}
    </div>
</div>
@endsection
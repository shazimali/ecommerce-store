@extends('layouts.app')
@section('title', $bundle->title)
@section('content')
@livewire('bundle-detail', ['slug' => $bundle->slug])
@endsection

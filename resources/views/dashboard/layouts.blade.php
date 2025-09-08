@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="flex">

        {{-- Sidebar --}}
        <div class="w-1/4">
            @include('dashboard.index.sidebar')
        </div>

        {{-- Main content --}}
        <div class="w-3/4 p-6">
            @yield('dashboard-content')
        </div>
    </div>
@endsection

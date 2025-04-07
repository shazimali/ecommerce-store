@extends('layouts.app')
@section('title','Blogs')
@section('content')
<div>
    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        @foreach ($blogs as $key => $data)
        <a href="{{ route('blogs.detail',['slug' => $data->slug]) }}" class="border border-secondary dark:border-slate-800">
       
            <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
                <img
                  src="{{ asset('storage/'.$data['image']) }}"
                  class="transition duration-300 ease-in-out hover:scale-110"
                  alt="{{ $data['title'] }}" />
            </div>
            <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
                <h1>{{ $data['title'] }}</h1>
           
            </div>
        </a>
        @endforeach
    
    </div>
    <div class="px-8 pt-5">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
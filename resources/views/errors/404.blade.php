@extends('layouts.app')
@section('title', 'Page Not Found')
@section('content')
<section class="flex items-center min-h-[60vh] bg-white dark:bg-black text-black dark:text-white py-16">
    <div class="container mx-auto px-6 flex flex-col items-center text-center">
        <!-- Interactive 404 Graphic -->
        <div class="relative mb-6 select-none">
            <h1 class="text-9xl font-extrabold tracking-widest text-primary animate-pulse">
                404
            </h1>
            <div class="bg-secondary text-primary dark:bg-primary dark:text-white px-3 py-1 text-xs md:text-sm font-bold uppercase rounded shadow-md rotate-12 absolute -bottom-2 right-4">
                Page Not Found
            </div>
        </div>

        <!-- Text details -->
        <h2 class="text-2xl font-bold md:text-4xl mb-4">
            Oops! The page you're looking for doesn't exist.
        </h2>
        <p class="text-neutral-500 dark:text-neutral-400 max-w-md mb-8 text-sm md:text-base leading-relaxed">
            It looks like this page was moved, deleted, or never existed in the first place. Let's get you back on track.
        </p>

        <!-- Quick actions -->
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-center w-full">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-8 py-3.5 bg-primary hover:bg-primary/95 text-white font-semibold shadow-lg hover:shadow-primary/20 active:scale-[0.98] transition-all duration-200 cursor-pointer flex items-center justify-center gap-2">
                <i class="fa-solid fa-house"></i>
                Back to Home
            </a>
            <a href="{{ route('shop') }}" class="w-full sm:w-auto px-8 py-3.5 border border-secondary dark:border-slate-800 hover:border-primary dark:hover:border-primary text-black dark:text-white hover:text-primary dark:hover:text-primary font-semibold transition-all duration-200 cursor-pointer flex items-center justify-center gap-2">
                <i class="fa-solid fa-bag-shopping"></i>
                Browse Shop
            </a>
        </div>
    </div>
</section>
@endsection

@extends('layouts.app')
@section('content')

    {{-- Feature product section start --}}

    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Featured Products</h1>
    </div>

    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52 h-52 object-cover " />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1550.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 0)</h2>
                <h2>PKR 1660.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1500.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 2)</h2>
                <h2>PKR 1475.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 3)</h2>
                <h2>PKR 1250.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 4)</h2>
                <h2>PKR 850.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 5)</h2>
                <h2>PKR 1100.00</h2>
            </div>
        </div>
        <div class="card border-b border-secondary dark:border-slate-800">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (9 in 6)</h2>
                <h2>PKR 950.00</h2>
            </div>
        </div>

    </div>
    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="#">Show More</a>
    </div>


    {{-- Feature product section end --}}

    <div class="bg-secondary text-center mt-16 py-10">
        <h1 class="text-4xl py-5 font-bold">Recommended Products</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam
            labore at justo ipsum eirmod duo labore labore.</p>
        <div class="mx-auto">
            <label for="hs-trailing-button-add-on-multiple-add-ons" class="sr-only">Label</label>
            <div class="flex justify-center mt-5">
                <input type="text" id="hs-trailing-button-add-on-multiple-add-ons" placeholder="Email goes here"
                    name="hs-trailing-button-add-on-multiple-add-ons"
                    class="py-3 px-4 block text-sm border border-secondary">
                <button type="button"
                    class="py-3 px-4 items-center gap-x-2 text-sm font-semibold bg-primary text-white disabled:opacity-50 disabled:pointer-events-none">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    {{-- Just Arrived section start --}}
    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Just Arrived</h1>
    </div>

    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1550.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 0)</h2>
                <h2>PKR 1660.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 1)</h2>
                <h2>PKR 1500.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 2)</h2>
                <h2>PKR 1475.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 3)</h2>
                <h2>PKR 1250.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 4)</h2>
                <h2>PKR 850.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (6 in 5)</h2>
                <h2>PKR 1100.00</h2>
            </div>
        </div>
        <div class="card">
            <figure class="px-4 ">
                <img src="{{ asset('images/chair.avif') }}" alt="" class="w-52   h-52   object-cover" />
            </figure>
            <div class="card-body items-center text-center">
                <h2 class="card-title">Plastic Table (9 in 6)</h2>
                <h2>PKR 950.00</h2>
            </div>
        </div>
    </div>

    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="#">Show More</a>
    </div>

    {{-- Just Arrived section end --}}
@endsection

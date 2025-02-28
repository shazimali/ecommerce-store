@extends('layouts.app')
@section('content')
    {{-- Feature product section start --}}

    <div class="mt-16 text-center">
        <h1 class="font-bold text-4xl dark:text-secondary">Featured Arrived</h1>
    </div>
    <div class="mt-10 grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-5 px-8">
        @for ($i = 1; $i < 8; $i++)
            <div class="border border-secondary dark:border-slate-800">

                <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">
                    <div
                        class="absolute right-1 rounded-full  top-1 w-auto px-2  py-5 bg-green-600 text-white text-center text-1xl font-extrabold">
                        -10%</div>
                    <img src="https://everydayplastic.co/storage/01JCAVW1FWSV0GYWXZXKC3Z42G.png"
                        class="transition duration-300 ease-in-out hover:scale-110" alt="title" />
                </div>
                <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
                    <h1>
                        <a href="">product</a>
                    </h1>

                    <h2><b>10000</b>
                        <del class="text-gray-500">
                            100
                        </del>
                    </h2>

                </div>

            </div>
        @endfor
    </div>
    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="">Show More</a>
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
        @for ($i = 1; $i < 7; $i++)
            <div class="border border-secondary dark:border-slate-800">

                <div class="w-full relative overflow-hidden bg-cover bg-no-repeat border-b border-secondary">

                    <img src="https://everydayplastic.co/storage/01JCAVW1FWSV0GYWXZXKC3Z42G.png"
                        class="transition duration-300 ease-in-out hover:scale-110" alt="title" />
                </div>
                <div class="border-b border-secondary dark:border-slate-800 py-5 text-center dark:text-secondary">
                    <h1>
                        <a href="">product</a>
                    </h1>

                    <h2><b>PKR</b> 1550.00
                    </h2>

                </div>

            </div>
        @endfor
    </div>

    <div class="flex text-center justify-center pt-5">
        <a class="bg-primary text-white py-2 px-4" href="#">Show More</a>
    </div>

    {{-- Just Arrived section end --}}
@endsection

@extends('layouts.app')
@section('title','Contact Us')
@section('content')
<div class="">
        <div style="background-image: url('{{ asset('images/background.jpeg') }}')" class="w-full min-h-64 bg-no-repeat bg-cover">
        <div>tets</div>
        <div>tets</div>
        <div>tets</div>
        <div>tets</div>
        <div>tets</div>
        <div>tets</div>
        <div>tets</div>
        </div>
    <div class="z-10 pt-16 pb-16">
        <form class="max-w-2xl mx-auto bg-white px-4 py-8 rounded-lg shadow-lg">
            <!-- Your Information Section -->
            <div class="border-b border-gray-200 pb-6 mb-6">
                <h2 class="text-xl font-semibold mb-6">Your Information</h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            First name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Last name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        Email address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        Email address (confirm) <span class="text-red-500">*</span>
                    </label>
                    <input type="email" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Must match email address above</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        Contact number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Product Information Section -->
            <div class="pb-6">
                <h2 class="text-xl font-semibold mb-6">Product Information</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Select...</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">
                        Model code/name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">
                        <a href="#" class="text-blue-600 hover:underline">Where can I find model code of my
                            Samsung
                            product?</a>
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded hover:bg-blue-700 transition-colors">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection
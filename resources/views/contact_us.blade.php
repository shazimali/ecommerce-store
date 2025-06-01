@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
    <div class="text-black">
        <div style="background-image: url('{{asset('images/contact_us.webp')}}')"
            class="h-screen flex items-center justify-center bg-no-repeat bg-cover">
                <div class="text-white text-7xl font-semibold">Contact Us</div>            
        </div>
        <div class="z-10 pt-16 pb-16">
            <form class="w-full  mx-auto bg-white px-4 py-8 dark:bg-black"
                action="{{ route('contact_us.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Your Information Section -->
                <div class="">
                @session('success')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endsession
                    <h2 class="text-xl font-semibold mb-6 dark:text-white">Your Information</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 dark:text-white" for="first_name ">
                                First name <span class="text-primary">*</span>
                            </label>
                            <input type="text" value="{{ old('first_name') }}" name="first_name"
                                class="w-full border border-gray-300 rounded px-3 py-2 dark:bg-black dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('first_name')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2 dark:text-white" for="last_name">
                                Last name <span class="text-primary">*</span>
                            </label>
                            <input type="text" value="{{ old('last_name') }}" name="last_name"
                                class="w-full border border-gray-300 rounded px-3 py-2
                                dark:bg-black dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('last_name')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 dark:text-white" for="email_address">
                                Email address <span class="text-primary">*</span>
                            </label>
                            <input type="email" value="{{ old('email_address') }}" name="email_address"
                                class="w-full border border-gray-300 rounded px-3 py-2
                            dark:bg-black dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('email_address')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 dark:text-white" for="subject">
                                Subject <span class="text-primary">*</span>
                            </label>
                            <select
                                class="w-full border border-gray-300 rounded px-3 py-2
                            dark:bg-black dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                name="subject" value="{{ old('subject') }}">
                                <option value="" disabled selected>Select a subject</option>
                                <option value="Inquire">Inquire</option>
                                <option value="Support">Support</option>
                                <option value="Help">Help</option>
                            </select>
                            @error('subject')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium dark:text-white mb-2" for="message">
                        Message <span class="text-primary">*</span>
                    </label>
                    <textarea name="message" rows="4" cols="50" placeholder="Message"
                        class="w-full border border-gray-300 dark:bg-black dark:text-white"></textarea>
                    @error('message')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 mt-4">
                    <label class="block text-sm font-medium mb-2 dark:text-white" for="attachment">
                        Upload File <span class="text-primary">*</span>
                    </label>
                    <input type="file" name="attachment"
                        class="w-full border border-gray-300 rounded px-3 py-2
                            dark:bg-black dark:text-white focus:outline-none">
                    @error('attachment')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit"
                        class="w-96 mt-4 bg-primary text-secondary py-3 px-4 rounded hover:bg-primary transition-colors">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

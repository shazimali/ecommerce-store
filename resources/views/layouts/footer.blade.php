    {{-- Footer section start --}}
    <div class="mt-16">
        <div class="bg-secondary py-10 border-b-2 border-white">
            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1  gap-10 px-8">
                <div>
                    <a class="block px-10" href="#">
                        <img src="{{ asset('storage/'.website()->logo) }}" alt="" class="border rounded-xl">
                    </a>
                    <a class="block" href="">
                        <h1 class="text-2xl font-semibold text-center my-2"><span
                                class="text-primary dark:text-secondary">Every Day</span><span
                                class="dark:text-primary ml-1"></span>Plastic</h1>
                    </a>
                    <div x-data="{ map: false }" class="mt-3">
                    <i class="fa-solid fa-location-dot text-primary"></i>
                    <span>Ali Pur Chowk, Raj Kot, Gondlanwala Road, Gujranwala </span>
                    <span x-on:click="map = !map" class="text-primary cursor-pointer">
                        <i class="fa-solid fa-map"></i>
                    </span>
                    <div x-show="map">
                            <iframe width="100%"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3376.742099062221!2d74.14975991104262!3d32.18422861393571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391f296cd6e20c8f%3A0xf7cd2b43e82153b1!2sEvery%20Day%20Plastic%20Industry!5e0!3m2!1sen!2s!4v1726393584794!5m2!1sen!2s"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="mt-3">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <a href="#" class="hover:text-primary">plastic@gmail.com</a>
                    </div>
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">phone</a>
                    </div>
                    {{-- @if (website()->phone1) --}}
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">phone1</a>
                    </div>
                    {{-- @endif --}}
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-3">Quick Links</h1>
                    <ul>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="{{ route('shop') }}">Shop</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="{{ route('blogs.index') }}">Blogs</a>

                        </li>
                        <li class="py-1">
                            <a class="hover:text-primary hover:underline" href="">Contact us</a>

                        </li>

                    </ul>
                </div>
                <div>
                    <h1 class="font-bold text-2xl mb-3">Support</h1>
                    <ul>
                        @if(footer_pages()->count())
                            @foreach(footer_pages() as $page)
                            <li class="py-1">
                                <a class="hover:text-primary hover:underline" href="{{ route('pages.index',['slug' => $page->slug]) }}">{{ $page->title }}</a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="">
                    <h1 class="font-bold text-2xl mb-3">Newsletter</h1>
                    <form action="">
                        <input type="text" placeholder="Your Name"
                            class="w-full p-2 py-3 my-2 border border-secondary" />
                        <input type="email" placeholder="Your Email"
                            class="w-full p-2 py-3 my-2 border border-secondary" />
                        <button class="bg-primary text-white p-2 my-2 w-full py-3">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="bg-secondary lg:px-8 md:px-8 sm:px-8 grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 xs:grid-cols-1 py-5">
            <div class="lg:tex-start md:text-start sm:text-start xs:text-center">
                All reserved by <b>Every day plastic</b>
            </div>
            <div>
                <img class="block m-auto md:float-right lg:float-right sm:float-right"
                    src="https://themewagon.github.io/eshopper/img/payments.png" alt="">
            </div>
        </div>
    </div>


    {{-- Footer section end --}}
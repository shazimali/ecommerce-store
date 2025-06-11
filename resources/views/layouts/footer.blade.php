    {{-- Footer section start --}}
    <div class="mt-16 text-black">
        <div class="bg-secondary py-10 border-b-2 border-white">
            <div class="grid lg:grid-cols-4 md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1  gap-10 px-8">
                <div>
                    <a class="block px-10" href="#">
                        <img src="{{ asset('storage/' . website()->logo) }}" alt="" class="border rounded-xl">
                    </a>
                    <a class="block" href="">
                        <h1 class="text-2xl font-semibold text-center my-2"><span
                                class="text-primary dark:text-black">Every Day</span><span
                                class="text-black dark:text-primary ml-1"></span>{{ website()->title }}</h1>
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
                        <a href="#" class="hover:text-primary">{{ website()->email }}</a>
                    </div>
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">{{ website()->phone }}</a>
                    </div>
                    {{-- @if (website()->phone1) --}}
                    <div class="mt-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <a href="#" class="hover:text-primary">{{ website()->phone1 }}</a>
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
                        @if (footer_pages()->count())
                            @foreach (footer_pages() as $page)
                                <li class="py-1">
                                    <a class="hover:text-primary hover:underline"
                                        href="{{ route('pages.index', ['slug' => $page->slug]) }}">{{ $page->title }}</a>
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
            {{-- <div>
                <img class="block m-auto md:float-right lg:float-right sm:float-right"
                    src="https://themewagon.github.io/eshopper/img/payments.png" alt="">
            </div> --}}
        </div>
    </div>
    <div class="fixed bottom-6 right-6 z-[999]">
        <button id="whatsappButton"
            class="bg-[#25D366] w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-[#1ea952] transition-all duration-300"
            x-on:click="window.open('https://wa.me/{{ getSettingVal('whats_app') }}', '_blank')">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z">
                </path>
            </svg>
        </button>
    </div>




    {{-- Footer section end --}}

<div>
    @if (request()->routeIs('home'))
        <div x-data="{ menu: true, sideBarOpen: false, newArOpen: false }" class="lg:block md:block sm:hidden xs:hidden">
        @else
            <div x-data="{ menu: false, sideBarOpen: false, newArOpen: false }" class="lg:block md:block sm:hidden xs:hidden">
    @endif
    <div class="grid lg:grid-cols-4 md:grid-cols-4 gap-5 px-8 bg-white dark:bg-black">
        <div>
            <livewire:nav-bar-collection />
        </div>
        <div class="col-span-3 grid grid-cols-2 py-5 bg-white text-black dark:bg-black relative">
            <ul class="flex">
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'home',
                        'text-primary dark:text-primary' => Route::is('home'),
                    ]) href="{{ route('home') }}">Home</a>
                </li>
                @if (count(newArrivals()) > 0)
                    <li x-on:click="newArOpen = ! newArOpen" class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">
                            New Arrivals <i class="fa-solid fa-caret-down"></i>
                        </a>
                    </li>
                @endif
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'shop',
                        'text-primary dark:text-primary' => Route::is('shop'),
                    ]) href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'blogs.index',
                        'text-primary dark:text-primary' =>
                            Route::is('blogs.*') || Route::is('blogs.index'),
                    ]) href="{{ route('blogs.index') }}">Blogs</a>
                </li>
                @if (header_pages()->count() > 0)
                    @foreach (header_pages() as $page)
                        <li class="mr-6">
                            <a @class([
                                'hover:text-primary dark:text-secondary dark:hover:text-primary',
                                'text-primary' => Route::is('pages.index'),
                            ])
                                href="{{ route('pages.index', ['slug' => $page->slug]) }}">{{ $page->title }}</a>
                        </li>
                    @endforeach
                @endif
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'contact_us',
                        'text-primary dark:text-primary' => Route::is('contact_us'),
                    ]) href="{{ route('contact_us') }}">Contact</a>
                </li>
            </ul>
            <ul class="flex justify-end">
            @guest
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'login',
                        'text-primary dark:text-primary' => Route::is('login'),
                    ]) href="{{ route('login') }}">Login</a>
                </li>
                <li class="mr-6">
                    <a @class([
                        'hover:text-primary dark:hover:text-primary',
                        'dark:text-secondary ' => Route::currentRouteName() != 'register',
                        'text-primary dark:text-primary' => Route::is('register'),
                    ]) href="{{ route('register') }}">Register</a>
                </li>
                @endguest
                @auth
                    <li class="mr-6">
                        <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                @if(auth()->user()->avatar)
                            <img
                                alt="{{ auth()->user()->name }}"
                                src="{{ auth()->user()->avatar }}" />
                                @else
<img
                                alt="Tailwind CSS Navbar component"
                                src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541" />
                                @endif
                            </div>
                        </div>
                        <ul
                            tabindex="0"
                            class="menu menu-sm dropdown-content text-black dark:text-white bg-white dark:bg-black rounded-box z-50  w-52 p-2 shadow">
                            <li class="border-b pb-1">
                                @php
                                    $user_name = explode(' ', auth()->user()->name);
                                @endphp
                                <a>Hi, {{ $user_name[0] }}</a>
                            </li>
                            <li>
                            <a href="{{ route('dashboard.account') }}" class="justify-between">
                                Account
                                {{-- <span class="badge">New</span> --}}
                            </a>
                            </li>
                            <li><a href="{{ route('dashboard.orders') }}">Orders</a></li>
                            <li><a href="{{ route('dashboard.reviews') }}">Reviews</a></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <input type="submit" value="Logout"  class="hover:text-primary dark:hover:text-primary cursor-pointer">
                                </form>
                            </li>
                        </ul>
                        </div>
                    </li>
                @endauth
            </ul>
          
            <div x-show="newArOpen" style="top: 60px"
                class="bg-white dark:bg-black z-50 min-h-64 w-full absolute flex justify-between py-10 px-10">
                @foreach (newArrivals() as $new_pr)
                    <div class="text-center relative dark:text-secondary">
                        @if (
                            $new_pr->price_detail &&
                                $new_pr->price_detail->discount > 0 &&
                                ($new_pr->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() ||
                                    $new_pr->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                            <div
                                class="absolute right-0 top-0 w-auto px-2  py-1 bg-green-600 text-white text-center text-1xl font-extrabold">
                                - {{ $new_pr->price_detail->discount }} %
                            </div>
                        @endif
                        <img src="{{ asset('storage/' . $new_pr->nav_image) }}" {{-- class=" max-h-52" --}}
                            alt="{{ $new_pr->title }}" />
                        <div class="pt-2 overflow-hidden max-w-36 text-xs truncate text-left">
                            {{ $new_pr->short_desc }}
                        </div>
                        @if ($new_pr->coming_soon)
                            <p class="text-primary text-xs text-left"><b>Coming Soon</b></p>
                        @else
                            @if (
                                $new_pr->price_detail &&
                                    $new_pr->price_detail->discount > 0 &&
                                    ($new_pr->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() ||
                                        $new_pr->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                                <div class="text-xs text-left">
                                    <b>{{ $new_pr->price_detail->country->currency }}</b>
                                    {{ number_format(round($new_pr->price_detail->price - ($new_pr->price_detail->price / 100) * $new_pr->price_detail->discount), 2) }}
                                    <del class="text-gray-500">
                                        {{ $new_pr->price_detail->country->currency }}
                                        {{ number_format($new_pr->price_detail->price, 2) }}
                                    </del>
                                </div>
                            @else
                                <div class="text-xs text-left">
                                    <b>{{ $new_pr->price_detail->country->currency }}</b>
                                    {{ number_format($new_pr->price_detail->price, 2) }}
                                </div>
                            @endif
                            <div class="w-full">
                                <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary my-2"
                                    href="{{ route('product.detail', ['slug' => $new_pr->slug]) }}">
                                    <i class="fa-regular fa-eye text-primary"></i>
                                    View Detail
                                </a>
                                {{-- <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary  my-2" href="">
                                            <i class="fa-solid fa-cart-shopping text-primary"></i>
                                            Add to Cart
                                        </a> --}}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @if (request()->routeIs('home'))
                @include('inc.banners')
            @endif
        </div>
    </div>
</div>
@include('inc.mobile_navbar')
@if (request()->routeIs('home'))
<div class="lg:hidden md:hidden sm:hidden xs:block lg:px-8 md:px-8 xs:px-2">
    @include('inc.banners')
</div>
 @endif
</div>

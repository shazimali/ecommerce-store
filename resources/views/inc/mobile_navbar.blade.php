<div class="mobile-navbar lg:hidden md:hidden">
    @include('inc.news')
    @include('inc.mobile_header')
    <div class="flex justify-center py-2 text-black">
    <a class="font-semibold text-4xl" href="{{ route('home') }}">
            <span class="text-primary dark:text-secondary">Every Day</span>
            <span class="dark:text-primary">{{ website()->title }}</span>
    </a>
    </div>
    <nav class="flex justify-between border-secondary border dark:border-slate-800 p-2">
        <div class="drawer drawer-start w-6">
            <input id="mobile-menu" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content cursor-pointer">
                <label for="mobile-menu" class="drawer-button">
                    <i class="fa-solid fa-bars text-black dark:text-white text-3xl"></i>
                </label>
            </div>
        
            <div class="drawer-side z-50">
                <label for="mobile-menu" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="menu bg-white dark:bg-black text-black dark:text-white min-h-full w-64 p-4 text-start">
                    <ul x-data="{mobileNewArr:false}">
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('home')])  href="{{ route('home') }}">Home</a>
                        </li>
                        <li x-on:click="mobileNewArr = !mobileNewArr" class="py-2 text-start grid grid-cols-1">
                                <div class="flex justify-between">
                                    New Arrival
                                    <div>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                </div>
                                
                            <div
                            x-show="mobileNewArr"
                            class="bg-white dark:bg-black mt-5 z-50 block">
                            @foreach (newArrivals() as $new_pr)
                            <div class="text-center dark:text-white px-5 py-5 relative">
                                @if ($new_pr->price_detail && $new_pr->price_detail->discount > 0 &&  ($new_pr->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $new_pr->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                                <div class="absolute right-5  top-5 w-auto px-1 py-1 bg-green-600 text-white text-[8px] text-center">{{ $new_pr->price_detail->discount}} % off</div>
                                @endif
                                    <img
                                        src="{{ asset('storage/'.$new_pr->nav_image) }}"
                                        alt="{{ $new_pr->title }}" />
                                    <div class="pt-2 overflow-hidden  text-xs truncate">               
                                         {{$new_pr->short_desc }}     
                                    </div>
                                    @if ($new_pr->coming_soon)
                                    <p class="text-primary text-xs text-center"><b>Coming Soon</b></p>    
                                    @else 
                                        @if ($new_pr->price_detail && $new_pr->price_detail->discount > 0 &&  ($new_pr->price_detail->discount_from >= Carbon\Carbon::today()->toDateString() || $new_pr->price_detail->discount_to >= Carbon\Carbon::today()->toDateString()))
                                            <div class="pt-2 overflow-hidden  text-xs truncate text-center">
                                                <b>{{ $new_pr->price_detail->country->currency }}</b>  {{ number_format(round($new_pr->price_detail->price - ($new_pr->price_detail->price/100*$new_pr->price_detail->discount)),2 ) }}
                                                <del class="text-gray-500">
                                                    {{ $new_pr->price_detail->country->currency }} {{  number_format($new_pr->price_detail->price,2)  }}
                                                </del>
                                            </div>
                                            @else
                                            <div class="text-xs text-center">
                                                <b>{{ $new_pr->price_detail->country->currency }}</b>  {{  number_format($new_pr->price_detail->price,2)  }}
                                            </div>
                                        @endif
                                    @endif
                                    <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary my-2" href="{{ route('product.detail', ['slug' => $new_pr->slug]) }}">
                                        <i class="fa-regular fa-eye text-primary"></i>
                                        View Detail
                                    </a>
                            </div>
                            @endforeach      
                            </div>
                        </li>
                        <li x-data="{mobileCollection: false}">
                            <div x-on:click="mobileCollection = !mobileCollection" class="bg-primary text-white flex justify-between py-2 px-2">
                                collection
                                <div>
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </div>
                            @foreach (website()->categories as $category)
                            <div x-show="mobileCollection" class="grid grid-cols-2">
                                <div class="text-start  text-sm">
                                    <div class="font-semibold">
                                        {{ $category->title }}
                                    </div>
                                    @if(count($category->front_sub_categories))
                                    @foreach ($category->front_sub_categories as $sub_cat)
                                        <a class="underline text-xs" href="{{ route('sub-categories',['slug' => $sub_cat->slug ]) }}">{{ $sub_cat->title }}</a>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="px-5 py-5">
                                    <img src="{{ asset('storage/'.$category->image) }}" alt=" {{ $category->title }}">
                                </div>
                                
                            </div>
                            @endforeach
                        </li>
                        <li class="text-start py-2">
                            <a @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('shop')])  href="{{ route('shop') }}">Shop</a>
                        </li>
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('blogs.*') || Route::is('blogs.detail') ])  href="{{ route('blogs.index') }}">Blogs</a>
                        </li>
                        @if(header_pages()->count() > 0)
                        @foreach (header_pages() as $page)
                            <li class="text-start py-2">
                                <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('pages.index')])  href="{{ route('pages.index',['slug' => $page->slug]) }}">{{ $page->title }}</a>
                            </li>
                        @endforeach
                        @endif
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('contact_us')])  href="{{ route('contact_us') }}">Contact</a>
                        </li>
                        @guest
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('login')])  href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('register')])  href="{{ route('register') }}">Register</a>
                        </li>
                        @endguest
                        @auth
                        <li class="text-start py-2">
                            <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <input type="submit" value="Logout"  class="hover:text-primary dark:text-secondary dark:hover:text-primary cursor-pointer">
                            </form>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <livewire:global-search/>
        </div>
        <div class="flex justify-between">
            <livewire:mobile-cart-side-bar/>
            @auth
                <div class="dropdown dropdown-end -mt-2">
                   <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                       <div class="w-8 rounded-full">
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
            @endauth
        </div>
    </nav>
</div>
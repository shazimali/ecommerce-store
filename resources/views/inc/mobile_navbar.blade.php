<div class="mobile-navbar lg:hidden md:hidden px-2"
x-data="{mobileMenu: false, mobileNewArr: false}"
>
    <nav class="flex justify-between border-secondary border dark:border-slate-800 p-2 static">
        <a class="font-semibold text-2xl" href="{{ route('home') }}">
            <span class="text-primary dark:text-secondary">Every Day</span>
            <span class="dark:text-primary">{{ website()->title }}</span>
        </a>
        <div class="drawer drawer-start w-6">
            <input id="mobile-menu" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content cursor-pointer">
                <label for="mobile-menu" class="drawer-button">
                    <i class="fa-solid fa-bars text-slate-500 text-2xl"></i>
                </label>
            </div>
        
            <div class="drawer-side z-50">
                <label for="mobile-menu" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="menu  bg-white dark:bg-black min-h-full w-64 p-4 text-start">
                    <ul>
                        <li class="text-start py-2">
                            <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('home')])  href="{{ route('home') }}">Home</a>
                        </li>
                        <li x-on:click="mobileNewArr = !mobileNewArr" class="py-2 text-start">
                                <div class="flex justify-between">
                                    New Arrival
                                    <div>
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                </div>
                                
                            <div
                            x-show="mobileNewArr"
                            class="bg-white mt-5 absolute z-50 block">
                            @foreach (newArrivals() as $new_pr)
                            <div class="text-center relative dark:text-secondary px-5 py-5">
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
                                    {{-- <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary" href="">
                                        <i class="fa-solid fa-cart-shopping text-primary"></i>
                                        Add to Cart
                                    </a> --}}
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
                                    @if(count($category->sub_categories))
                                    @foreach ($category->sub_categories as $sub_cat)
                                        <a class="underline" href="{{ route('sub-categories',['slug' => $sub_cat->slug ]) }}">{{ $sub_cat->title }}</a>
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
                            <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Contact</a>
                        </li>
                        <li class="text-start py-2">
                            <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Login</a>
                        </li>
                        <li class="text-start py-2">
                            <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
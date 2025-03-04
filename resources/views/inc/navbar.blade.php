<div>
    <div x-data="{menu: true, sideBarOpen: false, newArOpen: false}"
class="lg:block md:block sm:hidden xs:hidden">
        <div class="grid lg:grid-cols-4 md:grid-cols-4 gap-5 px-8">
            <div class="w-full">
                <x-categories-menu/>
            </div>
            <div  class="col-span-3 grid grid-cols-2 py-5 dark:bg-black relative">
                <ul class="flex">
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('home')])  href="{{ route('home') }}">Home</a>
                    </li>
                    {{-- @if (count($global_new_products) > 0)
                        <li
                        x-on:click="newArOpen = ! newArOpen"
                        class="mr-6">
                            <a 
                            class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">
                                New Arrivals <i class="fa-solid fa-caret-down"></i>
                            </a>
                        </li>
                    @endif --}}
                    <li class="mr-6">
                        <a @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('shop')])  href="">Shop</a>
                    </li>
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('blogs') || Route::is('blogs.detail') ])  href="">Blogs</a>
                    </li>
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('about')])  href="">About</a>
                    </li>
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Contact</a>
                    </li>
                    </ul>
                <ul class="flex justify-end">
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Login</a>
                    </li>
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">Register</a>
                    </li>
                </ul>
                {{-- <div
                x-show="newArOpen"
                style="top: 60px"
                class="bg-white dark:bg-black z-50 min-h-64 w-full absolute flex justify-between py-10 px-10">
                    @foreach ($global_new_products as $new_pr)
                        <div class="text-center relative dark:text-secondary">
                            @if ($new_pr->countries->where('id',getLocation()->id)->first()->pivot->disc_from >= Carbon\Carbon::today()->toDateString() || $new_pr->countries->where('id',getLocation()->id)->first()->pivot->disc_to >= Carbon\Carbon::today()->toDateString())
                            <div class="absolute right-1 rounded-full  top-1 w-auto px-3 py-2 bg-green-600 text-white text-[8px] text-center">{{ $new_pr->countries->where('id',getLocation()->id)->first()->pivot->discount }} %</br> off</div>
                            @endif
                                <img
                                    src="{{ asset('storage/'.$new_pr->nav_image) }}"
                                    class=" max-h-52"
                                    alt="{{ $new_pr->title }}" />
                                <div class="pt-2 overflow-hidden max-w-36 text-xs truncate">                {{$new_pr->title }}     
                                </div>
                                @if ($new_pr->countries->where('id',getLocation()->id)->first()->pivot->disc_from >= Carbon\Carbon::today()->toDateString() || $new_pr->countries->where('id',getLocation()->id)->first()->pivot->disc_to >= Carbon\Carbon::today()->toDateString())
                                    <div class="pt-2 overflow-hidden max-w-36 text-xs truncate text-center">
                                        <b>{{ getLocation()->currency }}</b>{{ number_format($new_pr->countries->where('id',getLocation()->id)->first()->pivot->price - ($new_pr->countries->where('id',getLocation()->id)->first()->pivot->price/100*$new_pr->countries->where('id',getLocation()->id)->first()->pivot->discount),2) }}
                                        <del class="text-gray-500 text-xs">
                                            {{ number_format($new_pr->countries->where('id',getLocation()->id)->first()->pivot->price,2) }}
                                        </del>
                                    </div>
                                    @else
                                    <div class="text-xs text-center">
                                        <b>{{ getLocation()->currency }}</b>{{ number_format($new_pr->countries->where('id',getLocation()->id)->first()->pivot->price,2)  }} 
                                    </div>
                                    @endif
                                <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary my-2" href="{{ route('product.detail', ['slug' => $new_pr->slug]) }}">
                                    <i class="fa-regular fa-eye text-primary"></i>
                                    View Detail
                                </a>
                                <a class="block text-xs border border-secondary p-1 hover:text-primary hover:border-primary" href="">
                                    <i class="fa-solid fa-cart-shopping text-primary"></i>
                                    Add to Cart
                                </a>
                        </div>
                    @endforeach   
                </div> --}}
                @if (request()->routeIs('home'))
                    <x-banners/>
                @endif
            </div>
        </div>
    </div>
    {{-- @include('inc.mobile_nav_bar')
    <div class="lg:hidden md:hidden sm:hidden xs:block lg:px-8 md:px-8 xs:px-2">
        <livewire:partials.mobile-banners  lazy/>
    </div> --}}
</div>
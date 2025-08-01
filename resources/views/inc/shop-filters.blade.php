<a class="text-xs cursor-pointer hover:text-primary 
    hover:underline dark:text-white dark:hover:text-primary"
    href="{{ route('shop') }}">
    clear all filters
</a>
<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white">Filter by category</h3>

<ul>
    <li>
        <input class=" hover:bg-primary checked:bg-primary 
                            focus:bg-primary focus:ring-opacity-25 
                            focus:ring-primary border-gray-500" 
                            type="radio"
                            name="sub_category"
                            {{ $category == 'all' ? 'checked' : '' }}
                            wire:click="updateFilter('category_type','all')"x/>
        <label class="lg:text-sm md:text-sm sm:text-xs xs:text-xs pl-2 font-semibold dark:text-white">All</label>
    </li>
    @foreach ($categories as $cat)
        <li class="py-2" x-data="{children: false}">
            <input class=" hover:bg-primary checked:bg-primary 
                            focus:bg-primary focus:ring-opacity-25 
                            focus:ring-primary border-gray-500 dark:text-white" 
                            type="radio"
                            wire:click="updateFilter('category_type','{{ $cat->slug }}')"
                            id="{{ $cat->slug }}"
                            name="category"
                            wire:key="{{ $cat->slug }}"
                            {{ $category == $cat->slug ? 'checked' : '' }}
                            value="{{ $cat->slug }}"
                            @click="children = ! children" />
            <label class="lg:text-sm md:text-sm sm:text-xs xs:text-xs pl-2 font-semibold dark:text-white">{{ $cat->title }}</label>
            @if (count($cat->sub_categories))
                <ul class="ml-5" x-show="children">
                    @foreach ($cat->sub_categories as $sub_cat)
                    <li>
                        <input class=" hover:bg-primary checked:bg-primary 
                        focus:bg-primary focus:ring-opacity-25 
                    focus:ring-primary border-gray-500 dark:text-white" 
                        wire:click="updateFilter('sub_category_type','{{ $sub_cat->slug }}')"
                        id="{{ $cat->slug }}"
                        name="category"
                        type="radio"
                        wire:key="{{ $sub_cat->slug }}"
                        {{ $category == $sub_cat->slug ? 'checked' : '' }}
                        value="{{ $sub_cat->slug }}">
                        <label class="lg:text-sm md:text-sm sm:text-xs xs:text-xs pl-2 font-semibold">{{ $sub_cat->title }}</label>
                    </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white">Filter by colors</h3>
<ul>
    @foreach ($colors as $clr)
        <li class="py-2">
            <input class=" hover:bg-primary checked:bg-primary 
                            focus:bg-primary focus:ring-opacity-25 
                            focus:ring-primary border-gray-500 dark:text-white" 
                            type="radio"
                            wire:click="updateFilter('color','{{ $clr->color_name }}')"
                            id="{{ $clr->id }}"
                            name="color"
                            type="radio"
                            wire:key="{{ $clr->color_name }}"
                            value="{{ $clr->color_name }}"
                            >
            <label class="lg:text-sm md:text-sm sm:text-xs xs:text-xs pl-2 font-semibold dark:text-white">{{ $clr->color_name }}</label>
        </li>
    @endforeach
</ul>
<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white">Filter by rating</h3>
<ul>
    <li class="lg:flex md:flex sm:flex-row xs:flex-row py-2 cursor-pointer" wire:click="updateFilter('rating',1)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 text-primary cursor-pointer">
        <path fill-rule="evenodd"
        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
        clip-rule="evenodd"></path>
        </svg>
        @for ($i = 0; $i < 4;  $i++)   
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 cursor-pointer dark:text-white text-blue-gray-500">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
            </path>
            </svg>
        @endfor 
    </li>
    <li class="lg:flex md:flex sm:flex-row xs:flex-row  py-2 cursor-pointer" wire:click="updateFilter('rating',2)">
        @for ($i = 0; $i < 2;  $i++) 
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 text-primary cursor-pointer">
        <path fill-rule="evenodd"
        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
        clip-rule="evenodd"></path>
        </svg>
        @endfor
        @for ($i = 0; $i < 3;  $i++)   
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 cursor-pointer dark:text-white text-blue-gray-500">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
            </path>
            </svg>
        @endfor 
    </li>
    <li class="lg:flex md:flex sm:flex-row xs:flex-row py-2 cursor-pointer" wire:click="updateFilter('rating',3)">
        @for ($i = 0; $i < 3;  $i++) 
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 text-primary cursor-pointer">
        <path fill-rule="evenodd"
        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
        clip-rule="evenodd"></path>
        </svg>
        @endfor
        @for ($i = 0; $i < 2;  $i++)   
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 cursor-pointer text-blue-gray-500 dark:text-white">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
            </path>
            </svg>
        @endfor 
    </li>
    <li class="lg:flex md:flex sm:flex-row xs:flex-row py-2 cursor-pointer" wire:click="updateFilter('rating',4)">
        @for ($i = 0; $i < 4;  $i++) 
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 text-primary cursor-pointer">
        <path fill-rule="evenodd"
        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
        clip-rule="evenodd"></path>
        </svg>
        @endfor
        @for ($i = 0; $i < 1;  $i++)   
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 cursor-pointer text-blue-gray-500 dark:text-white">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z">
            </path>
            </svg>
        @endfor 
    </li>
    <li class="lg:flex md:flex sm:flex-row xs:flex-row py-2 cursor-pointer" wire:click="updateFilter('rating',5)">
        @for ($i = 0; $i < 5;  $i++) 
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
        fill="currentColor" class="lg:w-6 md:w-6 lg:h-6 md:h-6 sm:w-12 xs:w-12 sm:h-12 xs:h-12 text-primary cursor-pointer">
        <path fill-rule="evenodd"
        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
        clip-rule="evenodd"></path>
        </svg>
        @endfor
    </li>
</ul>
<h3 class="lg:text-2xl md:text-2xl sm:text-1xl xs:text-1xl font-semibold dark:text-white">Filter by price</h3>
<div class="py-3 pr-5">
    <input type="range" step="1" wire:model="price_from" wire:change="updateFilter('price',$event.target.value)">
    <div class="flex justify-between py-2 dark:text-white">
        <span><b>{{ getLocation()->currency }}</b>{{ $price_from }}</span>
        <span><b>{{ getLocation()->currency }}</b>{{ $price_to }}</span>
    </div>
</div>
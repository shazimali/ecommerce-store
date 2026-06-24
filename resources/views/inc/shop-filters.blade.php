<div class="space-y-6">
    <!-- Filter Header -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Filters</span>
        @if($category || $sub_category || $color || $rating || $price_from != getSettingVal('shop_filter_price_from') || $price_to != getSettingVal('shop_filter_price_to'))
            <a class="text-xs font-semibold text-primary hover:underline transition-colors" href="{{ route('shop') }}">
                Clear All
            </a>
        @endif
    </div>

    <!-- Category Filter -->
    <div class="pb-5 border-b border-slate-200 dark:border-slate-800">
        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-wide uppercase mb-3">Categories</h4>
        <ul class="space-y-2">
            <!-- All Categories Option -->
            <li class="flex items-center">
                <input class="w-4 h-4 text-primary bg-slate-50 border-slate-300 focus:ring-primary focus:ring-2 accent-primary cursor-pointer" 
                       type="radio"
                       id="cat_all"
                       name="category_filter"
                       {{ $category == 'all' || empty($category) ? 'checked' : '' }}
                       wire:click="updateFilter('category_type','all')" />
                <label class="text-sm pl-2 font-medium text-slate-700 dark:text-slate-300 cursor-pointer select-none" for="cat_all">All Products</label>
            </li>
            
            @foreach ($categories as $cat)
                @php
                    $isCurrentCat = ($category == $cat->slug);
                    $hasSubcategories = count($cat->sub_categories) > 0;
                @endphp
                <li class="space-y-1.5" x-data="{ children: {{ $isCurrentCat ? 'true' : 'false' }} }">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input class="w-4 h-4 text-primary bg-slate-50 border-slate-300 focus:ring-primary focus:ring-2 accent-primary cursor-pointer" 
                                   type="radio"
                                   wire:click="updateFilter('category_type','{{ $cat->slug }}')"
                                   id="cat_{{ $cat->slug }}"
                                   name="category_filter"
                                   wire:key="cat_key_{{ $cat->slug }}"
                                   {{ $isCurrentCat ? 'checked' : '' }}
                                   value="{{ $cat->slug }}"
                                   @click="children = ! children" />
                            <label class="text-sm pl-2 font-medium text-slate-700 dark:text-slate-300 cursor-pointer select-none" for="cat_{{ $cat->slug }}">
                                {{ $cat->title }}
                            </label>
                        </div>
                        @if ($hasSubcategories)
                            <button @click="children = ! children" type="button" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 focus:outline-none pr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3 transform transition-transform duration-200" :class="children ? 'rotate-180' : ''">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    @if ($hasSubcategories)
                        <ul class="pl-6 space-y-2 border-l border-slate-100 dark:border-slate-800 ml-2 py-1" x-show="children" x-transition>
                            @foreach ($cat->sub_categories as $sub_cat)
                                <li class="flex items-center">
                                    <input class="w-3.5 h-3.5 text-primary bg-slate-50 border-slate-300 focus:ring-primary focus:ring-2 accent-primary cursor-pointer" 
                                           wire:click="updateFilter('sub_category_type','{{ $sub_cat->slug }}')"
                                           id="sub_{{ $sub_cat->slug }}"
                                           name="sub_category_filter"
                                           type="radio"
                                           wire:key="sub_key_{{ $sub_cat->slug }}"
                                           {{ $sub_category == $sub_cat->slug ? 'checked' : '' }}
                                           value="{{ $sub_cat->slug }}">
                                    <label class="text-xs pl-2 font-medium text-slate-600 dark:text-slate-400 cursor-pointer select-none" for="sub_{{ $sub_cat->slug }}">
                                        {{ $sub_cat->title }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Colors Filter -->
    <div class="pb-5 border-b border-slate-200 dark:border-slate-800">
        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-wide uppercase mb-3">Colors</h4>
        <ul class="space-y-2">
            @foreach ($colors as $clr)
                @php
                    $colorSlug = Str::slug($clr->color_name);
                @endphp
                <li class="flex items-center">
                    <input class="w-4 h-4 text-primary bg-slate-50 border-slate-300 focus:ring-primary focus:ring-2 accent-primary cursor-pointer" 
                           type="radio"
                           wire:click="updateFilter('color','{{ $clr->color_name }}')"
                           id="color_{{ $colorSlug }}"
                           name="color_filter"
                           wire:key="color_key_{{ $colorSlug }}"
                           {{ $color == $clr->color_name ? 'checked' : '' }}
                           value="{{ $clr->color_name }}">
                    <label class="text-sm pl-2 font-medium text-slate-700 dark:text-slate-300 cursor-pointer select-none" for="color_{{ $colorSlug }}">
                        {{ $clr->color_name }}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Ratings Filter -->
    <div class="pb-5 border-b border-slate-200 dark:border-slate-800">
        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-wide uppercase mb-3">Rating</h4>
        <ul class="space-y-1">
            @for ($r = 5; $r >= 1; $r--)
                <li class="flex items-center justify-between py-1.5 px-2.5 rounded-lg cursor-pointer transition-all duration-200 {{ $rating == $r ? 'bg-primary/10 border border-primary/20 text-primary' : 'hover:bg-slate-50 dark:hover:bg-slate-900 border border-transparent text-slate-700 dark:text-slate-300' }}"
                    wire:click="updateFilter('rating', {{ $r }})">
                    <div class="flex items-center gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $r)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-primary">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-300 dark:text-slate-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs font-semibold tracking-wider opacity-90">{{ $r }} & Up</span>
                </li>
            @endfor
        </ul>
    </div>

    <!-- Price Filter -->
    <div class="pb-5">
        <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-wide uppercase mb-3">Price Range</h4>
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <div class="relative w-1/2">
                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 dark:text-slate-500">{{ getLocation()->currency }}</span>
                    <input type="number" 
                           min="{{ getSettingVal('shop_filter_price_from') }}" 
                           max="{{ getSettingVal('shop_filter_price_to') }}" 
                           wire:model.live.debounce.500ms="price_from" 
                           wire:change="updateFilter('price_from', $event.target.value)"
                           class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg pl-9 pr-1.5 py-1.5 text-xs dark:text-white focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary font-medium">
                </div>
                <span class="text-slate-400 dark:text-slate-600">-</span>
                <div class="relative w-1/2">
                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 dark:text-slate-500">{{ getLocation()->currency }}</span>
                    <input type="number" 
                           min="{{ getSettingVal('shop_filter_price_from') }}" 
                           max="{{ getSettingVal('shop_filter_price_to') }}" 
                           wire:model.live.debounce.500ms="price_to" 
                           wire:change="updateFilter('price_to', $event.target.value)"
                           class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg pl-9 pr-1.5 py-1.5 text-xs dark:text-white focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary font-medium">
                </div>
            </div>

            <div>
                <input type="range" 
                       min="{{ getSettingVal('shop_filter_price_from') }}" 
                       max="{{ getSettingVal('shop_filter_price_to') }}" 
                       step="10" 
                       wire:model.live="price_to" 
                       wire:change="updateFilter('price_to', $event.target.value)"
                       class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer accent-primary">
                <div class="flex justify-between text-[10px] text-slate-400 dark:text-slate-500 mt-2 font-semibold">
                    <span>Min: {{ getLocation()->currency }} {{ getSettingVal('shop_filter_price_from') }}</span>
                    <span>Max: {{ getLocation()->currency }} {{ getSettingVal('shop_filter_price_to') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<ul>
    <li
        x-on:click="menu = ! menu"
        class="bg-primary block py-5 font-normal pl-5 border-secondary dark:text-white dark:border-slate-800 border-b">
        Collections
        <div class="float-end inline-block pr-5">
            <i class="fa-solid fa-caret-down"></i>
        </div>
    </li>
    
    <li 
        x-show="menu"
        x-transition.duration.300ms
        @class(['z-50'])
        >
        <ul>
            @foreach (website()->categories as $category)
            <li
            x-data="{sideBarOpen:false}"
            x-on:mouseenter="sideBarOpen = true;"
            x-on:mouseleave="sideBarOpen = false;"
            class="relative cursor-pointer pl-5 block font-normal py-2 border-secondary border-b border-l border-r dark:text-secondary dark:border-slate-800 dark:bg-black">
                {{ $category->title }}
                <div class="float-end inline-block pr-5">
                    <i class="fa-solid fa-caret-right"></i>
                </div>
                @if (count($category->sub_categories))
                    <div
                    x-show="sideBarOpen"
                    style="left: 300px"
                    x-transition.duration.300ms
                    x-data="{
                    'selectedImage':'{{ asset('storage/'.$category->image) }}'
                    }"
                    class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">
                        <div>
                            <h1 class="uppercase font-bold">Categories</h1>
                            <ul class="mt-2">
                                @foreach ($category->sub_categories as $sub_cat)
                                    <li 
                                    x-on:mouseover="selectedImage = `{{ asset('storage/'.$sub_cat->image) }}`"
                                    x-on:mouseout="selectedImage = `{{ asset('storage/'.$category->image) }}`"
                                    class="hover:text-primary" >
                                        <a href="">{{ $sub_cat->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="text-end">
                            <img
                            x-bind:src="selectedImage"
                            class="max-h-52"
                            alt="{{ $category->title }}" />
                        </div>
                    </div>
                @endif
            </li>
            @endforeach
        </ul>
    </li>
    
</ul>
<div>
    <div x-data="{menu: true, sideBarOpen: false, newArOpen: false}" class="lg:block md:block sm:hidden xs:hidden">
        <div class="grid lg:grid-cols-4 md:grid-cols-4 gap-5 px-8">
            <div class="w-full">
                <ul>
                    <li x-on:click="menu = ! menu"
                        class="bg-primary block py-5 font-normal pl-5 border-secondary dark:text-white dark:border-slate-800 border-b">
                        Collections
                        <div class="float-end inline-block pr-5">
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </li>
                    <li x-show="menu" x-transition.duration.300ms class= 'z-50 absolute bg-white' style="width:22.5%">
                        @include('inc.collection_with_list')

                    </li>
                </ul>
            </div>
            <div class="col-span-3 grid grid-cols-2 py-5 dark:bg-black relative">
                <ul class="flex">
                    <li class="mr-6">
                        <a @class([
                            'hover:text-primary dark:text-secondary dark:hover:text-primary',
                            'text-primary' => Route::is('home'),
                        ]) href="{{ route('home') }}">Home</a>
                    </li>
                    <li x-on:click="newArOpen = ! newArOpen" class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">
                            New Arrivals <i class="fa-solid fa-caret-down"></i>
                        </a>
                    </li>
                    <li class="mr-6">
                        <a @class([
                            'hover:text-primary dark:text-secondary dark:hover:text-primary',
                        ]) href="">Shop</a>
                    </li>
                    <li class="mr-6">
                        <a @class([
                            'hover:text-primary dark:text-secondary dark:hover:text-primary',
                        ]) href="">Blogs</a>
                    </li>
                    <li class="mr-6">
                        <a @class([
                            'hover:text-primary dark:text-secondary dark:hover:text-primary',
                        ]) href="">About</a>
                    </li>
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                            href="#">Contact</a>
                    </li>
                </ul>
                <ul class="flex justify-end">
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                            href="#">Login</a>
                    </li>
                    <li class="mr-6">
                        <a class="hover:text-primary dark:text-secondary dark:hover:text-primary"
                            href="#">Register</a>
                    </li>
                </ul>
            </div>
        </div>
        <div x-show="newArOpen">
            <div class="ml-[28%] grid grid-cols-3 bg-white ">
                <div class="max-w-52">
                    <img src="https://everydayplastic.co/storage/01JCAQVHGER1Q4FA0X1R3V0WWT.png" alt=""
                        class="max-h-52">
                    <p class="pl-4"> Plate Rocks (2 in 1)</p>
                    <div class="text-xs text-center">
                        <h4 class="py-2"><span class="font-bold">PKR</span> 2,607.00</h4>
                        <a class="block  border border-secondary  hover:text-primary hover:border-primary py-2"
                            href="#"><i class="fa-regular fa-eye text-primary pr-1"></i>View
                            Detail</a>
                        <a class="block  border border-secondary  hover:text-primary hover:border-primary mt-3 py-2"
                            href="#"><i class="fa-solid fa-cart-shopping text-primary pr-1"></i>Add to Card</a>
                    </div>

                </div>
                <div class="max-w-52">
                    <img src="https://everydayplastic.co/storage/01JCAQVHGER1Q4FA0X1R3V0WWT.png" alt=""
                        class="max-h-52">
                    <p class="pl-4"> Plate Rocks (2 in 1)</p>
                    <div class="text-xs text-center">
                        <h4 class="py-2"><span class="font-bold">PKR</span> 2,607.00</h4>
                        <a class="block  border border-secondary  hover:text-primary hover:border-primary py-2"
                            href="#"><i class="fa-regular fa-eye text-primary pr-1"></i>View
                            Detail</a>
                        <a class="block  border border-secondary  hover:text-primary hover:border-primary mt-3 py-2"
                            href="#"><i class="fa-solid fa-cart-shopping text-primary pr-1"></i>Add to Card</a>
                    </div>

                </div>


            </div>


        </div>
    </div>
</div>

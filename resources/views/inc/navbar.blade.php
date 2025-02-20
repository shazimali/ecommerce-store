<div>
    <div x-data="{menu: true, sideBarOpen: false, newArOpen: false}" class="lg:block md:block sm:hidden xs:hidden">
        <div class="grid lg:grid-cols-4 md:grid-cols-4 gap-5 px-8">
            <div class="w-full">
                <ul>
                    <li
                        x-on:click="menu = ! menu"
                        class="bg-primary block py-5 font-normal pl-5 border-secondary dark:text-white dark:border-slate-800 border-b">
                        Collections
                        <div class="float-end inline-block pr-5">
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </li>
                </ul>
            </div>
            <div  class="col-span-3 grid grid-cols-2 py-5 dark:bg-black relative">
                <ul class="flex">
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary','text-primary' => Route::is('home')])  href="{{ route('home') }}">Home</a>
                    </li>
                        <li
                        x-on:click="newArOpen = ! newArOpen"
                        class="mr-6">
                            <a 
                            class="hover:text-primary dark:text-secondary dark:hover:text-primary" href="#">
                                New Arrivals <i class="fa-solid fa-caret-down"></i>
                            </a>
                        </li>
                    <li class="mr-6">
                        <a @class(['hover:text-primary dark:text-secondary dark:hover:text-primary'])  href="">Shop</a>
                    </li>
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary'])  href="">Blogs</a>
                    </li>
                    <li class="mr-6">
                        <a  @class(['hover:text-primary dark:text-secondary dark:hover:text-primary'])  href="">About</a>
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
            </div>
        </div>
    </div>
</div>
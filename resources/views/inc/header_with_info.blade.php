<div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 xs:grid-cols-1 bg-secondary dark:bg-black py-2 px-8 font-normal dark:border-b dark:border-b-slate-800">
    <div class="hidden md:block lg:block">
        <a class="hover:text-primary dark:text-secondary border-solid border-black dark:border-secondary border-r-2 pr-2 dark:hover:text-primary" href="tel:03230203232">
            <i class="fa-solid fa-phone text-primary  dark:hover:text-primary"></i>&nbsp;
            +92 3000 32323232
        </a>
        <a class="hover:text-primary dark:text-secondary pl-3 dark:hover:text-primary" href="mailto:test@email.com" >
            <i class="fa-solid fa-envelope text-primary  dark:hover:text-primary"></i>&nbsp;
            test@email.com
        </a>
    </div>

    <div class="text-center bg-gradient-to-r from-orange-200  via-red-500 to-violet-600 bg-clip-text text-transparent font-semibold">
        welcome message
    </div>
    <div class="hidden md:block lg:block text-end text-black dark:text-primary">        
        @include('inc.social_icons')
        @include('inc.theme_changer')
    </div>
</div>
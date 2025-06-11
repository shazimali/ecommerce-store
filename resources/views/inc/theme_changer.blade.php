<button
        @click="darkMode = !darkMode"
        class="lg:border-l-2 md:border-l-2 lg:border-solid md:border-solid  lg:border-black md:border-black lg:dark:border-primary md:dark:border-primary lg:dark:border-solid md:dark:border-solid lg:dark:border-l-2 md:dark:border-l-2 pl-3"
        >
            <i x-show="!darkMode"  class="fa-solid fa-moon text-black dark:text-primary"></i>
            <i x-show="darkMode" class="fa-solid fa-sun text-secondary dark:text-primary"></i>
</button>
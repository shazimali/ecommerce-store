<button
        @click="darkMode = !darkMode"
        class="lg:border-l-2 md:border-l-2 lg:border-solid md:border-solid md:border-black lg:border-black dark:border-primary dark:border-solid dark:border-l-2 pl-3"
        >
            <i x-show="!darkMode"  class="fa-solid fa-moon text-black dark:text-primary"></i>
            <i x-show="darkMode" class="fa-solid fa-sun text-secondary dark:text-primary"></i>
</button>
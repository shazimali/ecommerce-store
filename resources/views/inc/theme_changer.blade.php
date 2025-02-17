<button
        @click="darkMode = !darkMode"
        class="border-l-2 border-solid border-black dark:border-primary dark:border-solid dark:border-l-2 pl-3"
        >
            <i x-show="!darkMode"  class="fa-solid fa-moon text-black dark:text-primary"></i>
            <i x-show="darkMode" class="fa-solid fa-sun text-secondary dark:text-primary"></i>
</button>
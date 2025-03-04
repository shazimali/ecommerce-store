<div x-data="{ slides: '{{ website()->banners }}'),            
            currentSlideIndex: 1,
            previous() {                
                if (this.currentSlideIndex > 1) {                    
                    this.currentSlideIndex = this.currentSlideIndex - 1                
                } else {   
                    // If it's the first slide, go to the last slide           
                    this.currentSlideIndex = this.slides.length                
                }            
            },            
            next() {                
                if (this.currentSlideIndex < this.slides.length) {                    
                    this.currentSlideIndex = this.currentSlideIndex + 1                
                } else {                 
                    // If it's the last slide, go to the first slide    
                    this.currentSlideIndex = 1                
                }            
            },        
        }" class="relative w-full overflow-hidden col-span-2 mt-6">
            @if (count(website()->banners) > 1)
                <!-- previous button -->
                <button type="button" class="absolute left-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/40 p-2 text-slate-700 transition hover:bg-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:outline-offset-0 dark:bg-slate-900/40 dark:text-slate-300 dark:hover:bg-slate-900/60 dark:focus-visible:outline-blue-600" aria-label="previous slide" x-on:click="previous()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pr-0.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
            
                <!-- next button -->
                <button type="button" class="absolute right-5 top-1/2 z-20 flex rounded-full -translate-y-1/2 items-center justify-center bg-white/40 p-2 text-slate-700 transition hover:bg-white/60 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 active:outline-offset-0 dark:bg-slate-900/40 dark:text-slate-300 dark:hover:bg-slate-900/60 dark:focus-visible:outline-blue-600" aria-label="next slide" x-on:click="next()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="3" class="size-5 md:size-6 pl-0.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            @endif
            
            <!-- slides -->
            <!-- Change min-h-[50svh] to your preferred height size -->
            <div class="relative lg:min-h-[50vh] md:min-h-[50vh] xs:min-h-[25vh] w-full">
                <template x-for="(slide, index) in slides">
                    <div x-show="currentSlideIndex == index + 1" class="absolute inset-0" x-transition.opacity.duration.1000ms>
                        <div class="absolute w-full h-full text-slate-700 dark:text-slate-300" :style="`background-image: url('${slide.imgSrc}')`">
                                <div class="flex items-end justify-center h-1/2 px-20">
                                    <h3 class="text-white uppercase font-semibold text-xl" x-text="slide.subHeading"></h3>
                                </div>
                                <div x-show="slide.heading" class="flex items-start justify-center h-1/4 px-20">
                                    <h1 class="text-white font-bold text-6xl" x-text="slide.heading"></h1>
                                </div> 
                                <div x-show="slide.btn" class="flex items-start justify-center h-1/3 px-20">
                                    <a class="bg-white text-black py-2 px-5 rounded" :href="slide.btn_link" x-text="slide.btn"></a>
                                </div>                                                         
                        </div>
                    </div>
                </template>
            </div>
            @if (count(website()->banners ) > 1)
            <!-- indicators -->
            <div class="absolute rounded-xl bottom-3 md:bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-4 md:gap-3 bg-white/75 px-1.5 py-1 md:px-2 dark:bg-slate-900/75" role="group" aria-label="slides" >
                <template x-for="(slide, index) in slides">
                    <button class="size-2 cursor-pointer rounded-full transition bg-slate-700 dark:bg-slate-300" x-on:click="currentSlideIndex = index + 1" x-bind:class="[currentSlideIndex === index + 1 ? 'bg-slate-700 dark:bg-slate-300' : 'bg-slate-700/50 dark:bg-slate-300/50']" x-bind:aria-label="'slide ' + (index + 1)"></button>
                </template>
            </div>
            @endif
</div> 

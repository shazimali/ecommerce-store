<ul>

    <li x-data="{ sideBarOpen: false }"  x-on:mouseenter="sideBarOpen = true;" x-on:mouseleave="sideBarOpen = false;"
        class="relative cursor-pointer pl-5 block font-normal py-2 border-secondary border-b border-l border-r dark:text-secondary dark:border-slate-800 dark:bg-black">
        Spice Kitchen Rack
        <div class="float-end inline-block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{
            'selectedImage': 'https://everydayplastic.co/storage/01JBXZHP341RFZJ6FSC6CQ4NW6.png'
        }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">
            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZHP341RFZJ6FSC6CQ4NW6.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZHP341RFZJ6FSC6CQ4NW6.png'"
                        class="hover:text-primary">
                        <a href="">Plastic Spice Rocks</a>
                    </li>
                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZHP341RFZJ6FSC6CQ4NW6.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZHP341RFZJ6FSC6CQ4NW6.png'"
                        class="hover:text-primary">
                        <a href="">Wooden Spice Rocks</a>
                    </li>

                </ul>
            </div>
            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>

    </li>

    <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true;" x-on:mouseleave="sideBarOpen = false;"
        class="relative cursor-pointer pl-5 block font-normal py-2 border-secondary border-b border-l border-r dark:text-secondary dark:border-slate-800 dark:bg-black">
        Plastic Kitchen Organizer Racks
        <div class="float-end inline-block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{
            'selectedImage': 'https://everydayplastic.co/storage/01JBXZK83MQSGYFRNB3RNJ400T.png'
        }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">
            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZK83MQSGYFRNB3RNJ400T.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZK83MQSGYFRNB3RNJ400T.png'"
                        class="hover:text-primary">
                        <a href="">Organizer Racks</a>
                    </li>
                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZK83MQSGYFRNB3RNJ400T.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZK83MQSGYFRNB3RNJ400T.png'"
                        class="hover:text-primary">
                        <a href="">Organizer Racks with Tray</a>
                    </li>

                </ul>
            </div>
            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>

    </li>

    <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true;" x-on:mouseleave="sideBarOpen = false;"
        class="relative cursor-pointer pl-5 block font-normal py-2 border-secondary border-b border-l border-r dark:text-secondary dark:border-slate-800 dark:bg-black">
        Plastic Tables
        <div class="float-end inline-block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{
            'selectedImage': 'https://everydayplastic.co/storage/01JBXZNBMCYR8ST99RJAD3ZANP.png'
        }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">
            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZNBMCYR8ST99RJAD3ZANP.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZNBMCYR8ST99RJAD3ZANP.png'"
                        class="hover:text-primary">
                        <a href="">Square Tables</a>
                    </li>


                </ul>
            </div>
            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>

    </li>

    <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true" x-on:mouseleave="sideBarOpen = false"
        class="relative cursor-pointer pl-5 font-normal border border-1 block py-2 border-secondary border-b border-r dark:border-slate-800 dark: dark:bg-black">
        Plastic Chairs
        <div class="float-end block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{ 'selectedImage': 'https://everydayplastic.co/storage/01JBXZR1HGXRJYF7DNYH0C5RGX.png' }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">

            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZR1HGXRJYF7DNYH0C5RGX.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZR1HGXRJYF7DNYH0C5RGX.png'"
                        class="hover:text-primary">
                        <a href="">Rocking Chairs</a>
                    </li>
                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZR1HGXRJYF7DNYH0C5RGX.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZR1HGXRJYF7DNYH0C5RGX.png'"
                        class="hover:text-primary">
                        <a href="">Baby Chairs</a>
                    </li>


                </ul>
            </div>


            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>


    </li>

    <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true" x-on:mouseleave="sideBarOpen = false"
        class="relative cursor-pointer pl-5 font-normal border border-1 block py-2 border-secondary border-b border-r dark:border-slate-800 dark: dark:bg-black">
        Dry Fruits & Despensors
        <div class="float-end block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{ 'selectedImage': 'https://everydayplastic.co/storage/01JBXZSWA18BYEMFX11B0VBY33.png' }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">

            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZSWA18BYEMFX11B0VBY33.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZSWA18BYEMFX11B0VBY33.png'"
                        class="hover:text-primary">
                        <a href="">Despensors</a>
                    </li>
                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZSWA18BYEMFX11B0VBY33.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZSWA18BYEMFX11B0VBY33.png'"
                        class="hover:text-primary">
                        <a href="">Dry Fruits</a>
                    </li>


                </ul>
            </div>


            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>


    </li>


    <li x-data="{ sideBarOpen: false }" x-on:mouseenter="sideBarOpen = true" x-on:mouseleave="sideBarOpen = false"
        class="relative cursor-pointer pl-5 font-normal border border-1 block py-2 border-secondary border-b border-r dark:border-slate-800 dark: dark:bg-black">
        Jugs & Glasses
        <div class="float-end block pr-5">
            <i class="fa-solid fa-caret-right"></i>
        </div>

        <div x-show="sideBarOpen" style="left: 300px" x-transition.duration.300ms x-data="{ 'selectedImage': 'https://everydayplastic.co/storage/01JBXZVCHQM3SK4XRJ3KZETWHG.png' }"
            class="dark:bg-black dark:text-secondary dark:border-slate-700 absolute min-w-96 border border-secondary grid grid-cols-2 z-50 bg-white px-5 py-5">

            <div>
                <h1 class="uppercase font-bold">Categories</h1>
                <ul class="mt-2">

                    <li x-on:mouseover="selectedImage = 'https://everydayplastic.co/storage/01JBXZVCHQM3SK4XRJ3KZETWHG.png'"
                        x-on:mouseout="selectedImage = 'https://everydayplastic.co/storage/01JBXZVCHQM3SK4XRJ3KZETWHG.png'"
                        class="hover:text-primary">
                        <a href="">Glasses (Acrylic)</a>
                    </li>


                </ul>
            </div>


            <div class="text-end">
                <img x-bind:src="selectedImage" class="max-h-52" alt="" />
            </div>
        </div>


    </li>

</ul>

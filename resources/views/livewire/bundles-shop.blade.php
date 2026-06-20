<div class="py-10 px-8 text-black">
    <div>
        <div class="flex justify-center items-center mb-5">
            <h1 class="text-3xl font-extrabold dark:text-white">Our Bundles</h1>
        </div>
        <div class="mt-5 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 xs:grid-cols-2 gap-5">
            @foreach ($bundles as $key => $bundle)
                @include('inc.bundle_box')
            @endforeach
        </div>
        <div class="py-2 mt-5">
            {{ $bundles->links() }}
        </div>
    </div>
</div>
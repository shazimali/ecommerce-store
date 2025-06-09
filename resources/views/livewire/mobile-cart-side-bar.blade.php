<div class="drawer drawer-end">
    <input id="mob-cart-side-bar" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content mt-[0.4rem] cursor-pointer">
        <label for="mob-cart-side-bar"
            class="drawer-button text-primary border border-solid border-secondary dark:border-slate-800 py-2 px-6">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="text-gray-500 text-sm font-semibold">{{ $cart_count }}</span>
        </label>
    </div>

    <div class="drawer-side text-black z-50">
        <label for="mob-cart-side-bar" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="menu  bg-white dark:bg-black min-h-full w-72 p-4 text-start">
            <div class="flex justify-between border-b border-b-secondary dark:border-b-slate-800">
                <h1 class="uppercase text-1xl dark:text-white font-semibold pb-1">your Cart ({{ $cart_count }})</h1>
            </div>
            @if($cart_count > 0)
            @foreach ($cartItems as $crt)
                <livewire:cart-side-bar-row :$crt :key="time().$crt['slug'].$crt['color']" />
            @endforeach
            <div @class([
                'mt-2 text-end' => true,
                'hidden' => $cart_count == 0])>
                <div class="text-1xl font-semibold dark:text-white">Subtotal {{ getLocation()->currency }} {{ number_format($sub_total,2)  }} </div>  
                    <div class="text-xs dark:text-white">Taxes and shipping calculated at checkout</div>
                    <div class="uppercase text-xs font-semibold bg-primary text-white mt-1 w-full py-2 text-center">
                        <a href="{{ route('checkout') }}">check out</a>
                    </div>
                    <div class="uppercase text-xs font-semibold bg-secondary w-full py-2 my-2 text-center">
                        <a href="{{ route('cart') }}">View Cart</a>
                    </div>
                    
            </div>
            @else
            <h3 class=" dark:text-white">Your cart is currently empty.</h3>
            @endif
        </div>
    </div>
</div>

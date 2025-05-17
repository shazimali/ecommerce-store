<div class="px-8 py-10 text-black">
    @if(!$order_completed)
    <div class="grid grid-cols-2">
     <div class="pr-2 dark:text-white"> 
         <form wire:submit="completeOrder">
             <h3 class="text-2xl font-semibold py-2">Contact</h3>
             <div class="py-1">
                 <label class="block" for="email mb-2">Email</label>
                 <input type="text" id="email" wire:model="email" class="w-full border-secondary dark:bg-black dark:border-slate-800"  />
                 @error('email')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
             </div>
             <div class="py-1">
                 <input type="checkbox" class="border-secondary dark:bg-black dark:border-slate-800"/>
                 <span class="text-xs px-1">Email me with news and offers</span>
             </div>
             <div class="py-1">
 
             </div>
             <h3 class="text-2xl font-semibold py-2">Delivery</h3>
             <div class="flex flex-wrap -mx-3">
                 <div class="w-1/2 px-3 mb-6 md:mb-0">
                   <label class="block mb-2" for="first_name">
                     First Name
                   </label>
                   <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="first_name" id="first_name" type="text">
                   @error('first_name')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                 </div>
                 <div class="w-1/2 px-3 mb-6 md:mb-0">
                     <label class="block mb-2" for="last-name">
                       Last Name
                     </label>
                     <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="last_name" id="last-name" type="text">
                     @error('last_name')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                   </div>
             </div> 
             <div>
                 <label class="block mb-2" for="address">Address</label>
                 <input type="text" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="address" id="address">
                 @error('address')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
             </div>
             <div class="py-1">
                <input type="checkbox"  wire:model="same_for_billing_address" class="border-secondary dark:bg-black dark:border-slate-800"/>
                <span class="text-xs px-1">Same for billing address</span>
            </div>
            <div wire:show="!same_for_billing_address">
                <label class="block mb-2" for="billing_address">Billing Address</label>
                <input type="text" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="billing_address" id="billing_address">
                @error('billing_address')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
            </div>  
             <div class="flex flex-wrap -mx-3">
                 <div class="w-1/2 px-3 mb-6 md:mb-0">
                   <label class="block mb-2 dark:bg-black" for="city">
                     City
                   </label>
                   <select class="city block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="city_id" id="city_id">
                    <option value="">Select City</option>
                    @foreach ($cities as $get_city)
                        <option value="{{ $get_city->id }}">{{ $get_city->name }}</option>
                    @endforeach
                   </select>
                   @error('city_id')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                 </div>
                 <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 dark:bg-black" for="postal_code">
                    Postal Code
                    </label>
                    <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="postal_code" id="postal_code" type="text">  
                </div>
             </div>  
             <div class="flex flex-wrap -mx-3">
                 <div class="w-1/2 px-3 mb-6 md:mb-0">
                     <label class="block mb-2 dark:bg-black" for="last-name">
                       Country
                     </label>
                     <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="country" readonly id="country" type="text">
                     @error('country')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 dark:bg-black" for="last-name">
                      Phone
                    </label>
                    <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800"  wire:model="phone" id="phone" type="text">
                    @error('phone')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
               </div>
             </div>
             {{-- <div>
                 <input type="checkbox" class="border-secondary dark:bg-black dark:border-slate-800" id="name" name="name" placeholder="Name"/>
                 <span class="text-xs px-1">save this information for next time</span>
             </div>   --}}
             <h3 class="text-2xl font-semibold py-2">Shipping method</h3> 
              
             <div class="p-2 border-secondary border mb-2 dark:bg-black dark:border-slate-800">
                 <input type="radio" checked class="border-secondary dark:bg-black dark:border-slate-800" id="name" name="shipping_method">
                 <span class="px-1 font-semibold text-sm">Cash on Delivery (COD)</span>
             </div>
             {{-- <div class="p-2 border-secondary border mb-5 dark:bg-black dark:border-slate-800">
                 <input type="radio" class="border-secondary dark:bg-black dark:border-slate-800" id="name" name="shipping_method">
                 <span class="px-1 font-semibold text-sm ">
                     <span class="w-1/2">Debit - Credit Card</span>
                     <img class="inline-block w-1/5 ml-2" src="https://themewagon.github.io/eshopper/img/payments.png" alt="">
                 </span>
             </div> --}}
             <button type="submit" class="font-semibold bg-primary text-white mt-1 w-full py-3 text-center">
                 <svg wire:loading wire:target="completeOrder" aria-hidden="true" role="status" class="inline mr-1 w-6 h-6 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
                     <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
                 </svg>
                 <span class="pl-5">Complete Order</span>
             </button>
         </form>
     </div>
     <div class="bg-secondary p-5">
         @foreach ($cartItems as $crt)
         <div class="lg:block md:block sm:block xs:hidde">
            <div @class([
                    'grid grid-cols-[70%_30%] py-2' => true,
                    'border-b border-gray-300  dark:border-slate-800' => true
                    ])>
                    <div class="grid grid-cols-[20%_80%] gap-2 relative">
                            <img class="h-50 w-50 inline-block" src="{{ env('APP_URL').'/storage/'.$crt['image'] }}" alt="{{ $crt['title'] }}">
                            <div>
                                    <div class="text-xs"><b>{{ $crt['title'] }}</b></div> 
                                    <div class="text-xs">{{ getLocation()->currency }} {{ number_format($crt['unit_amount'],2)  }}</div> 
                                    
                                    <div class="flex text-xs">
                                            Color: {{ $crt['color'] ? $crt['color'] : 'N/A' }}
                                    </div>
                                    <div class="flex text-xs">
                                        Qty: {{ $crt['quantity'] }}
                                </div>
                            </div>
                    </div>
                    <div class="text-end text-xs mt-1 dark:text-black">
                            {{ getLocation()->currency }} {{ number_format($crt['total_amount'],2) }}
                    </div>    
            </div>      
        </div>
         @endforeach
         <form class="py-2 flex flex-wrap" wire:submit="applyCouponDiscount">
             <div class="w-[85%]">
                 <input class="block w-full mb-3 border-secondary" wire:model="coupon" placeholder="Discount code or git card" id="last-name" type="text">
                 @error('coupon')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                 @if (session()->has('error'))
                 <p class="text-red-500 text-xs">{{ session('error') }}</p>
                 @endif
                 @if (session()->has('success'))
                 <p class="text-green-500 text-xs">{{ session('success') }}</p>
                 @endif
             </div>
             <button type="submit" class="bg-primary text-white font-semibold w-[15%] h-10 cursor-pointer flex pt-2 px-2 text-end">
                 <svg wire:loading wire:target="applyCouponDiscount" aria-hidden="true" role="status" class="inline mr-1 w-6 h-6 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
                     <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
                 </svg>
                 <span class="pl-5">Apply</span>
             </button>
             {{-- <input type="submit" value="Apply" class="bg-primary text-white font-semibold w-[10%] h-10 cursor-pointer"/> --}}
         </form>
         @if (!$is_shipping_free)
         <div class="text-xs text-end font-semibold">Shipping is free if your order price more than {{ getLocation()->currency }} {{ number_format(getSettingVal('free_shipping'),2)   }}</div>     
         @endif
         <div class="flex justify-between">
             <span class="">SubTotal</span>
             <span class="">{{ getLocation()->currency }} {{ number_format($sub_total,2)  }}</span>
         </div>
         @if($coupon_discount > 0)
             <div class="flex justify-between">
                 <span class="">Coupon Discount</span>
                 <span class="">- {{ getLocation()->currency }} {{ number_format(round(($sub_total/100)*$coupon_discount,2))  }}</span>
             </div> 
         @endif
         <div class="flex justify-between">
             <span class="">Shipping</span>
             @if (!$is_shipping_free)
             <span class="">{{ getLocation()->currency }} {{ $shipping_charges }}</span>
             @endif
             @if ($is_shipping_free)
             <span class="">Free</span>
             @endif
         </div>
         <div class="flex justify-between">
             <span class="font-semibold">Total</span>
             <span class="font-semibold">{{ getLocation()->currency }} {{ number_format($total,2)}}</span>
         </div>
     </div>
    </div>
    @endif
    @if($order_completed)
    <div class="bg-white p-5 rounded-lg shadow-md">
        <div class="flex justify-between">
            <span class="text-lg font-bold text-green-700">Your order has been placed successfully and we will let you know once your package is on its way.</span>
        </div>
    </div>
    @endif
 </div>

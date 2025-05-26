@extends('layouts.app')
@section('title','Order Detail');
@section('content')
<div class="grid grid-cols-2 text-black px-8">
    <div class="pr-2 dark:text-white"> 
        <form wire:submit="completeOrder">
            <h3 class="text-2xl font-semibold py-2">Contact</h3>
            <div class="py-1">
                <label class="block" for="email mb-2">Email</label>
                <input type="text" id="email" value="{{ $order->user->email }}" readonly class="w-full border-secondary dark:bg-black dark:border-slate-800"  />
            </div>
            <h3 class="text-2xl font-semibold py-2">Delivery</h3>
            <div class="flex flex-wrap -mx-3">
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                  <label class="block mb-2" for="first_name">
                    First Name
                  </label>
                  <input readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" value="{{ $order->user->first_name }}" id="first_name" type="text">
                </div>
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2" for="last-name">
                      Last Name
                    </label>
                    <input readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" value="{{ $order->user->last_name }}" id="last-name" type="text">
                  </div>
            </div> 
            <div>
                <label class="block mb-2" for="address">Address</label>
                <input type="text" readonly value="{{ $order->address }}" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="address" id="address">
            </div>
           <div>
               <label class="block mb-2" for="billing_address">Billing Address</label>
               <input type="text" readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" value="{{ $order->billing_address }}" id="billing_address">
           </div>  
           <div>
            <label class="block mb-2" for="billing_address">City</label>
            <input type="text" readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" value="{{ $order->city->name }}" id="billing_address">
        </div> 
            <div class="flex flex-wrap -mx-3">
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block mb-2 dark:bg-black" for="last-name">
                      Country
                    </label>
                    <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" value="{{ $order->country->name }}" readonly id="country" type="text">
               </div>
               <div class="w-1/2 px-3 mb-6 md:mb-0">
                   <label class="block mb-2 dark:bg-black" for="last-name">
                     Phone
                   </label>
                   <input readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800"  value="{{ $order->phone }}" id="phone" type="text">
              </div>
            </div>
            <h3 class="text-2xl font-semibold py-2">Shipping method</h3> 
             
            <div class="p-2 border-secondary border mb-2 dark:bg-black dark:border-slate-800">
                <input type="radio" checked class="border-secondary dark:bg-black dark:border-slate-800" id="name" name="shipping_method">
                <span class="px-1 font-semibold text-sm">Cash on Delivery (COD)</span>
            </div>
        </form>
    </div>
    <div class="bg-secondary p-5">
        @foreach ($order->detail as $order_detail)
        <div class="lg:block md:block sm:block xs:hidde">
           <div @class([
                   'grid grid-cols-[70%_30%] py-2' => true,
                   'border-b border-gray-300  dark:border-slate-800' => true
                   ])>
                   <div class="grid grid-cols-[20%_80%] gap-2 relative">
                           <img class="h-50 w-50 inline-block" src="{{ env('APP_URL').'/storage/'.$order_detail->product->image }}" alt="{{ $order_detail->product->title }}">
                           <div>
                                   <div class="text-xs"><b>{{ $order_detail->product->title }}</b></div> 
                                   <div class="text-xs">{{ $order_detail->currency }} {{ number_format($order_detail->unit_amount,2)  }}</div> 
                                   
                                   <div class="flex text-xs">
                                           Color: {{ $order_detail->color ? $order_detail->color->color_name : 'N/A' }}
                                   </div>
                                   <div class="flex text-xs">
                                       Qty: {{ $order_detail->quantity }}
                               </div>
                           </div>
                   </div>
                   <div class="text-end text-xs mt-1 dark:text-black">
                           {{ $order_detail->currency }} {{ number_format($order_detail->total_amount,2) }}
                   </div>    
           </div>      
       </div>
        @endforeach
        <div class="flex justify-between">
            <span class="">SubTotal</span>
            <span class="">{{ $order_detail->currency }} {{ number_format($order->sub_total,2)  }}</span>
        </div>
        @if($order->coupon)
            <div class="flex justify-between">
                <span class="">Coupon Discount</span>
                <span class="">- {{ $order_detail->currency }} {{ number_format(round(($order->sub_total/100)*$order->coupon->discount,2))  }}</span>
            </div> 
        @endif
        <div class="flex justify-between">
            <span class="">Shipping</span>
            @if ($order->free_shipping  == 0)
            <span class="">{{ $order_detail->currency }} {{ $order->shipping_charges }}</span>
            @endif
            @if ($order->free_shipping  == 1)
            <span class="">Free</span>
            @endif
        </div>
        <div class="flex justify-between">
            <span class="font-semibold">Total</span>
            <span class="font-semibold">{{ $order_detail->currency }} {{ number_format($order->total,2)}}</span>
        </div>
    </div>
   </div>
@endsection
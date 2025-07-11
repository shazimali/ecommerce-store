@extends('layouts.app')
@section('title','Orders')
@section('content')
<div class="px-8 py-10 text-black dark:text-white">
    <div class="flex justify-center">
        <h3 class="text-2xl font-semibold py-2">My Orders</h3>
    </div>
    @if(count($orders))
    @foreach ($orders as $order)
        <div class="card w-full card-xs shadow-sm my-2 bg-secondary text-black">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="card-title">ED#{{ $order->id }}</h2>
                    @if($order->status == 'PLACED')
                    <div class="badge badge-warning">{{ $order->status }}</div>
                    @elseif($order->status == 'IN_TRANSIT')
                    <div class="badge badge-info">{{ $order->status }}</div>
                    @elseif($order->status == 'DELIVERED')
                    <div class="badge badge-success">{{ $order->status }}</div>
                    @endif
                </div>
                @foreach ($order->detail as $item)
                    <div class="item-center">
                        <a href="">
                            <img class="h-30 w-30 inline-block" src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->title }}">
                        </a>
                        <div>
                                <div class="py-1 text-xs max-w-60"><b>{{ $item->product->title }}</b></div> 
                                <div class="py-1 text-xs"> {{ $item->currency }} {{ number_format($item->unit_amount,2)  }}</div> 
                                <div class="py-1 flex text-xs">
                                        Color: {{ $item->color_id != 0 && $item->color_id != null ?  $item->color->color_name : 'N/A'}}
                                </div>
                                <div class="py-1 flex text-xs">
                                        Qty: {{ $item->quantity }}
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    @endif
</div>
@endsection
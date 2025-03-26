<div>
    <div class="lg:block md:block sm:block xs:hidden">
            <div @class([
                    'grid grid-cols-[70%_30%] py-2' => true,
                    'border-b border-secondary dark:text-white dark:border-slate-800' => true
                    ])>
                    <div class="grid grid-cols-[20%_80%] gap-2">
                            <img class="h-50 w-50 inline-block" src="{{ env('APP_URL').'/storage/'.$crt['image'] }}" alt="{{ $crt['title'] }}">
                            <div>
                                    <div class="py-1 text-sm"><b>{{ $crt['title'] }}</b></div> 
                                    <div class="py-1 text-sm"> {{ number_format($crt['unit_amount'],2)  }}</div> 
                                    <div class="py-1 flex text-sm">
                                            Color: {{ $color_title }}
                                    </div>
                                    <div class="py-1 flex">
                                            <button wire:click="decreaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs px-3">-</button>
                                            <input type="text" value="{{ $crt['quantity'] }}" class="bg-secondary text-black text-xs border-none text-center w-10" readonly>
                                            <button wire:click="increaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs px-3">+</button>
                    
                                            <span wire:click="removeItem('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="text-primary cursor-pointer px-2 py-1">
                                                    <i class="fa-solid fa-trash"></i>
                                            </span>
                            
                                    </div>
                            </div>
                    </div>
                    <div class="text-end text-sm mt-1">
                             {{ number_format($crt['total_amount'],2) }}
                    </div>    
            </div>      
    </div>
    <div class="lg:hidden md:hidden sm:hidden xs:block">
            <div class="py-2 border-b border-secondary dark:border-slate-800 dark:text-white mx-2 grid grid-cols-[20%_65%_10%] gap-2">
                    <div>
                            <img class="" src="{{ env('APP_URL').'/storage/'.$crt['image'] }}" alt="{{ $crt['title'] }}"> 
                    </div>
                    <div>
                            <div class="py-1 text-xs"><b>{{ $crt['title'] }}</b></div> 
                            <div class="py-1 text-xs"> {{ number_format($crt['unit_amount'],2)  }}</div> 
                            <div class="flex text-xs">
                                    Color: {{ $color_title }}
                            </div>
                            <div class="flex text-xs">
                                    <b>Total:  {{ number_format($crt['total_amount'],2) }}</b>
                            </div>
                            <div>
                                   <span wire:click="removeItem('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="text-primary cursor-pointer px-2 py-1">
                                            <i class="fa-solid fa-trash"></i>
                                    </span> 
                            </div>
                    </div>
                    <div>
                            <div class="flex flex-col">
                                    <button wire:click="decreaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs px-2 py-2">-</button>
                                    <input type="text" value="{{ $crt['quantity'] }}" class="bg-secondary text-black text-xs border-none text-center w-10" readonly>
                                    <button wire:click="increaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs px-2 py-2">+</button>
                    
                            </div>
                    </div>
            </div>
    </div>
    
</div>



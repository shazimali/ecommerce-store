<div class="border-b py-2 border-secondary dark:text-white dark:border-slate-800">
    <span  wire:click="removeItem('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="text-primary cursor-pointer absolute right-4">
            <i class="fa-solid fa-trash"></i>
    </span>
    <div class="grid grid-cols-[20%_80%] gap-5">
        <img class="h-30 w-30 inline-block" src="{{ env('APP_URL').'/storage/'.$crt['image'] }}" alt="{{ $crt['title'] }}">
        <div>
                <div class="py-1 text-xs max-w-60"><b>{{ $crt['title'] }}</b></div> 
                <div class="py-1 text-xs"> {{ $crt['currency'] }} {{ number_format($crt['unit_amount'],2)  }}</div> 
                @if ($color_title)
                <div class="py-1 flex text-xs">
                        Color: {{ $color_title }}
                </div>
                @endif
                <div class="grid grid-cols-2 pr-6">
                    <div class="flex py-1">
                            <button wire:click="decreaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs lg:px-3 md:px-3 sm:px-3 xs:px-2">-</button>
                            <input type="text" value="{{ $crt['quantity'] }}" class="bg-secondary text-black text-xs border-none text-center w-10" readonly>
                            <button wire:click="increaseQty('{{ $crt['slug'] }}','{{ $crt['color'] }}')" wire:loading:attr="disabled" class="bg-primary text-white text-xs lg:px-3 md:px-3 sm:px-3 xs:px-2">+</button>
                    </div>
                    <span class="lg:text-sm md:text-sm sm:text-sm xs:text-xs text-end lg:py-3 md:py-3 sm:py-3 xs:py-2">{{ $crt['currency'] }} {{ number_format($crt['total_amount'],2) }}</span>
                </div>
                
                    
        </div>
    </div>
</div>


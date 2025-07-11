<div class="px-8 py-10 text-black dark:text-white">
        <div class="flex justify-center">
            <h3 class="text-2xl font-semibold py-2">Account Details</h3>
        </div>
        <form wire:submit="updateAccount" class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 xs:grid-cols-1 gap-5">
            <div>
                <div>
                 <label class="block mb-2" for="email">Email</label>
                 <input type="text" value="{{ auth()->user()->email }}" readonly class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800"  />
                   @error('email')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                <div>
                    <label class="block mb-2" for="first_name">
                     First Name
                   </label>
                   <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="first_name" id="first_name" type="text">
                   @error('first_name')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                <div>
                    <label class="block mb-2" for="last_name">
                     Last Name
                   </label>
                   <input value="{{ auth()->user()->last_name }}" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="last_name" id="last_name" type="text">
                   @error('last_name')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                 <div>
                   <label class="block mb-2 dark:bg-black" for="city">
                     City
                   </label>
                   <select class="city block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="city" id="city">
                    <option value="">Select City</option>
                    @foreach ($cities as $get_city)
                        <option>{{ $get_city->name }}</option>
                    @endforeach
                   </select>
                   @error('city')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div> 
                <div>
                     <label class="block mb-2 dark:bg-black" for="last-name">
                       Country
                     </label>
                     <input  class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="country" readonly id="country" type="text">
                     @error('country')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-2 dark:bg-black" for="last-name">
                      Phone
                    </label>
                    <input class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800"  wire:model="phone" id="phone" type="text">
                    @error('phone')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
               </div>
            </div>
            <div>
                {{-- <div>
                 <label class="block mb-2" for="password">Profile Image</label>
                @if ($profile_image)
                    <img width="100" height="100" src="{{ $profile_image->temporaryUrl() }}">
                @endif
                 <input type="file" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="profile_image" id="profile_image">
                 @error('profile_image')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div> --}}
                <div>
                 <label class="block mb-2" for="password">Password</label>
                 <input type="password" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="password" id="password">
                 @error('password')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                <div>
                 <label class="block mb-2" for="password">Confirm Password</label>
                 <input type="password" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="password_confirmation" id="password_confirmation">
                 @error('password_confirmation')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                <div>
                 <label class="block mb-2" for="address">Address</label>
                 <input type="text" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="address" id="address">
                 @error('address')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div>
                <div>
                    <label class="block mb-2" for="billing_address">Billing Address</label>
                    <input type="text" class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800" wire:model="billing_address" id="billing_address">
                    @error('billing_address')  <p class="text-red-500 text-xs">{{ $message }}</p> @enderror 
                </div> 
              <button type="submit" class="font-semibold bg-primary text-white mt-1 w-full py-3 text-center">
                 <svg wire:loading wire:target="completeOrder" aria-hidden="true" role="status" class="inline mr-1 w-6 h-6 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
                     <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
                 </svg>
                 <span class="pl-5">Update</span>
             </button>
            </div>
        </form>
        <div class="w-[85%]">
            @if (session()->has('error'))
            <p class="text-red-500 text-xs">{{ session('error') }}</p>
            @endif
            @if (session()->has('success'))
            <p class="text-green-500 text-xs">{{ session('success') }}</p>
            @endif
        </div>
</div>

<div class="flex justify-center text-black dark:text-white dark:bg-black">
    <div class="w-full max-w-xs">
         <h3 class="text-4xl font-semibold py-2 text-center">Login</h3>
        @if (session()->has('error'))
            <p class="text-red-500 text-sm">{{ session('error') }}</p>
            @endif
            @if (session()->has('success'))
            <p class="text-green-500 text-sm">{{ session('success') }}</p>
        @endif
      <form wire:submit="doLogin">
        <div class="mb-4">
          <label class="block text-sm  mb-2" for="email">
            Email
          </label>
          <input @class([
            "border border-secondary w-full py-2 px-3 dark:bg-black dark:border-slate-800" => true,
            "border-red-500" => $errors->has('email')
          ]) id="email" type="text" wire:model="email" placeholder="email">
          @error('email')  <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        </div>
        <div class="mb-6">
         <label class="block text-sm  mb-2" for="password">
            Password
          </label>
          <input @class([
            "border border-secondary w-full py-2 px-3  dark:bg-black dark:border-slate-800" => true,
            "border-red-500" => $errors->has('email')
          ]) id="password" type="password" wire:model="password" placeholder="password">
          @error('password')  <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-between py-1">
            <div class="flex items-start">
                <input type="checkbox" class="border border-secondary dark:bg-black dark:border-slate-800 dark:border-slate-800" wire:model="remember" id="name" name="shipping_method">
                <span class="px-1 text-sm ">Remember me</span>
            </div>
            <a class="text-sm" href="">Forgot password?</a>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="font-semibold bg-primary text-white mt-1 w-full py-3 text-center">
            <svg wire:loading wire:target="doLogin" aria-hidden="true" role="status" class="inline mr-1 w-6 h-6 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"></path>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
            </svg>
            <span class="pl-5">Login</span>
            </button>
        </div>
      </form>
        <div class="text-center py-2">
            <span class="text-sm">Don't have an account?</span>
            <a class="text-sm text-primary font-semibold" href="{{ route('register') }}">Sign up</a>
        </div>
        <div class="text-center py-2">
            <span class="text-sm">Or, login with</span>
        </div>
        <div class="flex justify-around py-2">
            <a href="{{ route('socialite.auth', 'google') }}">
                <img src="{{ asset('images/google.svg') }}" alt="google">
                <span class="text-sm">Google</span>
            </a>
            <a href="{{ route('socialite.auth', 'facebook') }}">
            <img height="50" width="50" src="{{ asset('images/facebook.svg') }}" alt="facebook">
            <span class="text-sm">Facebook</span>
            </a>
        </div>
    </div>
</div>

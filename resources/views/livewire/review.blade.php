<div class="px-8 py-10 text-black dark:text-white">
    <div class="flex justify-center">
        <h3 class="text-2xl font-semibold py-2">Review</h3>
    </div>
    <form wire:submit.prevent="saveReview">
        <div>
            <div>
                <label class="block mb-1" for="review">
                    Review:
                </label>
                <textarea wire:model="review" rows="4" cols="4" name="review"
                    class="w-full border p-2 rounded mb-3 border-secondary dark:bg-black dark:border-slate-800"
                    placeholder="Write your review..."></textarea>
                @error('review')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror

            </div>

            <div>
                <label class="block mb-2" for="images">
                    Images:
                </label>

                <input type="file" id="images" multiple wire:model="images"
                    class="block w-full mb-3 border-secondary dark:bg-black dark:border-slate-800">
            </div>
            @error('images.*')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            @if ($previewImages)
                <div class="flex gap-2 flex-wrap mb-3">
                    @foreach ($previewImages as $value)
                        <img src="{{ $value }}" class="w-20 h-20 object-cover rounded border">
                    @endforeach
                </div>
            @endif





            <label class="my-9" for="rating">
                Rating:
            </label>
            <div class="flex items-center mt-2">
                @for ($i = 1; $i <= 5; $i++)
                    <svg wire:click="setRating({{ $i }})"
                        class="w-8 h-8 cursor-pointer  {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.197 3.67a1
                         1 0 00.95.69h3.862c.969 0 1.371
                         1.24.588 1.81l-3.124 2.27a1 1 0
                         00-.364 1.118l1.197 3.67c.3.921-.755
                         1.688-1.54 1.118l-3.124-2.27a1 1 0
                         00-1.176 0l-3.124 2.27c-.784.57-1.838-.197-1.539-1.118l1.197-3.67a1
                         1 0 00-.364-1.118L2.454 9.097c-.783-.57-.38-1.81.588-1.81h3.862a1
                         1 0 00.95-.69l1.197-3.67z" />
                    </svg>
                @endfor
            </div>
            @error('rating')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            <div>
                <button type="submit" class="font-semibold bg-primary text-white mt-1 w-full py-3 text-center mt-4">
                    <svg wire:loading wire:target="completeOrder" aria-hidden="true" role="status"
                        class="inline mr-1 w-6 h-6 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="#E5E7EB"></path>
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor"></path>
                    </svg>
                    <span class="pl-5">Submit</span>
                </button>
            </div>


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

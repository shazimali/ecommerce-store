<?php

namespace App\Livewire;

use App\Models\ProductReview;
use App\services\ReviewService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Review extends Component
{
    use WithFileUploads;



    public $review = '';
    public $tab = 'toBeReviewed';
    public $forms = [];
    public $history = [];
    public $rating = 0;
    public $images = [];
    public $previewImages = [];


    #[On('update-reviews')]
    public function mount()
    {
        foreach (ReviewService::getToBeReviews() as $key => $form) {
            $this->forms[$key]['title'] = $form->title;
            $this->forms[$key]['review'] = '';
            $this->forms[$key]['image'] = $form->image;
            $this->forms[$key]['rating'] = 0;
            $this->forms[$key]['user_id'] =  Auth::id();
            // $this->forms[$key]['product_id'] =  Auth::id();
            $this->forms[$key]['product_id'] = $form->id;
            $this->forms[$key]['status'] =  'INACTIVE';
        }
        $this->history = ReviewService::getReviewsHistory();
    }

    public function setRating($value, $index)
    {
        $this->forms[$index]['rating'] = $value;
    }

    public function updatedImage()
    {
        $this->previewImages = [];
        foreach ($this->images as $image) {
            $this->previewImages[] = $image->temporaryUrl();
        }
    }


    public function saveReview($index)
    {
        $this->validate([
            "forms.$index.review" => 'required|string|max:1000',
            "forms.$index.rating" => 'required|integer|min:1|max:5',
        ], [
            "forms.$index.review.required" => 'The review field is required.',
            "forms.$index.rating.required" => 'The rating field is required.',
            "forms.$index.rating.min"      => 'The rating must be at least 1.',
            "forms.$index.rating.max"      => 'The rating may not be greater than 5.',


        ]);

        // Store images
        $storedImages = [];
        foreach ($this->images as  $image) {
            $storedImages[] = $image->store('reviews', 'public');
        }

        ProductReview::create([
            'product_id' =>  $this->forms[$index]['product_id'],
            'user_id' => Auth::id(),
            'rating' => $this->forms[$index]['rating'],
            'review' =>  $this->forms[$index]['review'],
            'image1' => $storedImages[0] ?? null,
            'image2' => $storedImages[1] ?? null,
            'image3' => $storedImages[2] ?? null,
            'status' => 'active',
        ]);
        // Reset this specific form
        $this->forms[$index]['review'] = '';
        // $this->forms[$index]['rating'] = null;
        // $this->images[$index] = [];




        $data = ['type' => 'success', 'message' => 'Review Submitted Successfully!'];
        $this->dispatch(
            'alert',
            type: $data['type'],
            title: $data['message'],
        );
        $this->dispatch('update-reviews');
    }
    public function render()
    {
        return view('livewire.review');
    }
}

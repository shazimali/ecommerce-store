<?php

namespace App\Livewire;

use App\Models\ProductReview;
use App\services\ReviewService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Review extends Component
{
    use WithFileUploads;


    public $review = '';
    public $forms = [];
    public $history = [];
    public $rating = 1;
    public $images = [];
    public $previewImages = [];
    #[Validate('required')]

    protected $formRules = [
        'forms.*.review'          => 'required|string|max:1000',
        'forms.*.rating'           => 'required|integer|min:1|max:5',
    ];

    public function mount()
    {
        foreach (ReviewService::getToBeReviews() as $key => $form) {
            $this->forms[$key]['title'] = $form->title;
            $this->forms[$key]['review'] = '';
            $this->forms[$key]['image'] = $form->image;
            $this->forms[$key]['rating'] = 1;
            $this->forms[$key]['user_id'] =  Auth::id();
            $this->forms[$key]['product_id'] =  Auth::id();
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

    public function saveReview()
    {
        $this->validate($this->formRules);
        // Store images
        $storedImages = [];
        foreach ($this->images as  $image) {
            $storedImages[] = $image->store('reviews', 'public');
        }

        ProductReview::create([
            'product_id' => 3, // replace with dynamic product ID
            'user_id' => 0,
            'rating' => $this->rating,
            'review' => $this->review,
            'image1' => $storedImages[0] ?? null,
            'image2' => $storedImages[1] ?? null,
            'image3' => $storedImages[2] ?? null,
            'status' => 'active',
        ]);
        // Reset form
        $this->reset(['review', 'rating', 'images']);

        return back()->with('success', 'Review submitted successfully!.');
    }


    public function render()
    {
        return view('livewire.review');
    }
}

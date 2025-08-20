<?php

namespace App\Livewire;

use App\Models\ProductReview;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Review extends Component
{
    use WithFileUploads;


    public $review = '';
    public $rating = 0;
    public $images = [];
    public $previewImages = [];
    #[Validate('required')]

    protected $formRules = [
        'review'          => 'required|string|max:1000',
        'rating'           => 'required|integer|min:1|max:5',
        'images.*' =>     'image|max:100',

    ];

    public function setRating($value)
    {
        $this->rating = $value;
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

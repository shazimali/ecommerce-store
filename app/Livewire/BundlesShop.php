<?php

namespace App\Livewire;

use App\Models\Bundle;
use App\Models\BundleColor;
use App\Services\CartManagementService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BundlesShop extends Component
{
    use WithPagination;

    public $sort_by;
    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
        'sort_by' => ['except' => ''],
    ];

    public function mount()
    {
        // No filters to initialize
    }

    public function addToCart($slug)
    {
        CartManagementService::addCartItems($slug, '', true);
        
        $this->dispatch('update-cart', data: [
            'type' => 'success', 
            'message' => 'Item added successfully.'
        ]);
        $this->dispatch('cart-refresh');
    }

    public function updateSortBy($val)
    {
        $this->sort_by = $val;
        $this->resetPage();
    }

    public function render()
    {
        $query = Bundle::query()->active();

        // Search Filter
        if (!empty($this->search)) {
            $searchTerm = $this->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_desc', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        if (!empty($this->sort_by)) {
            switch ($this->sort_by) {
                case 'sale':
                    $query->whereHas('price_detail', function ($q) {
                        $today = Carbon::today();
                        $q->whereDate('discount_from', '<=', $today)
                          ->whereDate('discount_to', '>=', $today);
                    });
                    break;
            }
        }

        $bundles = $query->orderBy('order', 'ASC')->paginate(8);

        return view('livewire.bundles-shop', [
            'bundles' => $bundles
        ]);
    }
}

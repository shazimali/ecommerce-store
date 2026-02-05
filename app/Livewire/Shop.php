<?php

namespace App\Livewire;

use App\Services\CartManagementService;
use App\Services\ShopService;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    public $categories;
    public $colors;
    public $category;
    public $sub_category;
    public $color;
    public $sort_by;
    public $price_from;
    public $price_to;
    public $rating;
    public $search;

    protected $queryString = [
        'category' => ['except' => ''],
        'sub_category' => ['except' => ''],
        'color' => ['except' => ''],
        'search' => ['except' => ''],
        'rating' => ['except' => ''],
        'sort_by' => ['except' => ''],
        'price_from' => ['except' => ''],
        'price_to' => ['except' => ''],
    ];

    /**
     * Initialize component and load initial filter data.
     */
    public function mount(ShopService $shopService)
    {
        $filterData = $shopService->getFilterData();
        $this->categories = $filterData['categories'];
        $this->colors = $filterData['colors'];
        
        $this->price_from = $this->price_from ?: getSettingVal('shop_filter_price_from');
        $this->price_to = $this->price_to ?: getSettingVal('shop_filter_price_to');
    }

    /**
     * Add product to cart.
     */
    public function addToCart($slug)
    {
        CartManagementService::addCartItems($slug, '');
        
        $this->dispatch('update-cart', data: [
            'type' => 'success', 
            'message' => 'Item added successfully.'
        ]);
    }

    /**
     * Update filter values and reset pagination.
     */
    public function updateFilter($type, $val)
    {
        switch ($type) {
            case 'category_type':
                $this->category = $val;
                $this->sub_category = '';
                break;
            case 'sub_category_type':
                $this->sub_category = $val;
                break;
            case 'color':
                $this->color = $val;
                break;
            case 'rating':
                $this->rating = $val;
                break;
            case 'price_from':
                $this->price_from = $val;
                break;
            case 'price_to':
                $this->price_to = $val;
                break;
        }

        $this->resetPage();
    }

    /**
     * Update sorting value and reset pagination.
     */
    public function updateSortBy($val)
    {
        $this->sort_by = $val;
        $this->resetPage();
    }

    /**
     * Render the component with filtered products.
     */
    public function render(ShopService $shopService)
    {
        $filters = [
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'color' => $this->color,
            'rating' => $this->rating,
            'sort_by' => $this->sort_by,
            'price_from' => $this->price_from,
            'price_to' => $this->price_to,
            'search' => $this->search,
        ];

        return view('livewire.shop', [
            'products' => $shopService->getProducts($filters)
        ]);
    }
}

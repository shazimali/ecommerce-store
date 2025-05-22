<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\SubCategory;
use App\Services\CartManagementService;
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
    public $price;
    public $sort_by;
    public $price_from;
    public $price_to;
    public $rating;
    protected $queryString = ['category', 'sub_category', 'color', 'price', 'search', 'rating', 'sort_by', 'price_from'];

    public function mount()
    {
        $this->categories = Category::get();
        $this->colors = ProductColor::distinct()->select('color_name')->get();
        $this->price_from = getSettingVal('shop_filter_price_from');
        $this->price_to = getSettingVal('shop_filter_price_to');
    }


    public function addToCart($slug)
    {
        CartManagementService::addCartItems($slug, '');
        $data = ['type' => 'success', 'message' => 'Item added successfully.'];
        $this->dispatch('update-cart', data: $data);
    }


    public function updateFilter($type, $val)
    {
        if ($type == 'category_type') {
            $this->category = $val;
            $this->sub_category = '';
        }
        if ($type == 'sub_category_type') {
            $this->sub_category = $val;
        }
        if ($type == 'color') {
            $this->color = $val;
        }
        if ($type == 'rating') {
            $this->rating = $val;
        }
        if ($type == 'price') {
            $this->price_from = $val;
        }
    }

    public function updateSortBy($val)
    {
        $this->sort_by = $val;
    }

    public function render()
    {

        $this->colors = ProductColor::distinct()->select('color_name')->get();

        $query = ProductHead::query();

        $query->active()->orderBy('order', 'ASC');

        if (!empty($this->category) && $this->category != 'all') {

            $sub_cat_ids = Category::where('slug', $this->category)->with('sub_categories')->first()->sub_categories->pluck('id');
            $query->whereHas('sub_categories', function ($q) use ($sub_cat_ids) {
                $q->whereIn('sub_category_id', $sub_cat_ids);
            });
        }
        if ($this->sub_category) {

            $sub_cat_id = SubCategory::where('slug', $this->sub_category)->first();
            $query->whereHas('sub_categories', function ($q) use ($sub_cat_id) {
                $q->where('sub_category_id', $sub_cat_id->id);
            });
        }
        if ($this->color) {
            $current_color = $this->color;
            return $query->whereHas('colors', function ($q) use ($current_color) {
                $q->where('color_name', $current_color);
            });
        }
        if ($this->rating) {
            // $review_ids = Review::where('rating',$this->rating)->get()->pluck('id');
            // $query->whereIn('id',$review_ids);
        }

        // if($this->price_from){

        //     $query->whereHas('countries',function($q){
        //         $q->where('price',$this->price_from);
        //     });
        // }

        if ($this->sort_by) {
            if ($this->sort_by == 'featured') {
                $query->featured();
            }
            if ($this->sort_by == 'new') {
                $query->new();
            }
        }


        return view('livewire.shop', [
            'products' => $query->paginate(6)
        ]);
    }
}

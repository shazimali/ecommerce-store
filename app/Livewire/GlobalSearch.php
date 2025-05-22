<?php

namespace App\Livewire;

use App\Models\ProductHead;
use Livewire\Component;

class GlobalSearch extends Component
{

    public $search = '';
    private $products = [];

    public function render()
    {
        if (!empty($this->search)) {
            $this->products = ProductHead::active()->where('title', 'LIKE', '%' . $this->search . '%')->get();
        }
        return view('livewire.global-search', [
            'products' => $this->products
        ]);
    }
}

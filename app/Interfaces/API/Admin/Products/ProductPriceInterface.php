<?php

namespace App\Interfaces\API\Admin\Products;

use Illuminate\Http\Request;

interface ProductPriceInterface
{
    public function getPricesByProductID(int $id);
    public function storePrice(array $data);
    public function editPrice(int $id);
    public function updatePrice(int $id, array $data);
    public function deletePrice(int $id);
}

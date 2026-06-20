<?php

namespace App\Interfaces\API\Admin\Bundles;

interface BundlePriceInterface
{
    public function getPricesByBundleID(int $id);
    public function storePrice(array $data);
    public function editPrice(int $id);
    public function updatePrice(int $id, array $data);
    public function deletePrice(int $id);
}

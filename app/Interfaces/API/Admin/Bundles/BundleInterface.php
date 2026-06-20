<?php

namespace App\Interfaces\API\Admin\Bundles;

interface BundleInterface
{
    public function getAll(array $filters, int $perPage);
    public function store(array $data);
    public function edit(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
}

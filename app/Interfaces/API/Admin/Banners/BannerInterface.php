<?php

namespace App\Interfaces\API\Admin\Banners;

use App\Http\Requests\API\Admin\Banners\StoreBannerRequest;
use App\Http\Requests\API\Admin\Banners\UpdateBannerRequest;
use Illuminate\Http\Request;

interface BannerInterface
{
    public function getAll(Request $request);
    public function getAllWebsites();
    public function store(StoreBannerRequest $request);
    public function edit(int $id);
    public function update(UpdateBannerRequest $request, int $id);
    public function destroy(int $id);
}

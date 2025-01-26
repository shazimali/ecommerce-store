<?php

use App\Http\Requests\API\Admin\Websites\StoreWebsiteRequest;
use App\Http\Requests\API\Admin\Websites\UpdateWebsiteRequest;
use Illuminate\Http\Client\Request;

class WebsitesService implements WebsitesInterface
{

    public function getAll(Request $request) {}
    public function store(StoreWebsiteRequest $request) {}
    public function edit(int $id) {}
    public function update(UpdateWebsiteRequest $request, int $id) {}
    public function destroy(int $id) {}
}

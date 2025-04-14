<?php

namespace App\Interfaces\API\Admin\Pages;

use App\Http\Requests\API\Admin\Pages\StorePagesRequest;
use App\Http\Requests\API\Admin\Pages\UpdatePagesRequest;
use Illuminate\Http\Request;

interface PagesInterface
{
    public function getAll(Request $request);
    public function getAllCountries();
    public function store(StorePagesRequest $request);
    public function edit(int $id);
    public function update(UpdatePagesRequest $request, int $id);
    public function destroy(int $id);
}

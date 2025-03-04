<?php

namespace App\Interfaces\API\Admin\SocialMedias;

use App\Http\Requests\API\Admin\SocialMedias\StoreSocialMediasRequest;
use App\Http\Requests\API\Admin\SocialMedias\UpdateSocialMediasRequest;
use Illuminate\Http\Request;

interface SocialMediasInterface
{
    public function getAll(Request $request);
    public function store(StoreSocialMediasRequest $request);
    public function edit(int $id);
    public function update(UpdateSocialMediasRequest $request, int $id);
    public function destroy(int $id);
}

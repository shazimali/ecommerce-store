<?php

namespace App\Interfaces\API\Admin\Blogs;

use App\Http\Requests\API\Admin\Blogs\StoreBlogRequest;
use App\Http\Requests\API\Admin\Blogs\UpdateBlogRequest;
use Illuminate\Http\Request;

interface BlogsInterface
{
    public function getAll(Request $request);
    public function store(StoreBlogRequest $request);
    public function edit(int $id);
    public function update(UpdateBlogRequest $request, int $id);
    public function destroy(int $id);
}

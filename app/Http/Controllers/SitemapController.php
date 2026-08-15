<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Page;
use App\Models\ProductHead;
use App\Models\SubCategory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate a fully dynamic XML sitemap from the live database.
     * Cached for 6 hours — clears automatically on cache flush.
     */
    public function __invoke(): Response
    {
        $xml = Cache::remember('sitemap_xml', 21_600, function () {
            $products    = ProductHead::active()->select('slug', 'updated_at')->get();
            $blogs       = Blog::active()->select('slug', 'updated_at')->get();
            $categories  = Category::select('slug', 'updated_at')->get();
            $subCats     = SubCategory::select('slug', 'updated_at')->get();
            $collections = Collection::active()->select('slug', 'updated_at')->get();
            $pages       = Page::active()->select('slug', 'updated_at')->get();

            return view('sitemap', compact(
                'products',
                'blogs',
                'categories',
                'subCats',
                'collections',
                'pages'
            ))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}

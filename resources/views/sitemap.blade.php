<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- ── Homepage ── --}}
    <url>
        <loc>https://everydayplastic.co/</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
    </url>

    {{-- ── Shop / Bundles ── --}}
    <url>
        <loc>https://everydayplastic.co/shop</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>https://everydayplastic.co/bundles</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>https://everydayplastic.co/blogs</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>https://everydayplastic.co/contact-us</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    {{-- ── Products (with image sitemap extension) ── --}}
    @foreach ($products as $product)
    <url>
        <loc>https://everydayplastic.co/products/{{ $product->slug }}</loc>
        <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        @if ($product->image)
        <image:image>
            <image:loc>https://everydayplastic.co/storage/{{ $product->image }}</image:loc>
            <image:title>{{ $product->title ?? $product->slug }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach

    {{-- ── Categories ── --}}
    @foreach ($categories as $category)
    <url>
        <loc>https://everydayplastic.co/categories/{{ $category->slug }}</loc>
        <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- ── Sub-Categories ── --}}
    @foreach ($subCats as $sub)
    <url>
        <loc>https://everydayplastic.co/sub-categories/{{ $sub->slug }}</loc>
        <lastmod>{{ $sub->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.75</priority>
    </url>
    @endforeach

    {{-- ── Collections ── --}}
    @foreach ($collections as $collection)
    <url>
        <loc>https://everydayplastic.co/collections/{{ $collection->slug }}</loc>
        <lastmod>{{ $collection->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.75</priority>
    </url>
    @endforeach

    {{-- ── Blogs ── --}}
    @foreach ($blogs as $blog)
    <url>
        <loc>https://everydayplastic.co/blogs/{{ $blog->slug }}</loc>
        <lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- ── Pages (Policy, Terms, etc.) ── --}}
    @foreach ($pages as $page)
    <url>
        <loc>https://everydayplastic.co/pages/{{ $page->slug }}</loc>
        <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach

</urlset>

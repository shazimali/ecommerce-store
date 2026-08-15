@extends('layouts.app')

{{-- ── Per-page SEO Meta ──────────────────────────────────────────────────── --}}
@section('seo_title',       ($blog->seo_title ?: $blog->title . ' | Everyday Plastic Blog'))
@section('seo_description', ($blog->seo_desc  ?: Str::limit(strip_tags((string) $blog->description), 155)))
@section('canonical',       route('blogs.detail', $blog->slug))
@section('og_title',        $blog->title)
@section('og_description',  $blog->seo_desc ?: Str::limit(strip_tags((string) $blog->description), 155))
@section('og_image',        asset('storage/' . $blog->image))
@section('og_url',          route('blogs.detail', $blog->slug))

{{-- ── BlogPosting + BreadcrumbList Structured Data ──────────────────────── --}}
@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ addslashes($blog->title) }}",
  "description": "{{ addslashes(Str::limit(strip_tags((string) $blog->description), 200)) }}",
  "image": "{{ asset('storage/' . $blog->image) }}",
  "url": "{{ route('blogs.detail', $blog->slug) }}",
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Organization",
    "name": "Everyday Plastic",
    "url": "https://everydayplastic.co"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Everyday Plastic",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('favicon-96x96.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('blogs.detail', $blog->slug) }}"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home",  "item": "https://everydayplastic.co/" },
    { "@type": "ListItem", "position": 2, "name": "Blog",  "item": "https://everydayplastic.co/blogs" },
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($blog->title) }}", "item": "{{ route('blogs.detail', $blog->slug) }}" }
  ]
}
</script>
@endsection

@section('content')
    <div class="px-8 py-10">
        <h1 class="text-4xl font-semibold dark:text-white">
            {{ $blog->title }}
        </h1>
        <img class="w-full py-5"
             src="{{ asset('storage/' . $blog->image) }}"
             alt="{{ $blog->title }}"
             width="1200" height="630"
             loading="eager">
        <div class="py-5 dark:text-white">
            {!! $blog->description !!}
        </div>
    </div>
@endsection

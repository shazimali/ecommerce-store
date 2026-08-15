@extends('layouts.app')

{{-- ── Per-page SEO Meta ──────────────────────────────────────────────────── --}}
@section('seo_title', ($product->seo_title ?: $product->title . ' | Everyday Plastic'))
@section('seo_description', ($product->seo_desc ?: Str::limit(strip_tags((string) $product->short_desc), 155)))
@section('canonical', route('product.detail', $product->slug))
@section('og_title',       $product->title)
@section('og_description', $product->seo_desc ?: Str::limit(strip_tags((string) $product->short_desc), 155))
@section('og_image',       asset('storage/' . $product->image))
@section('og_url',         route('product.detail', $product->slug))

{{-- ── Product + Offer + AggregateRating + FAQ Structured Data ────────────── --}}
@section('schema')
@php
    $price        = $product->price_detail?->price ?? 0;
    $reviews      = $product->reviews ?? collect();
    $avgRating    = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 5.0;
    $reviewCount  = $reviews->count() ?: 1;
    $availability = $product->coming_soon ? 'https://schema.org/PreOrder' : 'https://schema.org/InStock';
    $description  = Str::limit(strip_tags((string) $product->short_desc), 200);
    $productUrl   = route('product.detail', $product->slug);
    $imageUrl     = asset('storage/' . $product->image);
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($product->title) }}",
  "description": "{{ addslashes($description) }}",
  "sku": "{{ $product->code ?? $product->id }}",
  "image": ["{{ $imageUrl }}"],
  "url": "{{ $productUrl }}",
  "brand": {
    "@type": "Brand",
    "name": "Everyday Plastic"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ $productUrl }}",
    "priceCurrency": "PKR",
    "price": "{{ $price }}",
    "availability": "{{ $availability }}",
    "seller": {
      "@type": "Organization",
      "name": "Everyday Plastic"
    },
    "shippingDetails": {
      "@type": "OfferShippingDetails",
      "shippingRate": {
        "@type": "MonetaryAmount",
        "value": "0",
        "currency": "PKR"
      },
      "shippingDestination": {
        "@type": "DefinedRegion",
        "addressCountry": "PK"
      },
      "deliveryTime": {
        "@type": "ShippingDeliveryTime",
        "handlingTime": { "@type": "QuantitativeValue", "minValue": 1, "maxValue": 2, "unitCode": "DAY" },
        "transitTime":  { "@type": "QuantitativeValue", "minValue": 3, "maxValue": 5, "unitCode": "DAY" }
      }
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $avgRating }}",
    "reviewCount": "{{ $reviewCount }}",
    "bestRating": "5",
    "worstRating": "1"
  }
}
</script>

{{-- FAQ Schema — boosts visibility in Google "People Also Ask" ──────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is the price of {{ addslashes($product->title) }} in Pakistan?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The {{ addslashes($product->title) }} is available for PKR {{ number_format($price) }} at Everyday Plastic with free delivery on orders above Rs. 3,999."
      }
    },
    {
      "@type": "Question",
      "name": "Is {{ addslashes($product->title) }} available for delivery across Pakistan?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, Everyday Plastic delivers {{ addslashes($product->title) }} across Pakistan including Lahore, Karachi, Islamabad, Rawalpindi, and Gujranwala. Standard delivery takes 3 to 5 business days."
      }
    },
    {
      "@type": "Question",
      "name": "What is the return policy for {{ addslashes($product->title) }}?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Everyday Plastic offers a 7-day easy return policy on all products including {{ addslashes($product->title) }}. Terms and conditions apply."
      }
    }
  ]
}
</script>

{{-- BreadcrumbList Schema ──────────────────────────────────────────────── --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home",     "item": "https://everydayplastic.co/" },
    { "@type": "ListItem", "position": 2, "name": "Shop",     "item": "https://everydayplastic.co/shop" },
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($product->title) }}", "item": "{{ $productUrl }}" }
  ]
}
</script>
@endsection

@section('content')
@livewire('product-detail', ['slug' => $product->slug])
@endsection
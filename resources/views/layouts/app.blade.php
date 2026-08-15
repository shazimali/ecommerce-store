<!doctype html>
<html
x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }"
lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script>
        if (localStorage.getItem('_x_darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    {{-- ── Dynamic SEO Meta (override per page with @section) ─────────────────── --}}
    <title>@yield('seo_title', 'Everyday Plastic – Quality Plastic Homeware &amp; Kitchen Storage in Pakistan')</title>
    <meta name="description" content="@yield('seo_description', 'Shop premium plastic kitchen storage, baby furniture, shoe racks &amp; home organizers. Free delivery on orders above Rs. 3,999.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="@yield('og_title', 'Everyday Plastic – Quality Homeware Solutions')">
    <meta property="og:description" content="@yield('og_description', 'Premium plastic products for your home. Free delivery above Rs. 3,999.')">
    <meta property="og:image"       content="@yield('og_image', asset('storage/og-image.jpg'))">
    <meta property="og:url"         content="@yield('og_url', url()->current())">
    <meta property="og:site_name"   content="Everyday Plastic">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Everyday Plastic')">
    <meta name="twitter:description" content="@yield('og_description', 'Premium plastic products for your home.')">
    <meta name="twitter:image"       content="@yield('og_image', asset('storage/og-image.jpg'))">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- SweetAlert2 deferred so it never blocks page render --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    {{-- Store-level LocalBusiness structured data (always present) --}}
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Everyday Plastic",
  "description": "Quality plastic homeware and kitchen storage solutions for Pakistani homes",
  "url": "https://everydayplastic.co",
  "telephone": "+92-336-3413244",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Ali Pur Chowk, Raj Kot, Gondlanwala Road",
    "addressLocality": "Gujranwala",
    "addressRegion": "Punjab",
    "addressCountry": "PK"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "32.1617",
    "longitude": "74.1883"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "09:00",
    "closes": "21:00"
  },
  "priceRange": "PKR 1,699 - PKR 4,449",
  "servesCuisine": null,
  "areaServed": {
    "@type": "Country",
    "name": "Pakistan"
  },
  "sameAs": [
    "https://www.facebook.com/everydayplastic",
    "https://www.instagram.com/everydayplastic"
  ]
}
</script>

    {{-- Per-page structured data slot (Product, Blog, FAQ schemas injected here) --}}
    @yield('schema')

  </head>
  <body
  
  class="dark:bg-black bg-white w-full">
    @include('layouts.header')
    @include('inc.navbar')
    @yield('content')
    @include('layouts.footer')
    <livewire:chat-widget />
    @livewireScripts
    @stack('scripts')
  </body>
</html>
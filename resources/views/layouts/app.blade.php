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
    <!-- Add these to <head> -->
    <title>Everyday Plastic - Quality Plastic Homeware & Kitchen Storage Solutions in Pakistan</title>
    <meta name="description" content="Shop premium plastic kitchen storage, baby furniture, shoe racks & home organizers. Free delivery on orders above Rs. 3,999. Quality products for Pakistani homes.">
    <meta name="keywords" content="plastic kitchen organizers, spice racks Pakistan, baby furniture, shoe racks, vegetable racks Gujranwala">

    <!-- Open Graph for social sharing -->
    <meta property="og:title" content="Everyday Plastic - Quality Homeware Solutions">
    <meta property="og:description" content="Premium plastic products for your home. Free delivery above Rs. 3,999">
    <meta property="og:image" content="https://everydayplastic.co/storage/og-image.jpg">
    <meta property="og:url" content="https://everydayplastic.co">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">

    <title>Everyday {{ website()->title }} | @yield('title')</title>
    <meta name="description" content="Everyday {{ website()->title }} – Quality Plastic Products | Kitchen, Chairs & Racks">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://everydayplastic.co/">
    <link rel="icon" type="image/png" href="{{asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{asset('favicon.svg')}}" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Store",
  "name": "Everyday Plastic",
  "description": "Quality plastic homeware and kitchen storage solutions",
  "url": "https://everydayplastic.co",
  "telephone": "+92-336-3413244",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Ali Pur Chowk, Raj Kot, Gondlanwala Road",
    "addressLocality": "Gujranwala",
    "addressCountry": "PK"
  },
  "priceRange": "PKR 1,699 - PKR 4,449"
}
</script>
  </head>
  <body
  
  class="dark:bg-black bg-white w-full">
    @include('layouts.header')
    @include('inc.navbar')
    @yield('content')
    @include('layouts.footer')
    @livewireScripts
    @stack('scripts')
  </body>
</html>
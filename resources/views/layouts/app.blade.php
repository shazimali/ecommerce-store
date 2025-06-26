<!doctype html>
<html
x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }"
lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Everyday {{ website()->title }} | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{asset('favicon.svg')}}" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body
  
  class="dark:bg-black bg-white w-full">
    @include('layouts.header')
    @include('inc.navbar')
    @yield('content')
    @include('layouts.footer')
    @stack('scripts')
  </body>
</html>
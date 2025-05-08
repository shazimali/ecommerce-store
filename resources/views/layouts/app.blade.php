<!doctype html>
<html
x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }"
lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Everyday {{ website()->title }} | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body
  
  class="dark:bg-black bg-white w-full">
    @include('layouts.header')
    @include('inc.navbar')
    @yield('content')
    @include('layouts.footer')
  </body>
</html>
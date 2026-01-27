<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nail System')</title>

    {{-- Font Icon --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" />

    {{-- Font Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- Style Css --}}
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>@include('user.layout.header')</header>

    <main>
        @yield('content')
    </main>

    <footer>@include('user.layout.footer')</footer>


    {{-- Nhúng tiktok --}}
    <script async src="https://www.tiktok.com/embed.js"></script>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
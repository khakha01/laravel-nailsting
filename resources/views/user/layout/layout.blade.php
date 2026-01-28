<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nail System')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo-icon.png') }}">

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

    @if(app()->environment('production') && config('services.ga_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ config('services.ga_id') }}');
        </script>
    @endif


</head>

<body>

    <header>@include('user.layout.header')</header>

    <main>
        @yield('content')
    </main>

    <footer>@include('user.layout.footer')</footer>


    @if(request()->routeIs('home'))
        <div id="intro-overlay"
            class="fixed inset-0 z-[99999] bg-pink-50/95 backdrop-blur-md flex items-center justify-center transition-opacity duration-1000 ease-out hidden">
            <div class="text-center select-none cursor-default">
                <p id="word-welcome"
                    class="text-pink-400 text-sm uppercase tracking-[0.5em] mb-4 opacity-0 transition-all duration-1000 ease-out">
                    Welcome to
                </p>
                <h1 class="text-6xl md:text-8xl text-pink-600 tracking-wider"
                    style="font-family: 'Mrs Saint Delafield', cursive;">
                    <span id="word-nails"
                        class="inline-block opacity-0 translate-y-8 transition-all duration-1000 ease-out">Nails</span>
                    <span id="word-ting"
                        class="inline-block opacity-0 translate-y-8 transition-all duration-1000 ease-out ml-2">ting</span>
                </h1>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const overlay = document.getElementById('intro-overlay');
                const wordWelcome = document.getElementById('word-welcome');
                const wordNails = document.getElementById('word-nails');
                const wordTing = document.getElementById('word-ting');

                const hasShownIntro = sessionStorage.getItem('hasShownIntro');

                if (!hasShownIntro && overlay) {
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    setTimeout(() => {
                        wordWelcome.classList.remove('opacity-0');
                        wordWelcome.classList.add('translate-y-[-10px]');
                    }, 300);

                    setTimeout(() => {
                        wordNails.classList.remove('opacity-0', 'translate-y-8');
                    }, 1000);

                    setTimeout(() => {
                        wordTing.classList.remove('opacity-0', 'translate-y-8');
                    }, 1800);

                    setTimeout(() => {
                        overlay.classList.add('opacity-0', 'pointer-events-none');
                        document.body.style.overflow = '';
                        sessionStorage.setItem('hasShownIntro', 'true');
                    }, 3500);

                    setTimeout(() => {
                        overlay.remove();
                    }, 4500);
                } else {
                    if (overlay) overlay.remove();
                }
            });
        </script>
    @endif

    {{-- Nhúng tiktok --}}
    <script async src="https://www.tiktok.com/embed.js"></script>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>

</html>
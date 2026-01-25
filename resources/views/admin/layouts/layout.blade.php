<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Style Css --}}
    <link rel="stylesheet" href="{{ asset('css/admin.min.css') }}">
    
    {{-- Additional styles from child views --}}
    @stack('styles')

</head>

<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">

        @include('admin.partials.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            @include('admin.partials.header')

            <main class="w-full flex-grow p-6">
                @yield('content')
            </main>

            @include('admin.partials.footer')
        </div>

    </div>


    @stack('scripts')
    <script>
        async function handleLogout() {
            if (!confirm('Bạn có chắc chắn muốn đăng xuất?')) return;
            
            try {
                await fetch('/api/admin/auth/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {}

            document.cookie = "admin_token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC; SameSite=Lax";
            window.location.href = '/admin/login';
        }
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS cho hiệu ứng Submenu mượt mà */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .submenu.open {
            max-height: 500px; /* Đủ lớn để hiện nội dung */
            transition: max-height 0.5s ease-in;
        }
        /* Tùy chỉnh thanh cuộn cho đẹp hơn */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
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

    <script>
        // Xử lý Mobile Menu
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            if(overlay) overlay.classList.toggle('hidden');
        }

        // Xử lý Submenu (Accordion)
        function toggleSubmenu(id, arrowId) {
            const submenu = document.getElementById(id);
            const arrow = document.getElementById(arrowId);

            // Toggle class open
            if (submenu.classList.contains('open')) {
                submenu.classList.remove('open');
                arrow.style.transform = 'rotate(0deg)';
            } else {
                submenu.classList.add('open');
                arrow.style.transform = 'rotate(180deg)';
            }
        }
    </script>
</body>
</html>

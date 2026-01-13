<!-- Overlay mobile -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 z-20 bg-black/30 hidden lg:hidden transition-opacity">
</div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white text-gray-700
           transform -translate-x-full transition-transform duration-300 ease-in-out
           lg:translate-x-0 lg:static lg:inset-0 flex flex-col h-screen border-r">

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b">
        <img src="{{ asset('img/logo-cms.png') }}" alt="cms_by_huynh_kha" class="w-auto h-14 object-cover">
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 border-l-4 transition-colors
                   {{ request()->is('admin/dashboard')
                       ? 'border-blue-500 bg-blue-50 text-blue-600'
                       : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z
                                 M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z
                                 M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z
                                 M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Booking -->
            <li>
                <button onclick="toggleSubmenu('submenu-booking', 'arrow-booking')"
                    class="w-full flex items-center justify-between px-6 py-3
                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10
                                     M5 21h14a2 2 0 002-2V7
                                     a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Quản lý lịch hẹn
                    </span>

                    <svg id="arrow-booking" class="w-4 h-4 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Submenu -->
                <ul id="submenu-booking" class="hidden bg-gray-50">
                    <li>
                        <a href="{{ route('booking-dates.index') }}"
                            class="block pl-8 pr-4 py-2 text-sm
                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>

                            Danh sách lịch làm việc
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('booking-dates.create') }}"
                            class="block pl-8 pr-4 py-2 text-sm
                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            Thêm lịch làm việc
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Customer -->
            <li>
                <a href="#"
                    class="flex items-center px-6 py-3 border-l-4 border-transparent
                          text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292
                                 M15 21H3v-1a6 6 0 0112 0v1
                                 zm0 0h6v-1a6 6 0 00-9-5.197
                                 M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Khách hàng
                </a>
            </li>

        </ul>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t">
        <a href="#" class="flex items-center text-gray-600 hover:text-red-600 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7
                         m6 4v1a3 3 0 01-3 3H6
                         a3 3 0 01-3-3V7
                         a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="text-sm font-medium">Đăng xuất</span>
        </a>
    </div>

</aside>
<script>
    function toggleSubmenu(id, arrowId) {
        const submenu = document.getElementById(id);
        const arrow = document.getElementById(arrowId);

        submenu.classList.toggle('hidden');

        // xoay mũi tên
        if (submenu.classList.contains('hidden')) {
            arrow.style.transform = 'rotate(0deg)';
        } else {
            arrow.style.transform = 'rotate(180deg)';
        }
    }
</script>

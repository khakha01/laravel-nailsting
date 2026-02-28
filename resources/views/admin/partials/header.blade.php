<header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="flex items-center justify-between h-16 px-6">

        <div class="flex items-center">
            <button onclick="toggleSidebar()"
                class="text-gray-500 hover:text-blue-600 focus:outline-none lg:hidden mr-4 transition-colors p-2 hover:bg-blue-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>


            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Tổng quan')
            </h2>
        </div>

        <div class="flex items-center space-x-4">

            <button class="text-gray-400 hover:text-gray-600 focus:outline-none relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <span
                    class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">3</span>
            </button>

            <div class="relative inline-block text-left" id="admin-dropdown">
                <button type="button" onclick="toggleDropdown()"
                    class="flex items-center p-1 pr-3 rounded-full hover:bg-gray-100 transition-all duration-200 focus:outline-none border border-transparent active:scale-95">

                    <div class="relative">
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm"
                            src="{{ get_media_url(Auth::guard('admin')->user()?->media_id, 'https://ui-avatars.com/api/?name=' . (Auth::guard('admin')->user()?->name ?? 'Admin') . '&background=6366f1&color=fff') }}"
                            alt="User avatar">
                        <span
                            class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    <div class="ml-2.5 hidden md:block text-left">
                        <p class="text-xs font-bold text-gray-800 leading-none tracking-tight">
                            {{ Auth::guard('admin')->user()?->name ?? 'Administrator' }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase mt-0.5 tracking-wider">Quản trị</p>
                    </div>

                    <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="dropdown-menu"
                    class="hidden absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-gray-100 z-50 overflow-hidden transform origin-top-right transition-all duration-200">

                    <div class="py-2">
                        <a href="{{ route('admin.profile') }}"
                            class="group flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <div
                                class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center mr-3 group-hover:bg-indigo-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Hồ sơ</span>
                        </a>

                        @if(Auth::guard('admin')->user()?->hasPermission('setting-view'))
                            <a href="{{ route('settings.index') }}"
                                class="group flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center mr-3 group-hover:bg-indigo-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <span class="font-medium">Cài đặt</span>
                            </a>
                        @endif

                        <div class="mt-2 pt-2 border-t border-gray-50">
                            <button onclick="handleLogout()"
                                class="w-full flex items-center px-4 py-3 text-sm text-red-500 hover:bg-red-50 transition-all font-bold">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Đăng xuất
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleDropdown() {
                    const menu = document.getElementById('dropdown-menu');
                    menu.classList.toggle('hidden');
                }

                window.addEventListener('click', function (e) {
                    const container = document.getElementById('admin-dropdown');
                    const menu = document.getElementById('dropdown-menu');
                    if (!container.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            </script>
        </div>
    </div>
</header>
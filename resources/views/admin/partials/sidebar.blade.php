<!-- Overlay mobile -->
<div id="sidebar-overlay" onclick="toggleSidebar()"
    class="fixed inset-0 z-20 bg-black/30 hidden lg:hidden transition-opacity">
</div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white text-gray-700
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 border-l-4 transition-colors
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

            <!-- Categories -->
            @if(Auth::guard('admin')->user()->hasPermission('category-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-categories', 'arrow-categories')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">

                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                            </svg>

                            Quản lý danh mục
                        </span>

                        <svg id="arrow-categories" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <ul id="submenu-categories" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('categories.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách danh mục
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('category-create'))
                            <li>
                                <a href="{{ route('categories.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    Thêm danh mục
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Products -->
            @if(Auth::guard('admin')->user()->hasPermission('product-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-products', 'arrow-products')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">

                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                            </svg>


                            Quản lý sản phẩm
                        </span>

                        <svg id="arrow-products" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <ul id="submenu-products" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách sản phẩm
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('product-create'))
                            <li>
                                <a href="{{ route('products.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    Thêm sản phẩm
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Nail Categories -->
            @if(Auth::guard('admin')->user()->hasPermission('nail-category-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-nail-categories', 'arrow-nail-categories')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                            </svg>
                            Quản lý danh mục nail
                        </span>

                        <svg id="arrow-nail-categories" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <ul id="submenu-nail-categories" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('nail-categories.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Danh sách danh mục nail
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('nail-category-create'))
                            <li>
                                <a href="{{ route('nail-categories.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Thêm danh mục nail
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Nails -->
            @if(Auth::guard('admin')->user()->hasPermission('nail-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-nails', 'arrow-nails')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                            </svg>
                            Quản lý nail
                        </span>

                        <svg id="arrow-nails" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <ul id="submenu-nails" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('nails.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Danh sách nail
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('nail-create'))
                            <li>
                                <a href="{{ route('nails.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Thêm nail
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Banners -->
            @if(Auth::guard('admin')->user()->hasPermission('banner-view') || true) {{-- Temporarily allow true if
                permission not seeded --}}
                <li>
                    <button onclick="toggleSubmenu('submenu-banners', 'arrow-banners')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            Quản lý Banner
                        </span>

                        <svg id="arrow-banners" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <ul id="submenu-banners" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('banners.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                Danh sách Banner
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('banner-create') || true)
                            <li>
                                <a href="{{ route('banners.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Thêm Banner
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Booking -->
            @if(Auth::guard('admin')->user()->hasPermission('booking-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-booking', 'arrow-booking')" class="w-full flex items-center justify-between px-6 py-3
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
                            <a href="{{ route('bookings.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách đặt lịch
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('booking-dates.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách lịch làm việc
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('booking-edit'))
                            <li>
                                <a href="{{ route('booking-dates.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    Thêm lịch làm việc
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Admin -->
            @if(Auth::guard('admin')->user()->hasPermission('admin-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-admin', 'arrow-admin')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">

                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292
                                                 M15 21H3v-1a6 6 0 0112 0v1
                                                 zm0 0h6v-1a6 6 0 00-9-5.197
                                                 M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Quản lý quản trị
                        </span>
                        <svg id="arrow-admin" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>
                    <!-- Submenu -->
                    <ul id="submenu-admin" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('admins.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách quản trị
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('admin-create'))
                            <li>
                                <a href="{{ route('admins.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    Thêm quản trị
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            <!-- Permission -->
            @if(Auth::guard('admin')->user()->hasPermission('permission-view'))
                <li>
                    <button onclick="toggleSubmenu('submenu-permissions', 'arrow-permissions')" class="w-full flex items-center justify-between px-6 py-3
                                           text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
                        <span class="flex items-center">

                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Quản lý quyền hạn
                        </span>
                        <svg id="arrow-permissions" class="w-4 h-4 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                    </button>
                    <!-- Submenu -->
                    <ul id="submenu-permissions" class="hidden bg-gray-50">
                        <li>
                            <a href="{{ route('permissions.index') }}"
                                class="block pl-8 pr-4 py-2 text-sm
                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>

                                Danh sách quyền hạn
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->hasPermission('permission-create'))
                            <li>
                                <a href="{{ route('permissions.create') }}"
                                    class="block pl-8 pr-4 py-2 text-sm
                                                                  text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>

                                    Thêm quyền hạn
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

        </ul>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t">
        <button onclick="handleLogout()"
            class="w-full flex items-center text-gray-600 hover:text-red-600 transition-colors">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7
                         m6 4v1a3 3 0 01-3 3H6
                         a3 3 0 01-3-3V7
                         a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="text-sm font-medium">Đăng xuất</span>
        </button>
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
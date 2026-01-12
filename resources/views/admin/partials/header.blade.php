<header class="bg-white shadow-sm sticky top-0 z-10">
    <div class="flex items-center justify-between h-16 px-6">

        <div class="flex items-center">
            <button onclick="toggleSidebar()" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Tổng quan')
            </h2>
        </div>

        <div class="flex items-center space-x-4">

            <button class="text-gray-400 hover:text-gray-600 focus:outline-none relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">3</span>
            </button>

            <div class="relative group">
                <button class="flex items-center focus:outline-none">
                    <img class="w-8 h-8 rounded-full object-cover border border-gray-300" src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}" alt="User avatar">
                    <span class="ml-2 text-sm font-medium text-gray-600 group-hover:text-gray-800 hidden md:block">{{ Auth::user()->name ?? 'Administrator' }}</span>
                </button>
            </div>
        </div>
    </div>
</header>

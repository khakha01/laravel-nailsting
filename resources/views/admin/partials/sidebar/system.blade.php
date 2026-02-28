@if(Auth::guard('admin')->user()?->hasAnyPermission(['setting-view', 'system-log-view']))
    <li>
        <button onclick="toggleSubmenu('submenu-system', 'arrow-system')"
            class="w-full flex items-center justify-between px-6 py-3 text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Quản lý hệ thống
            </span>
            <svg id="arrow-system" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Submenu -->
        <ul id="submenu-system" class="hidden bg-gray-50">
            @if(Auth::guard('admin')->user()?->hasPermission('setting-view'))
                <li>
                    <a href="{{ route('settings.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center transition-colors {{ request()->routeIs('settings.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Cài đặt chung
                    </a>
                </li>
            @endif

            @if(Auth::guard('admin')->user()?->hasPermission('system-log-view'))
                <li>
                    <a href="{{ route('logs.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center transition-colors {{ request()->routeIs('logs.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Logs hệ thống
                    </a>
                </li>
            @endif

            @if(Auth::guard('admin')->user()?->hasPermission('redis-view'))
                <li>
                    <a href="{{ route('redis.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center transition-colors {{ request()->routeIs('redis.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        Thống kê Redis
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
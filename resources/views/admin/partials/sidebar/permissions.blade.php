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
            <svg id="arrow-permissions" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
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
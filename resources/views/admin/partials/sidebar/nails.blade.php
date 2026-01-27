@php
    $active = request()->routeIs('nails.*');
@endphp
@if(Auth::guard('admin')->user()->hasPermission('nail-view'))
    <li>
        <button id="btn-nails" onclick="toggleSubmenu('submenu-nails', 'arrow-nails', 'btn-nails')" class="w-full flex items-center justify-between px-6 py-3 transition-colors focus:outline-none sidebar-button
                                       {{ $active ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                </svg>
                Quản lý nail
            </span>

            <svg id="arrow-nails" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" style="transform: rotate({{ $active ? 180 : 0 }}deg)">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Submenu -->
        <ul id="submenu-nails" class="bg-gray-50 sidebar-submenu {{ $active ? '' : 'hidden' }}">
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
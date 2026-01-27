@if(Auth::guard('admin')->user()->hasPermission('booking-view'))
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

            <svg id="arrow-booking" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
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
            @if(Auth::guard('admin')->user()->hasPermission('nail-booking-view'))
                <li>
                    <a href="{{ route('nail-bookings.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm
                                                                              text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 text-pink-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18a3.75 3.75 0 0 0 .495-7.467 5.99 5.99 0 0 0-1.925 3.546 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
                        </svg>

                        Danh sách đặt lịch Nail
                    </a>
                </li>
            @endif
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
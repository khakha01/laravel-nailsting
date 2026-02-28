@if(Auth::guard('admin')->user()?->hasPermission('booking-view'))
    <li>
        <button onclick="toggleSubmenu('submenu-booking', 'arrow-booking')"
            class="w-full flex items-center justify-between px-6 py-3
                                                                       text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10
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
                    class="block pl-8 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center transition-colors">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>

                    Danh sách đặt lịch
                </a>
            </li>

            @if(Auth::guard('admin')->user()?->hasPermission('nail-booking-view'))
                <li>
                    <a href="{{ route('nail-bookings.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-pink-600 flex gap-2 items-center transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 text-pink-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 12h4.5m1.5 0a1.5 1.5 0 0 1 1.5 1.5V21a1.5 1.5 0 0 1-1.5 1.5h-7.5A1.5 1.5 0 0 1 6.75 21v-7.5a1.5 1.5 0 0 1 1.5-1.5h1.5m0 0V4.5a1.5 1.5 0 0 1 1.5-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5V12" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 7.5h3" />
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
            @if(Auth::guard('admin')->user()?->hasPermission('booking-edit'))
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
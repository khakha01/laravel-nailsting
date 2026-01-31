@php
    $isPostActive = request()->routeIs('posts.*') || request()->routeIs('post-categories.*') || request()->routeIs('post-tags.*');
@endphp

@if(Auth::guard('admin')->user()->hasPermission('post-view'))
    <li>
        <button onclick="toggleSubmenu('submenu-posts', 'arrow-posts')"
            class="w-full flex items-center justify-between px-6 py-3
                                                               text-gray-700 hover:bg-gray-100 transition-colors focus:outline-none">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
                Quản lý Blog
            </span>

            <svg id="arrow-posts" class="w-4 h-4 transition-transform duration-300 {{ $isPostActive ? 'rotate-180' : '' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Submenu -->
        <ul id="submenu-posts" class="{{ $isPostActive ? '' : 'hidden' }} bg-gray-50">
            <li>
                <a href="{{ route('posts.index') }}"
                    class="block pl-8 pr-4 py-2 text-sm
                                                                      text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center {{ request()->routeIs('posts.index') ? 'text-blue-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    Bài viết
                </a>
            </li>
            @if(Auth::guard('admin')->user()->hasPermission('post-category-view'))
                <li>
                    <a href="{{ route('post-categories.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm
                                                                                                          text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center {{ request()->routeIs('post-categories.*') ? 'text-blue-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.625-12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-5.25L2.25 13.5V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Danh mục bài viết
                    </a>
                </li>
            @endif
            @if(Auth::guard('admin')->user()->hasPermission('post-tag-view'))
                <li>
                    <a href="{{ route('post-tags.index') }}"
                        class="block pl-8 pr-4 py-2 text-sm
                                                                                                          text-gray-600 hover:bg-gray-100 hover:text-blue-600 flex gap-2 items-center {{ request()->routeIs('post-tags.*') ? 'text-blue-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 0 0 3.182 0l4.318-4.318a2.25 2.25 0 0 0 0-3.182L10.581 3.659A2.25 2.25 0 0 0 9.159 3ZM6 6.75h.008v.008H6V6.75Z" />
                        </svg>
                        Tags bài viết
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif
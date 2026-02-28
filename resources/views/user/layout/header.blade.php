<div class="bg-slate-50 text-slate-800 overflow-x-hidden relative">
    <!-- Background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div
            class="absolute top-1/4 -left-20 w-96 h-96 bg-[#ff0052]/10 rounded-full blur-3xl animate-[float_8s_ease-in-out_infinite]">
        </div>
        <div
            class="absolute bottom-1/4 -right-20 w-80 h-80 bg-blue-300/20 rounded-full blur-3xl animate-[float_6s_ease-in-out_infinite]">
        </div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pink-200/20 rounded-full blur-3xl">
        </div>
    </div>

    <!-- Header -->
    <header class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-5xl">
        <div class="rounded-full px-6 py-3 flex items-center justify-between
                    bg-white/70 backdrop-blur-xl border border-white/50
                    shadow-lg shadow-[#ff0052]/5">

            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="/">
                    @if($settings && $settings->logo_id)
                        <img src="{{ get_media_url($settings->logo_id) }}"
                            alt="{{ $settings->website_name ?? 'Nails-tingggg' }}" class="h-14">
                    @else
                        <img src="{{asset('img/logo.png')}}" alt="Nails-tingggg" class="h-14">
                    @endif
                </a>
            </div>

            <!-- Menu -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="/" class="hover:text-[#ff0052] transition">Trang chủ</a>
                <a href="{{ route('collection') }}" class="hover:text-[#ff0052] transition">Bộ sưu tập</a>
                <a href="{{ route('pricing') }}" class="hover:text-[#ff0052] transition">Bảng giá</a>
                <a href="{{ route('appointment') }}" class="hover:text-[#ff0052] transition">Đặt lịch</a>

                <!-- News Dropdown -->
                <div class="relative group">
                    <a href="{{ route('user.posts.index') }}"
                        class="hover:text-[#ff0052] transition flex items-center gap-1">
                        Tin tức
                        <i
                            class="fa-solid fa-chevron-down text-[10px] group-hover:rotate-180 transition-transform duration-300"></i>
                    </a>

                    <div
                        class="absolute top-full left-1/2 -translate-x-1/2 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[200px]">
                        <div class="bg-white rounded-2xl shadow-xl border border-neutral-100 p-2 overflow-hidden">
                            @foreach($headerPostCategories as $cat)
                                <a href="{{ route('user.posts.detail', $cat->slug) }}"
                                    class="block px-4 py-2.5 text-slate-600 hover:bg-pink-50 hover:text-[#ff0052] rounded-xl transition">
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                @auth('web')
                    <div class="relative group">
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-full ring-2 ring-[#ff0052]/30 hover:ring-[#ff0052] transition overflow-hidden">
                            @if(auth('web')->user()->avatar)
                                <img src="{{ auth('web')->user()->avatar }}" alt="{{ auth('web')->user()->name }}"
                                    class="w-10 h-10 object-cover rounded-full">
                            @else
                                <span
                                    class="w-10 h-10 flex items-center justify-center bg-[#ff0052]/10 text-[#ff0052] font-bold text-sm rounded-full">
                                    {{ strtoupper(substr(auth('web')->user()->name, 0, 1)) }}
                                </span>
                            @endif
                        </button>
                        <div
                            class="absolute top-full right-0 pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 min-w-[180px] z-50">
                            <div class="bg-white rounded-2xl shadow-xl border border-neutral-100 overflow-hidden">
                                {{-- User info --}}
                                <div class="px-4 py-3 border-b border-neutral-100">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth('web')->user()->name }}
                                    </p>
                                    <p class="text-xs text-slate-400 truncate">{{ auth('web')->user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-xl transition">
                                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('google.redirect') }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white border border-neutral-200 shadow-sm hover:shadow-md transition group"
                        title="Đăng nhập Google">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 48 48">
                            <path fill="#EA4335"
                                d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C36.5 2.5 30.6 0 24 0 14.7 0 6.6 4.9 2.5 12.2l7.9 6.1C12.5 13.2 17.8 9.5 24 9.5z" />
                            <path fill="#4285F4"
                                d="M46.5 24c0-1.6-.1-3.2-.4-4.7H24v9h12.7c-.5 2.9-2 5.4-4.3 7.1l6.7 5.2c3.9-3.6 6.1-9 6.1-15.6z" />
                            <path fill="#FBBC05"
                                d="M12.4 28.3c-.5-1.5-.8-3.1-.8-4.8s.3-3.3.8-4.8l-7.9-6.1C3.5 15.5 2.5 19.6 2.5 24c0 4.4 1 8.5 2.9 12.1l7.9-6.1z" />
                            <path fill="#34A853"
                                d="M24 48c6.6 0 12.5-2.2 16.7-6l-7.9-6.1c-2.2 1.5-5 2.4-8.8 2.4-6.2 0-11.5-3.7-14.2-9l-7.9 6.1C6.6 43.1 14.7 48 24 48z" />
                        </svg>
                    </a>
                @endauth

                <a href="{{ route('appointment') }}" class="hidden sm:block bg-gradient-to-r from-pink-500 to-rose-500 text-white text-sm font-semibold
                          px-5 py-2.5 rounded-full hover:bg-[#e1064d] transition">
                    Đặt lịch ngay
                </a>

                <!-- Mobile menu button -->
                <button id="menuBtn" class="md:hidden w-10 h-10 flex items-center justify-center
                       rounded-full bg-[#ff0052]/10 text-[#ff0052]">
                    <i class="fa-solid fa-bars"></i>
                </button>

            </div>
        </div>
    </header>
</div>
<!-- Mobile Drawer -->
<div id="mobileDrawer" class="fixed inset-0 z-50 hidden md:hidden">

    <div id="drawerOverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="absolute left-0 top-0 h-full w-[70%] max-w-xs
               bg-white shadow-xl
               transform -translate-x-full
               transition-transform duration-300 ease-out
               flex flex-col p-6" id="drawerContent">

        <div class="mb-8">
            @if($settings && $settings->logo_id)
                <img src="{{ get_media_url($settings->logo_id) }}" class="h-10">
            @else
                <img src="{{asset('img/logo.png')}}" class="h-10">
            @endif
        </div>

        <!-- Menu -->
        <nav class="flex flex-col gap-6 text-lg font-medium">
            <a href="{{ route('home') }}" class="hover:text-[#ff0052]">Trang chủ</a>
            <a href="{{ route('collection') }}" class="hover:text-[#ff0052]">Bộ sưu tập</a>
            <a href="{{ route('pricing') }}" class="hover:text-[#ff0052]">Bảng giá</a>
            <div class="flex flex-col gap-3">
                <a href="{{ route('user.posts.index') }}" class="hover:text-[#ff0052] font-bold">Tin tức</a>
                <div class="pl-4 flex flex-col gap-3 border-l border-neutral-100">
                    @foreach($headerPostCategories as $cat)
                        <a href="{{ route('user.posts.detail', $cat->slug) }}"
                            class="text-sm text-slate-500 hover:text-[#ff0052]">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <div class="mt-auto flex flex-col gap-3">
            @guest('web')
                <a href="{{ route('google.redirect') }}"
                    class="flex items-center justify-center gap-2 border border-neutral-200 py-3 rounded-full hover:bg-neutral-50 transition">
                    <svg class="w-5 h-5" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C36.5 2.5 30.6 0 24 0 14.7 0 6.6 4.9 2.5 12.2l7.9 6.1C12.5 13.2 17.8 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.5 24c0-1.6-.1-3.2-.4-4.7H24v9h12.7c-.5 2.9-2 5.4-4.3 7.1l6.7 5.2c3.9-3.6 6.1-9 6.1-15.6z" />
                        <path fill="#FBBC05"
                            d="M12.4 28.3c-.5-1.5-.8-3.1-.8-4.8s.3-3.3.8-4.8l-7.9-6.1C3.5 15.5 2.5 19.6 2.5 24c0 4.4 1 8.5 2.9 12.1l7.9-6.1z" />
                        <path fill="#34A853"
                            d="M24 48c6.6 0 12.5-2.2 16.7-6l-7.9-6.1c-2.2 1.5-5 2.4-8.8 2.4-6.2 0-11.5-3.7-14.2-9l-7.9 6.1C6.6 43.1 14.7 48 24 48z" />
                    </svg>
                    Đăng nhập bằng Google
                </a>
            @endguest
            <a href="{{ route('appointment') }}" class="block text-center bg-[#ff0052] text-white py-3 rounded-full">
                Đặt lịch ngay
            </a>
        </div>
    </div>
</div>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const drawer = document.getElementById('mobileDrawer');
    const drawerContent = document.getElementById('drawerContent');
    const overlay = document.getElementById('drawerOverlay');

    menuBtn.addEventListener('click', () => {
        drawer.classList.remove('hidden');
        setTimeout(() => {
            drawerContent.classList.remove('-translate-x-full');
        }, 10);
    });

    overlay.addEventListener('click', closeDrawer);

    function closeDrawer() {
        drawerContent.classList.add('-translate-x-full');
        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }
</script>
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
                    <img src="{{asset('img/logo.png')}}" alt="Nails-tingggg" class="h-14">
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
            <img src="{{asset('img/logo.png')}}" class="h-10">
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

        <div class="mt-auto">
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
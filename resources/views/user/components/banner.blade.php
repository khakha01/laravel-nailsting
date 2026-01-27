@if($homeBanner && $homeBanner->is_active)
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FDF8F7] via-white to-[#FFF5F5] relative overflow-hidden py-24">
        {{-- Decorative Blobs --}}
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[600px] h-[600px] bg-pink-100/40 rounded-full blur-[120px] -z-0"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[500px] h-[500px] bg-purple-50/50 rounded-full blur-[100px] -z-0"></div>
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center relative z-10">
            <!-- show banner -->
            <div class="text-center md:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-pink-100 text-[#ff0052] text-sm font-bold mb-4 tracking-wider uppercase">
                ✨ New Collection 2026
            </span>
                @if($homeBanner->description_3)
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-pink-100 text-[#ff0052] text-sm font-bold mb-4 tracking-wider uppercase">
                        {{ $homeBanner->description_3 }}
                    </span>
                @endif

                <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6 text-slate-900">
                    {{ $homeBanner->title ?? 'Nghệ thuật trên' }} <br>
                    <span
                        class="relative bg-clip-text text-transparent bg-gradient-to-r from-[#ff0052] to-purple-600 font-mrssaint">
                        {{ $homeBanner->description_1 ?? 'NailsTingggg' }}
                    </span>
                </h1>

                <p class="text-slate-500 text-lg mb-8 font-medium max-w-lg mx-auto md:mx-0">
                    {{ $homeBanner->description_2 ?? 'Tự tin tỏa sáng với những mẫu nail thời thượng nhất. Sơn gel cao cấp, bền màu và an toàn tuyệt đối.' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href=" {{ $homeBanner->button_link}}"
                        class="px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-full font-bold shadow-lg shadow-[#ff0052]/30 hover:-translate-y-1 transition transform">
                        {{ $homeBanner->button_text}}
                    </a>
                   
                </div>
            </div>

            <!-- show banner item -->
            <div class="relative mt-10 md:mt-0">
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-pink-200 to-purple-100 rounded-full blur-3xl opacity-50 -z-10">
                </div>

                @php
                    $firstItem = $homeBanner->items->where('is_active', true)->first();
                @endphp

                @if($firstItem)
                    <div
                        class="relative mx-auto w-full max-w-md aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition duration-500 border-4 border-white">
                        <img src="{{ get_media_url($firstItem->media) }}" alt="{{ $firstItem->title }}"
                            class="w-full h-full object-cover" />

                        <div
                            class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-sm p-4 rounded-xl shadow-lg animate-[float_4s_ease-in-out_infinite]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-[#ff0052]">
                                    💅
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold">
                                        {{ $firstItem->title ?? ' 𝚃𝚒𝚗𝚐𝚐𝚐𝚐.𝚗𝚊𝚒𝚕𝚜 🫧𓍯𓂃' }}</p>
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $firstItem->description_1 ?? 'Những chiếc nails xinh dành cho các nàng' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Fallback if no items --}}
                    <div
                        class="relative mx-auto w-full max-w-md aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition duration-500 border-4 border-white">
                        <img src="https://instagram.fsgn2-3.fna.fbcdn.net/v/t51.82787-15/588602217_17864172855518651_3328532785939526771_n.jpg?stp=dst-jpg_e35_tt6&_nc_cat=107&ig_cache_key=Mzc3OTEwODcxMjEzNjkyNTQ1NA%3D%3D.3-ccb7-5&ccb=7-5&_nc_sid=58cdad&efg=eyJ2ZW5jb2RlX3RhZyI6InhwaWRzLjEzNDV4MTc4OS5zZHIuQzMifQ%3D%3D&_nc_ohc=_UHd1haxeZgQ7kNvwGTmNHj&_nc_oc=AdkhyShVVJyISolaAwMmNBoOT4sSrAGcUv7NWXVbc8tiLOW9PYm4IpdE2GXXc-PERhGgGnJJFdK5g66snsY4Wdjh&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=instagram.fsgn2-3.fna&_nc_gid=lmtx0eIGShN6lqAzlac2Hg&oh=00_AfoHt7KcajA_wmjV-Wi97hB49Ic24XBGARPRUJ117yUQjw&oe=696807F5"
                            alt="Mẫu nail đẹp" class="w-full h-full object-cover" />
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
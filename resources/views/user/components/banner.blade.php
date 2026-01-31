@if($homeBanner && $homeBanner->is_active)
    <section
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FDF8F7] via-white to-[#FFF5F5] relative overflow-hidden pt-32 pb-6 md:py-24">
        {{-- Decorative Blobs - Ẩn bớt trên mobile để tăng hiệu năng --}}
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-pink-100/40 rounded-full blur-[80px] md:blur-[120px] -z-0">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-[250px] md:w-[500px] h-[250px] md:h-[500px] bg-purple-50/50 rounded-full blur-[60px] md:blur-[100px] -z-0">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">

                <div class="text-center md:text-left order-2 md:order-1">
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-4">
                        <span
                            class="inline-block py-1 px-3 rounded-full bg-pink-100 text-[#ff0052] text-xs md:text-sm font-bold tracking-wider uppercase">
                            ✨ New Collection 2026
                        </span>
                        @if($homeBanner->description_3)
                            <span
                                class="inline-block py-1 px-3 rounded-full bg-pink-100 text-[#ff0052] text-xs md:text-sm font-bold tracking-wider uppercase">
                                {{ $homeBanner->description_3 }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-7xl font-black leading-tight mb-6 text-slate-900">
                        {{ $homeBanner->title ?? 'Nghệ thuật trên' }} <br>
                        <span
                            class="relative bg-clip-text text-transparent bg-gradient-to-r from-[#ff0052] to-purple-600 font-mrssaint">
                            {{ $homeBanner->description_1 ?? 'NailsTingggg' }}
                        </span>
                    </h1>

                    <p class="text-slate-500 text-base md:text-lg mb-8 font-medium max-w-lg mx-auto md:mx-0">
                        {{ $homeBanner->description_2 ?? 'Tự tin tỏa sáng với những mẫu nail thời thượng nhất. Sơn gel cao cấp, bền màu và an toàn tuyệt đối.' }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ $homeBanner->button_link }}"
                            class="px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-full font-bold shadow-lg shadow-[#ff0052]/30 hover:-translate-y-1 transition transform text-center">
                            {{ $homeBanner->button_text }}
                        </a>
                    </div>
                </div>

                <div class="relative order-1 md:order-2 px-4 md:px-0">
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100%] h-[100%] md:w-[120%] md:h-[120%] bg-gradient-to-tr from-pink-200 to-purple-100 rounded-full blur-3xl opacity-50 -z-10">
                    </div>

                    @php
                        $firstItem = $homeBanner->items->where('is_active', true)->first();
                    @endphp

                    <div
                        class="relative mx-auto w-full max-w-[320px] md:max-w-md aspect-[4/5] rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-2xl rotate-0 md:rotate-3 hover:rotate-0 transition duration-500 border-4 border-white">
                        @if($firstItem)
                            <img src="{{ get_media_url($firstItem->media) }}" alt="{{ $firstItem->title }}"
                                class="w-full h-full object-cover" />

                            {{-- Floating Badge - Ẩn trên mobile nhỏ nếu quá chật, hoặc scale lại --}}
                            <div
                                class="absolute bottom-4 left-4 right-4 md:right-auto md:bottom-6 md:left-6 bg-white/90 backdrop-blur-sm p-3 md:p-4 rounded-xl shadow-lg animate-[float_4s_ease-in-out_infinite]">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="hidden sm:flex w-10 h-10 rounded-full bg-pink-100 items-center justify-center text-[#ff0052]">
                                        💅
                                    </div>
                                    <div>
                                        <p class="text-[10px] md:text-xs text-slate-500 font-bold">
                                            {{ $firstItem->title ?? ' 𝚃𝚒𝚗𝚐𝚐𝚐𝚐.𝚗𝚊𝚒𝚕𝚜 🫧' }}
                                        </p>
                                        <p class="text-xs md:text-sm font-bold text-slate-800">
                                            {{ $firstItem->description_1 ?? 'Nails xinh cho nàng' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?q=80&w=1000&auto=format&fit=crop"
                                alt="Mẫu nail đẹp" class="w-full h-full object-cover" />
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endif
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-pink-500 font-bold tracking-[0.2em] text-xs uppercase mb-2 block">Trend 2026</span>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Bộ Sưu Tập <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-400"> Nail
                        Hot</span>
                </h2>
            </div>
            <p class="text-gray-500 max-w-md text-sm leading-relaxed">
                Khám phá những mẫu nail được thiết kế riêng biệt, mang lại vẻ đẹp thanh lịch và đẳng cấp cho đôi tay của
                bạn.
            </p>
        </div>

        @if($nails && $nails->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($nails as $nail)
                    @php
                        $primaryImage = $nail->getPrimaryImage();
                        $imageUrl = $primaryImage && $primaryImage->media ? $primaryImage->media->url : 'https://images.unsplash.com/photo-1604654894610-df490c81726a?q=80&w=600&auto=format&fit=crop';
                        $defaultPrice = $nail->getDefaultPrice() ?: ($nail->prices->count() > 0 ? $nail->prices->first() : null);

                        $priceDisplay = '0đ';
                        if ($defaultPrice) {
                            if ($defaultPrice->price_type === 'fixed' && $defaultPrice->price) {
                                $priceDisplay = number_format($defaultPrice->price, 0, ',', '.') . 'đ';
                            } elseif ($defaultPrice->price_type === 'range' && $defaultPrice->price_min && $defaultPrice->price_max) {
                                $priceDisplay = number_format($defaultPrice->price_min, 0, ',', '.') . 'đ+';
                            }
                        }
                    @endphp

                    <div
                        class="group bg-white rounded-[2rem] p-3 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_50px_-10px_rgba(244,63,94,0.15)] transition-all duration-500 border border-gray-50">
                        <div class="relative overflow-hidden rounded-[1.8rem] aspect-square">
                            <img src="{{ $imageUrl }}" alt="{{ $nail->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

                            <div
                                class="absolute bottom-4 left-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                <div
                                    class="bg-white/80 backdrop-blur-md p-3 rounded-2xl flex justify-between items-center shadow-lg">
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-tighter">Giá từ</span>
                                    <span class="text-lg font-bold text-pink-600">{{ $priceDisplay }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 group-hover:text-pink-600 transition-colors">
                                {{ $nail->name }}
                            </h3>

                            <button
                                class="w-full py-4 bg-gradient-to-r from-pink-50 to-rose-50 hover:from-pink-500 hover:to-rose-400 text-pink-600 hover:text-white rounded-2xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-sm">
                                <span>ĐẶT LỊCH NGAY</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="bg-gray-50 inline-block p-10 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-400">Bộ sưu tập đang được chuẩn bị...</p>
            </div>
        @endif
    </div>
</section>
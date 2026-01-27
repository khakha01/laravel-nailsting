@extends('user.layout.layout')

@section('title', 'Bộ Sưu Tập Nail')

@section('content')
    <section id="collection-page" class="pt-32 pb-20 bg-white relative overflow-hidden min-h-screen">
        {{-- Decorative element --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-pink-50/50 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-50/30 rounded-full blur-3xl -ml-40 -mb-40"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-pink-500 font-bold tracking-[0.2em] text-xs uppercase mb-3 block">Mới nhất 2026</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Bộ Sưu Tập <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-rose-400">Nail
                        Nghệ Thuật</span>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-base leading-relaxed">
                    Khám phá kho tàng các mẫu nail độc đáo, từ phong cách tối giản thanh lịch đến những thiết kế cầu kỳ
                    đẳng cấp.
                </p>
            </div>

            @if($nails && $nails->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-12">
                    @foreach($nails as $nail)
                        @php
                            $primaryImage = $nail->getPrimaryImage();
                            $imageUrl = get_media_url($nail->primary_image_url);
                            $defaultPrice = $nail->getDefaultPrice() ?: ($nail->prices->count() > 0 ? $nail->prices->first() : null);

                            $priceDisplay = 'Liên hệ';
                            $priceValue = 0;
                            if ($defaultPrice) {
                                if ($defaultPrice->price_type === 'fixed' && $defaultPrice->price) {
                                    $priceDisplay = number_format($defaultPrice->price, 0, ',', '.') . 'đ';
                                    $priceValue = $defaultPrice->price;
                                } elseif ($defaultPrice->price_type === 'range' && $defaultPrice->price_min && $defaultPrice->price_max) {
                                    $priceDisplay = number_format($defaultPrice->price_min, 0, ',', '.') . 'đ+';
                                    $priceValue = $defaultPrice->price_min;
                                }
                            }
                        @endphp

                        <div
                            class="group bg-white rounded-[2rem] p-3 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_50px_-10px_rgba(244,63,94,0.15)] transition-all duration-500 border border-gray-50 flex flex-col h-full">
                            <div class="relative overflow-hidden rounded-[1.8rem] aspect-square mb-4">
                                <img src="{{ $imageUrl }}" alt="{{ $nail->name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

                                <div
                                    class="absolute bottom-4 left-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                    <div
                                        class="bg-white/90 backdrop-blur-md p-3 rounded-2xl flex justify-between items-center shadow-lg">
                                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-tighter">Giá từ</span>
                                        <span class="text-lg font-bold text-pink-600">{{ $priceDisplay }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 flex-grow flex flex-col">
                                <h3
                                    class="text-lg font-bold text-gray-800 mb-2 group-hover:text-pink-600 transition-colors line-clamp-1">
                                    {{ $nail->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $nail->description }}</p>

                                <div class="mt-auto">
                                    <button
                                        onclick="openNailBookingModal({{ $nail->id }}, '{{ addslashes($nail->name) }}', '{{ $imageUrl }}', {{ $priceValue }}, '{{ $priceDisplay }}')"
                                        class="w-full py-3.5 bg-gradient-to-r from-pink-50 to-rose-50 hover:from-pink-500 hover:to-rose-400 text-pink-600 hover:text-white rounded-2xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 group/btn shadow-sm">
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
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center mt-8">
                    {{ $nails->links() }}
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
                    <p class="text-gray-400 text-lg">Bộ sưu tập đang được cập nhật...</p>
                    <a href="{{ route('home') }}"
                        class="inline-block mt-6 px-6 py-3 bg-pink-500 text-white font-semibold rounded-xl hover:bg-pink-600 transition-colors">
                        Về trang chủ
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Nail Booking Modal --}}
    @include('user.components.nail-booking-modal')
@endsection
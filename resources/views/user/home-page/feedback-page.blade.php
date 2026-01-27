@if($feedbackBanner && $feedbackBanner->is_active)
    <section class="py-14 bg-[#FCF8F7] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Banner Title Section --}}
            <div class="relative text-center mb-10">
                <h2 class="text-3xl md:text-5xl font-serif text-slate-900 leading-tight">
                    {{ $feedbackBanner->title ?? 'Cảm nhận của khách hàng về' }} <br>
                    <span class="relative inline-block mt-2">
                        <span class="relative z-10 italic font-light text-pink-500">
                            {{ $feedbackBanner->description_1 ?? 'Nailstinggg' }}
                        </span>
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-pink-100 -z-0" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="currentColor" stroke-width="4" fill="transparent" />
                        </svg>
                    </span>
                </h2>

                <div class="mt-8 flex flex-col items-center justify-center space-y-3">
                    @if($feedbackBanner->items && $feedbackBanner->items->count() > 0)
                        <div class="flex -space-x-3">
                            @foreach($feedbackBanner->items->take(3) as $index => $item)
                                @if($item->is_active)
                                    <img class="w-12 h-12 rounded-full border-4 border-white shadow-sm object-cover"
                                        src="{{ get_media_url($item->media) }}" alt="{{ $item->title }}">
                                @endif
                            @endforeach
                            <div
                                class="w-12 h-12 rounded-full border-4 border-white bg-gradient-to-tr from-pink-400 to-rose-300 flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                                +2k
                            </div>
                        </div>
                    @endif
                    <p class="text-sm text-slate-500 font-medium">{{ $feedbackBanner->description_2 }}</p>
                </div>
            </div>

            {{-- Swiper Slider for Banner Items --}}
            @if($feedbackBanner->items && $feedbackBanner->items->count() > 0)
                <div class="relative">
                    <div class="swiper feedbackSwiper">
                        <div class="swiper-wrapper">
                            @foreach($feedbackBanner->items as $index => $item)
                                @if($item->is_active)
                                    <div class="swiper-slide !h-auto">
                                        <div class="group relative h-full">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-b from-pink-100/50 to-transparent rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                            </div>
                                            <div
                                                class="relative bg-white/70 backdrop-blur-md p-10 rounded-[3rem] border border-white shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_30px_60px_rgba(255,182,193,0.25)] transition-all duration-500 hover:-translate-y-3 h-full flex flex-col">

                                                <div class="mb-8">
                                                    <svg class="w-10 h-10 text-pink-200 group-hover:text-pink-400 transition-colors duration-500"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M14.017 21L14.017 18C14.017 16.8954 14.9125 16 16.0171 16H19.0171C20.1217 16 21.0171 15.1046 21.0171 14V9C21.0171 7.89543 20.1217 7 19.0171 7H15.0171C13.9125 7 13.0171 7.89543 13.0171 9V15M5.0171 21L5.0171 18C5.0171 16.8954 5.91254 16 7.0171 16H10.0171C11.1217 16 12.0171 15.1046 12.0171 14V9C12.0171 7.89543 11.1217 7 10.0171 7H6.0171C4.91254 7 4.0171 7.89543 4.0171 9V15">
                                                        </path>
                                                    </svg>
                                                </div>

                                                <p class="text-slate-600 leading-[1.8] text-lg mb-4 font-light italic flex-grow">
                                                    "{{ $item->description_1 ?? 'Trải nghiệm tuyệt vời tại Nailstinggg' }}"
                                                </p>

                                                <div class="flex items-center gap-4">
                                                    <img src="{{ get_media_url($item->media) }}" alt="{{ $item->title }}"
                                                        class="w-14 h-14 rounded-full object-cover ring-4 ring-pink-50">
                                                    <div>
                                                        <h4 class="text-base font-bold text-slate-800 tracking-wide">
                                                            {{ $item->title ?? 'Khách hàng' }}
                                                        </h4>
                                                        @if($item->description_2)
                                                            <div class="flex items-center gap-1 mt-1">
                                                                <span
                                                                    class="text-[10px] text-pink-500 font-bold uppercase tracking-tighter">
                                                                    {{ $item->description_2 }}
                                                                </span>
                                                                @if($item->description_3)
                                                                    <div class="flex text-amber-400 ml-2">
                                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                            </path>
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Navigation Buttons --}}
                        <div
                            class="swiper-button-next !w-12 !h-12 !bg-white !rounded-full !shadow-lg after:!text-pink-500 after:!text-xl after:!font-bold hover:!bg-pink-50 transition-colors">
                        </div>
                        <div
                            class="swiper-button-prev !w-12 !h-12 !bg-white !rounded-full !shadow-lg after:!text-pink-500 after:!text-xl after:!font-bold hover:!bg-pink-50 transition-colors">
                        </div>

                        {{-- Pagination --}}
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- Swiper Initialization Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.feedbackSwiper', {
                slidesPerView: 1,
                spaceBetween: 40,
                autoHeight: false,
                observer: true,
                observeParents: true,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                },
            });
        });
    </script>
@endif
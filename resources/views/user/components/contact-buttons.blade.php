@if($settings)
    <div class="fixed bottom-6 right-6 flex flex-col gap-10 z-[1000000]" id="contact-buttons">
        {{-- Phone Button --}}
        @if($settings->phone1)
            <a href="tel:{{ $settings->phone1 }}"
                class="contact-btn btn-phone text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:scale-110 group relative"
                title="Gọi điện">
                <div class="ripple ripple-phone"></div>
                <div class="ripple ripple-phone delay-1000"></div>
                <i class="fa-solid fa-phone text-xl md:text-2xl z-10"></i>
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    {{ $settings->phone1 }}
                </span>
            </a>
        @endif

        {{-- Zalo Button --}}
        @if($settings->link_zalo)
            <a href="{{ $settings->link_zalo }}" target="_blank"
                class="contact-btn btn-zalo text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:scale-110 group relative"
                title="Zalo">
                <div class="ripple ripple-zalo"></div>
                <div class="ripple ripple-zalo delay-1000"></div>
                <img src="{{ asset('img/icon-zalo.png') }}" class="w-8 h-8 md:w-10 md:h-10 object-contain z-10" alt="Zalo">
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    Chat Zalo
                </span>
            </a>
        @endif

        {{-- Instagram Button --}}
        @if($settings->link_instagram)
            <a href="{{ $settings->link_instagram }}" target="_blank"
                class="contact-btn btn-instagram text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:scale-110 group relative"
                title="Instagram">
                <div class="ripple ripple-instagram"></div>
                <div class="ripple ripple-instagram delay-1000"></div>
                <i class="fab fa-instagram text-xl md:text-2xl z-10"></i>
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    Instagram
                </span>
            </a>
        @endif

        {{-- Facebook Button --}}
        @if($settings->link_fb)
            <a href="{{ $settings->link_fb }}" target="_blank"
                class="contact-btn btn-facebook text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:scale-110 group relative"
                title="Facebook">
                <div class="ripple ripple-facebook"></div>
                <div class="ripple ripple-facebook delay-1000"></div>
                <i class="fab fa-facebook-f text-xl md:text-2xl z-10"></i>
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    Facebook
                </span>
            </a>
        @endif

        {{-- TikTok Button --}}
        @if($settings->link_tiktok)
            <a href="{{ $settings->link_tiktok }}" target="_blank"
                class="contact-btn btn-tiktok text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:scale-110 group relative"
                title="TikTok">
                <div class="ripple ripple-tiktok"></div>
                <div class="ripple ripple-tiktok delay-1000"></div>
                <i class="fab fa-tiktok text-xl md:text-2xl z-10"></i>
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    TikTok
                </span>
            </a>
        @endif
    </div>

@endif
@if($settings)
    <div class="fixed bottom-6 right-6 flex flex-col gap-10 z-[9999]" id="contact-buttons">
        {{-- Phone Button --}}
        @if($settings->phone1)
            <a href="tel:{{ $settings->phone1 }}"
                class="contact-btn bg-green-500 text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-all hover:scale-110 group relative"
                title="Gọi điện">
                <div class="ripple bg-green-500"></div>
                <div class="ripple bg-green-500 delay-1000"></div>
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
                class="contact-btn bg-blue-500 text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-600 transition-all hover:scale-110 group relative"
                title="Zalo">
                <div class="ripple bg-blue-500"></div>
                <div class="ripple bg-blue-500 delay-1000"></div>
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
                class="contact-btn bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110 group relative"
                title="Instagram">
                <div class="ripple bg-[#ee2a7b]"></div>
                <div class="ripple bg-[#ee2a7b] delay-1000"></div>
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
                class="contact-btn bg-blue-600 text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-all hover:scale-110 group relative"
                title="Facebook">
                <div class="ripple bg-blue-600"></div>
                <div class="ripple bg-blue-600 delay-1000"></div>
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
                class="contact-btn bg-black text-white w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-gray-900 transition-all hover:scale-110 group relative"
                title="TikTok">
                <div class="ripple bg-gray-600"></div>
                <div class="ripple bg-gray-600 delay-1000"></div>
                <i class="fab fa-tiktok text-xl md:text-2xl z-10"></i>
                <span
                    class="absolute right-full mr-3 px-3 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none transition-opacity z-20">
                    TikTok
                </span>
            </a>
        @endif
    </div>

    <style>
        .contact-btn {
            animation: slideInRight 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) both;
        }

        .ripple {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            z-index: 1;
            animation: ripple-pulse 2.5s infinite;
            opacity: 0;
            pointer-events: none;
        }

        .delay-1000 {
            animation-delay: 1.25s;
        }

        @keyframes ripple-pulse {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.8);
                opacity: 0;
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(100px) scale(0.3);
            }

            70% {
                transform: translateX(-10px) scale(1.1);
            }

            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        #contact-buttons a:nth-child(1) {
            animation-delay: 0.1s;
        }

        #contact-buttons a:nth-child(2) {
            animation-delay: 0.2s;
        }

        #contact-buttons a:nth-child(3) {
            animation-delay: 0.3s;
        }

        #contact-buttons a:nth-child(4) {
            animation-delay: 0.4s;
        }

        #contact-buttons a:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>
@endif
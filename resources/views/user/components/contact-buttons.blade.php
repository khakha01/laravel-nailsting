@if($settings)
    <div class="fixed bottom-6 right-6 flex flex-col gap-10 z-[9999]" id="contact-buttons">
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

    <style>
        .contact-btn {
            transition: all 0.3s ease;
            animation: slideInRight 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) both;
        }

        /* Background Colors */
        .btn-phone {
            background-color: #22c55e;
        }

        .btn-phone:hover {
            background-color: #16a34a;
        }

        .btn-zalo {
            background-color: #3b82f6;
        }

        .btn-zalo:hover {
            background-color: #2563eb;
        }

        .btn-instagram {
            background: linear-gradient(45deg, #f9ce34 10%, #ee2a7b 50%, #6228d7 90%);
        }

        .btn-facebook {
            background-color: #2563eb;
        }

        .btn-facebook:hover {
            background-color: #1d4ed8;
        }

        .btn-tiktok {
            background-color: #000000;
        }

        .btn-tiktok:hover {
            background-color: #1a1a1a;
        }

        /* Ripple Colors */
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

        .ripple-phone {
            background-color: #22c55e;
        }

        .ripple-zalo {
            background-color: #3b82f6;
        }

        .ripple-instagram {
            background-color: #ee2a7b;
        }

        .ripple-facebook {
            background-color: #2563eb;
        }

        .ripple-tiktok {
            background-color: #666666;
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
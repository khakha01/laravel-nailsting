<footer class="bg-gradient-to-b from-white to-pink-50/30 text-slate-700 border-t border-pink-100">
    <div class="max-w-6xl mx-auto px-6 pt-14">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 text-center md:text-left">
            <div class="flex items-center md:items-start flex-col">
                @if($settings && $settings->logo_id)
                    <img src="{{ get_media_url($settings->logo_id) }}"
                        alt="{{ $settings->website_name ?? 'Nails-tingggg' }}" class="h-14">
                @else
                    <img src="{{ asset('img/logo.png') }}" alt="Nails-tingggg" class="h-14">
                @endif
                <p class="mt-2 text-sm text-slate-500">Nghệ thuật làm móng • Tinh tế • Cá nhân hoá</p>
                @if($settings && $settings->address)
                    <p class="mt-2 text-sm text-slate-500 flex items-start gap-2">
                        <i class="fas fa-map-marker-alt mt-1 text-pink-400"></i>
                        <span>{{ $settings->address }}</span>
                    </p>
                @endif
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 mb-4">Liên hệ</h4>
                <p class="text-sm">
                    @if($settings && $settings->phone1)
                        <a href="tel:{{ $settings->phone1 }}" class="hover:text-[#ff0052] transition">📞
                            {{ $settings->phone1 }}</a>
                    @else
                        <a href="tel:0900000000" class="hover:text-[#ff0052] transition">📞 0900 000 000</a>
                    @endif
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 mb-4">Theo dõi</h4>
                <div class="flex justify-center md:justify-start gap-6 md:gap-10 mb-6">
                    @if($settings && $settings->link_instagram)
                        <a href="{{ $settings->link_instagram }}" class="group" aria-label="Instagram" target="_blank">
                            <i
                                class="fab fa-instagram text-xl md:text-xl text-slate-600 group-hover:text-[#ff0052] transition-colors"></i>
                        </a>
                    @endif

                    @if($settings && $settings->link_fb)
                        <a href="{{ $settings->link_fb }}" class="group" aria-label="Facebook" target="_blank">
                            <i
                                class="fab fa-facebook-f text-xl md:text-xl text-slate-600 group-hover:text-[#ff0052] transition-colors"></i>
                        </a>
                    @endif

                    @if($settings && $settings->link_tiktok)
                        <a href="{{ $settings->link_tiktok }}" class="group" aria-label="TikTok" target="_blank">
                            <i
                                class="fab fa-tiktok text-xl md:text-xl text-slate-600 group-hover:text-[#ff0052] transition-colors"></i>
                        </a>
                    @endif

                    @if($settings && $settings->link_zalo)
                        <a href="{{ $settings->link_zalo }}" class="group" aria-label="Zalo" target="_blank">
                            <i
                                class="fa-solid fa-comment-dots text-xl md:text-xl text-slate-600 group-hover:text-[#ff0052] transition-colors"></i>
                        </a>
                    @endif
                </div>
                <a href="#booking" class="inline-block rounded-full bg-gradient-to-r from-pink-500 to-rose-500 text-white px-8 py-3 text-sm font-semibold
                  hover:bg-[#ff0052] transition shadow-sm">
                    Đặt lịch ngay →
                </a>

            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-slate-600 mb-4">Tiktok</h4>
                <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@tinting_04" data-unique-id="tinting_04"
                    data-embed-type="creator" style="max-width: 780px; min-width: 288px;">
                    <section> <a target="_blank"
                            href="https://www.tiktok.com/@tinting_04?refer=creator_embed">@tinting_04</a> </section>
                </blockquote>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 text-center text-xs text-slate-400 pb-8">
            © 2026 NailsTingggg. All rights reserved.
        </div>
    </div>
</footer>
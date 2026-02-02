<section class="pb-14 bg-[#FCF8F7] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="relative">
            <h2 class="text-3xl md:text-5xl font-serif text-slate-900 leading-tight text-center">
                {{ $blogCategory ? $blogCategory->name : 'Tin tức' }} <br>
                <span class="relative inline-block mt-2">
                    <span class="relative z-10 italic font-light text-pink-500">
                        Nailstinggg
                    </span>
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-pink-100 -z-0" viewBox="0 0 100 10"
                        preserveAspectRatio="none">
                        <path d="M0 5 Q 25 0, 50 5 T 100 5" stroke="currentColor" stroke-width="4" fill="transparent" />
                    </svg>
                </span>
            </h2>

            <div class="swiper swiper-home-blog mt-10">
                <div class="swiper-wrapper">
                    @forelse($homeBlogs as $blog)
                        <div class="swiper-slide h-full">
                            <div
                                class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 h-full flex flex-col">
                                <div class="relative overflow-hidden aspect-[4/3]">
                                    <img src="{{ get_media_url($blog->media) }}"
                                        class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500"
                                        alt="{{ $blog->title }}">
                                    @if($blog->category)
                                        <span
                                            class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-pink-600 uppercase tracking-wider">
                                            {{ $blog->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-6 flex-grow flex flex-col">
                                    <p class="text-gray-400 text-sm mb-2">
                                        {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : $blog->created_at->format('d/m/Y') }}
                                    </p>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 group-hover:text-pink-500 transition-colors duration-300 leading-tight mb-3">
                                        <a href="{{ route('user.posts.detail', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                        {{ $blog->excerpt ?: Str::limit(strip_tags($blog->content), 50) }}
                                    </p>
                                    <div class="mt-auto">
                                        <a href="{{ route('user.posts.detail', $blog->slug) }}"
                                            class="inline-flex items-center text-pink-500 font-medium hover:gap-2 transition-all">
                                            Đọc thêm <span class="ml-1">→</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide w-full py-20 text-center">
                            <p class="text-gray-500 italic">Chưa có bài viết nào trong danh mục này.</p>
                        </div>
                    @endforelse
                </div>
                <div
                    class="swiper-button-next !w-12 !h-12 !bg-white !rounded-full !shadow-lg after:!text-pink-500 after:!text-xl after:!font-bold hover:!bg-pink-50 transition-colors">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div
                    class="swiper-button-prev !w-12 !h-12 !bg-white !rounded-full !shadow-lg after:!text-pink-500 after:!text-xl after:!font-bold hover:!bg-pink-50 transition-colors">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <div class="swiper-pagination !-bottom-10"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper_home_blog = new Swiper(".swiper-home-blog", {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
            });
        });
    </script>
</section>
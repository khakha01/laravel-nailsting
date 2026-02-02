@extends('user.layout.layout')
@section('title', 'Tin tức - Nails Ting')
@section('content')
    <section class="py-20 bg-[#FCF8F7] min-h-screen pt-32">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="text-3xl md:text-5xl font-serif text-slate-900 leading-tight">
                    Tin tức & Xu hướng <br>
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
                <p class="text-slate-600 max-w-2xl mx-auto mt-6">Cập nhật những xu hướng làm đẹp mới nhất, mẹo chăm sóc móng
                    và các tin tức từ Nails Ting.</p>
            </div>

            <!-- Categories horizontal scroll/list -->
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <a href="{{ route('user.posts.index') }}"
                    class="px-6 py-2 rounded-full border {{ !isset($currentCategory) ? 'bg-[#ff0052] border-[#ff0052] text-white shadow-lg shadow-[#ff0052]/20' : 'bg-white border-slate-200 text-slate-600 hover:border-[#ff0052] hover:text-[#ff0052]' }} transition-all duration-300 font-medium">
                    Tất cả
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('user.posts.detail', $category->slug) }}"
                        class="px-6 py-2 rounded-full border {{ isset($currentCategory) && $currentCategory->id == $category->id ? 'bg-[#ff0052] border-[#ff0052] text-white shadow-lg shadow-[#ff0052]/20' : 'bg-white border-slate-200 text-slate-600 hover:border-[#ff0052] hover:text-[#ff0052]' }} transition-all duration-300 font-medium">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($posts as $post)
                    <div
                        class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-100 flex flex-col h-full">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            <img src="{{ get_media_url($post->media) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 backdrop-blur-md text-[#ff0052] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                                    {{ $post->category?->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div
                                class="flex items-center gap-4 mb-4 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-[#ff0052]"></i>
                                    {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3
                                class="text-xl font-bold text-slate-800 mb-4 line-clamp-2 group-hover:text-[#ff0052] transition-colors leading-snug">
                                <a href="{{ route('posts.detail', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-slate-500 line-clamp-3 mb-8 text-sm leading-relaxed">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('posts.detail', $post->slug) }}"
                                    class="inline-flex items-center gap-2 text-[#ff0052] font-bold text-sm tracking-wide group/btn">
                                    <span
                                        class="border-b-2 border-transparent group-hover/btn:border-[#ff0052] transition-all">ĐỌC
                                        CHI TIẾT</span>
                                    <i
                                        class="fa-solid fa-arrow-right-long transform group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                        <div class="text-6xl mb-6 text-slate-100">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                        <p class="text-slate-400 font-medium">Chưa có bài viết nào trong danh mục này.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        .font-serif {
            font-family: 'Playfair Display', serif;
        }
    </style>
@endsection
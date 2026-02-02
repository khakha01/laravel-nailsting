@extends('user.layout.layout')
@section('title', $post->title . ' - Nails Ting')
@section('content')
    <article class="bg-[#FCF8F7] min-h-screen pt-32 font-['Playfair_Display',_serif]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex mb-8 text-sm font-medium text-slate-400" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-[#ff0052] transition-colors">Trang chủ</a></li>
                    <li class="flex items-center space-x-2 text-[10px]">
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li><a href="{{ route('user.posts.index') }}" class="hover:text-[#ff0052] transition-colors">Tin tức</a>
                    </li>
                    <li class="flex items-center space-x-2 text-[10px]">
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li><a href="{{ route('user.posts.detail', $post->category->slug) }}"
                            class="hover:text-[#ff0052] transition-colors">{{ $post->category->name }}</a></li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-5xl font-serif text-slate-900 mb-8 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 pb-8 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-white border-2 border-pink-100 p-0.5">
                        <div class="w-full h-full rounded-full overflow-hidden">
                            @if($post->author->media_id)
                                <img src="{{ get_media_url($post->author->media) }}" alt="{{ $post->author->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[#ff0052] bg-pink-50">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-slate-900 font-bold leading-none mb-1">{{ $post->author->name }}</p>
                        <p class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">Tác giả</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-slate-500 text-sm">
                    <i class="fa-regular fa-calendar text-[#ff0052]"></i>
                    <span
                        class="font-medium">{{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
                </div>

                <div class="flex items-center gap-2 text-slate-500 text-sm">
                    <i class="fa-solid fa-folder-open text-[#ff0052]"></i>
                    <span class="font-medium">{{ $post->category->name }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mt-8">
            <div
                class="aspect-video rounded-[2.5rem] overflow-hidden shadow-2xl shadow-pink-900/10 border border-white p-2 bg-white">
                <img src="{{ get_media_url($post->media) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover rounded-[2rem]">
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mt-12">
            <div class="max-w-3xl mx-auto">
                {{-- Toàn bộ CSS cũ được chuyển thành các class lồng nhau của Tailwind bên dưới --}}
                <div
                    class="post-content
                                prose prose-pink max-w-none 
                                text-slate-700 leading-relaxed text-lg

                                [&_h2]:font-serif [&_h2]:text-[2rem] [&_h2]:font-bold [&_h2]:mt-12 [&_h2]:mb-6 [&_h2]:text-slate-900
                                [&_h3]:font-serif [&_h3]:text-[1.5rem] [&_h3]:font-bold [&_h3]:mt-8 [&_h3]:mb-4 [&_h3]:text-slate-900

                                [&_p]:mb-7 [&_p]:text-slate-600 [&_p]:leading-[1.8]

                                [&_ul]:list-none [&_ul]:mb-7
                                [&_ul_li]:relative [&_ul_li]:pl-6 [&_ul_li]:mb-3 [&_ul_li]:text-slate-600
                                [&_ul_li]:before:content-['•'] [&_ul_li]:before:text-[#ff0052] [&_ul_li]:before:font-bold [&_ul_li]:before:absolute [&_ul_li]:before:left-0

                                [&_ol]:list-decimal [&_ol]:ml-6 [&_ol]:mb-7
                                [&_ol_li]:mb-3 [&_ol_li]:text-slate-600

                                [&_img]:rounded-[2rem] [&_img]:my-12 [&_img]:mx-auto [&_img]:border-4 [&_img]:border-white [&_img]:shadow-lg

                                [&_blockquote]:border-l-4 [&_blockquote]:border-[#ff0052] [&_blockquote]:bg-white [&_blockquote]:py-6 [&_blockquote]:px-8 [&_blockquote]:italic [&_blockquote]:my-12 [&_blockquote]:rounded-r-2xl [&_blockquote]:shadow-sm [&_blockquote]:text-slate-500 [&_blockquote]:text-xl">

                    {!! $post->content !!}
                </div>

                @if($post->tags->count() > 0)
                    <div class="mt-10 py-10 border-t border-slate-200">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-slate-900 font-bold mr-2 text-sm uppercase tracking-wider">Từ khóa:</span>
                            @foreach($post->tags as $tag)
                                <span
                                    class="px-4 py-1.5 bg-white border border-slate-100 text-slate-500 rounded-full text-xs font-bold hover:border-[#ff0052] hover:text-[#ff0052] transition-all cursor-default shadow-sm italic">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($relatedPosts->count() > 0)
            <section class="bg-white py-24 border-t border-slate-100 mt-20">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="flex items-center justify-between mb-16">
                        <h2 class="text-3xl font-serif text-slate-900 capitalize">Bài viết liên quan</h2>
                        <a href="{{ route('user.posts.detail', $post->category->slug) }}"
                            class="text-[#ff0052] font-bold text-sm tracking-widest uppercase flex items-center gap-2 group">
                            Xem tất cả
                            <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        @foreach($relatedPosts as $rPost)
                            <div class="group">
                                <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-6 border border-slate-100 shadow-sm">
                                    <img src="{{ get_media_url($rPost->media) }}" alt="{{ $rPost->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                </div>
                                <p class="text-[#ff0052] text-[10px] font-bold uppercase tracking-widest mb-3">
                                    {{ $rPost->category->name }}
                                </p>
                                <h3
                                    class="text-lg font-bold text-slate-800 group-hover:text-[#ff0052] transition-colors line-clamp-2 leading-snug font-serif">
                                    <a href="{{ route('user.posts.detail', $rPost->slug) }}">{{ $rPost->title }}</a>
                                </h3>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </article>
@endsection
@extends('user.layout.layout')

@section('title', $post->title . ' - Nails Ting')

@section('content')
    <article class="bg-[#FCF8F7] min-h-screen pt-32">
        <!-- Hero Header -->
        <div class="container mx-auto px-4 mb-16">
            <div class="max-w-4xl mx-auto">
                <nav class="flex mb-8 text-sm font-medium text-slate-400" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('home') }}" class="hover:text-[#ff0052] transition-colors">Trang chủ</a></li>
                        <li class="flex items-center space-x-2 text-[10px]">
                            <i class="fa-solid fa-chevron-right"></i>
                        </li>
                        <li><a href="{{ route('user.posts.index') }}" class="hover:text-[#ff0052] transition-colors">Tin
                                tức</a>
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
        </div>

        <!-- Featured Image -->
        <div class="container mx-auto px-4 mb-20">
            <div class="max-w-5xl mx-auto">
                <div
                    class="aspect-video rounded-[2.5rem] overflow-hidden shadow-2xl shadow-pink-900/10 border border-white p-2 bg-white">
                    <img src="{{ get_media_url($post->media) }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover rounded-[2rem]">
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-4 pb-24">
            <div class="max-w-3xl mx-auto">
                <div class="prose prose-pink max-w-none text-slate-700 leading-relaxed text-lg post-content">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mt-20 pt-10 border-t border-slate-200">
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

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <section class="bg-white py-24 border-t border-slate-100 mt-10">
                <div class="container mx-auto px-4">
                    <div class="max-w-6xl mx-auto">
                        <div class="flex items-center justify-between mb-16">
                            <h2 class="text-3xl font-serif text-slate-900 capitalize">Bài viết liên quan</h2>
                            <a href="{{ route('posts.detail', $post->category->slug) }}"
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
                                        class="text-lg font-bold text-slate-800 group-hover:text-[#ff0052] transition-colors line-clamp-2 leading-snug">
                                        <a href="{{ route('posts.detail', $rPost->slug) }}">{{ $rPost->title }}</a>
                                    </h3>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </article>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .post-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: #0f172a;
        }

        .post-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .post-content p {
            margin-bottom: 1.75rem;
            color: #475569;
            line-height: 1.8;
        }

        .post-content ul {
            list-style-type: none;
            margin-bottom: 1.75rem;
        }

        .post-content ul li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
            color: #475569;
        }

        .post-content ul li::before {
            content: "•";
            color: #ff0052;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .post-content ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .post-content li {
            margin-bottom: 0.75rem;
            color: #475569;
        }

        .post-content img {
            border-radius: 2rem;
            margin: 3rem auto;
            border: 4px solid white;
            shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        .post-content blockquote {
            border-left: 4px solid #ff0052;
            padding: 1.5rem 2rem;
            font-style: italic;
            margin: 3rem 0;
            background: white;
            border-radius: 0 1rem 1rem 0;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
            color: #64748b;
            font-size: 1.25rem;
        }
    </style>
@endsection
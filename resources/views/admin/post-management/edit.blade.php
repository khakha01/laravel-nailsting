@extends('admin.layouts.layout')

@section('title', 'Chỉnh sửa bài viết')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('posts.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Chỉnh Sửa Bài Viết</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Post ID: #{{ $post->id }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('posts.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-post-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Cập nhật bài viết
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">Có lỗi xảy ra khi cập nhật bài viết:</h3>
                        <ul class="mt-2 text-sm list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="main-post-form" action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Main Content Column --}}
                    <div class="lg:col-span-8 space-y-8">

                        {{-- General Info Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Nội dung bài viết
                                </h3>
                            </div>

                            <div class="p-6 space-y-6">
                                {{-- Title --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Tiêu đề bài viết <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required
                                        placeholder="Nhập tiêu đề hấp dẫn..."
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                </div>

                                {{-- Slug --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Slug (Đường dẫn) <span class="text-red-500">*</span></label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}"
                                        placeholder="tu-dong-tao-tu-tieu-de"
                                        class="w-full rounded-xl border border-gray-300 bg-slate-50 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900">
                                </div>

                                {{-- Excerpt --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Mô tả ngắn (Excerpt)</label>
                                    <textarea name="excerpt" rows="3" placeholder="Tóm tắt nội dung bài viết..."
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('excerpt', $post->excerpt) }}</textarea>
                                </div>

                                {{-- Content (Editor) --}}
                                <div class="post-content-editor">
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Nội dung chi tiết <span class="text-red-500">*</span></label>
                                    <div class="prose max-w-none">
                                        <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Column --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Action Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Xuất bản
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Trạng thái</label>
                                    <select name="status" class="w-full rounded-xl border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="draft" @selected(old('status', $post->status) === 'draft')>Bản nháp</option>
                                        <option value="published" @selected(old('status', $post->status) === 'published')>Xuất bản ngay</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured', $post->is_featured))
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="is_featured" class="text-sm font-medium text-slate-700">Bài viết nổi bật</label>
                                </div>

                                <hr class="border-slate-100">

                                <button type="submit" class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-200">
                                    Cập nhật bài viết
                                </button>
                                
                                <p class="text-[10px] text-slate-400 text-center">Lần cuối cập nhật: {{ $post->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        {{-- Category & Tags Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Phân loại
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Danh mục</label>
                                    <select name="post_category_id" class="w-full rounded-xl border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tags</label>
                                    <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border border-slate-100 rounded-lg bg-slate-50/50">
                                        @php $currentTagIds = $post->tags->pluck('id')->toArray(); @endphp
                                        @foreach($tags as $tag)
                                            <label class="flex items-center gap-2 cursor-pointer p-1">
                                                <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tag_ids', $currentTagIds)))
                                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <span class="text-xs text-slate-700">{{ $tag->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @if($tags->isEmpty())
                                        <p class="text-xs text-slate-400 italic">Chưa có tag nào. <a href="{{ route('post-tags.index') }}" class="text-blue-500 hover:underline">Tạo mới</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Featured Image Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Ảnh đại diện
                            </h3>

                            <div class="space-y-4">
                                <div id="media-preview" class="relative group aspect-video rounded-xl bg-white border-2 border-solid border-slate-200 flex items-center justify-center overflow-hidden cursor-pointer" onclick="openMediaModal()">
                                    <div class="text-center group-hover:scale-110 transition-transform duration-200 {{ $post->media_id ? 'hidden' : '' }}" id="media-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="text-xs font-bold text-slate-400 mt-2 block">CHỌN ẢNH</span>
                                    </div>
                                    <img id="preview-img" src="{{ $post->media_id ? get_media_url($post->media?->url) : '' }}" class="{{ $post->media_id ? '' : 'hidden' }} w-full h-full object-cover">
                                    <button type="button" id="remove-img" class="{{ $post->media_id ? '' : 'hidden' }} absolute top-2 right-2 p-1 bg-white/90 rounded-full text-red-500 shadow-sm hover:bg-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="media_id" id="media_id" value="{{ old('media_id', $post->media_id) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Media Manager Modal --}}
    @include('admin.components.media-manager-modal')

    @push('scripts')
        <script src="{{ asset('js/slug.js') }}"></script>
        {{-- CKEditor 5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <script src="{{ asset('js/media-manager.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize CKEditor
                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo'],
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                            ]
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });

                // Initialize Slug auto-generation
                const titleInput = document.getElementById('title');
                const slugInput = document.getElementById('slug');
                if (titleInput && slugInput) {
                    titleInput.addEventListener('input', function() {
                        if (this.value) {
                             slugInput.value = changeToSlug(this.value);
                        }
                    });
                }

                // Media Manager Integration
                const mediaManager = new MediaManager({
                    urls: {
                        index: '{{ route('media.index') }}',
                        store: '{{ route('media.store') }}',
                        folderStore: '{{ route('media.folders.store') }}',
                        folderDelete: '{{ route('media.folders.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                        mediaDelete: '{{ route('media.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                        mediaBulkDelete: '{{ route('media.bulk-delete') }}',
                    },
                    csrfToken: '{{ csrf_token() }}'
                });

                mediaManager.confirmSelection = function() {
                    const selected = Array.from(this.state.selectedItemsMap.values());
                    if (selected.length > 0) {
                        const item = selected[0]; 
                        document.getElementById('media_id').value = item.id;
                        document.getElementById('preview-img').src = item.url;
                        document.getElementById('preview-img').classList.remove('hidden');
                        document.getElementById('media-placeholder').classList.add('hidden');
                        document.getElementById('remove-img').classList.remove('hidden');
                        document.getElementById('media-preview').classList.remove('border-dashed');
                        document.getElementById('media-preview').classList.add('border-solid');
                    }
                    this.closeMediaModal();
                }

                window.removeImage = function() {
                    document.getElementById('media_id').value = '';
                    document.getElementById('preview-img').src = '';
                    document.getElementById('preview-img').classList.add('hidden');
                    document.getElementById('media-placeholder').classList.remove('hidden');
                    document.getElementById('remove-img').classList.add('hidden');
                    document.getElementById('media-preview').classList.add('border-dashed');
                    document.getElementById('media-preview').classList.remove('border-solid');
                }

                document.getElementById('remove-img').addEventListener('click', function(e) {
                    e.stopPropagation();
                    removeImage();
                });
            });
        </script>
        
        <style>
            .ck-editor__editable {
                min-height: 400px;
                border-bottom-left-radius: 0.75rem !important;
                border-bottom-right-radius: 0.75rem !important;
            }
            .ck-toolbar {
                border-top-left-radius: 0.75rem !important;
                border-top-right-radius: 0.75rem !important;
                background-color: #f8fafc !important;
            }
        </style>
    @endpush

@endsection

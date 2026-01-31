@extends('admin.layouts.layout')

@section('title', 'Quản lý bài viết')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Header Section --}}
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 sm:truncate sm:tracking-tight">
                            Quản lý Bài Viết
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 font-medium">Lưu trữ và điều phối nội dung Blog chuyên nghiệp.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Button Xóa Nhiều --}}
                        <button type="submit" form="bulk-delete-form" id="bulkDeleteBtn" style="display: none;"
                            class="inline-flex items-center rounded-xl bg-red-50 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-100 transition-all shadow-sm border border-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Xóa <span id="selected-count-badge" class="ml-1.5 bg-red-600 text-white px-2 py-0.5 rounded-full text-[10px]">0</span>
                        </button>

                        <a href="{{ route('posts.create') }}"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Viết bài mới
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            {{-- Alerts --}}
            @if (session('success'))
                <div class="mb-6 flex items-center p-4 text-emerald-800 border-t-4 border-emerald-500 bg-emerald-50 rounded-xl shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3 text-sm font-bold">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
                <form method="GET" action="{{ route('posts.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                        <div class="md:col-span-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Tìm kiếm bài viết</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nhập tiêu đề hoặc slug..."
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Danh mục</label>
                            <select name="post_category_id"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(request('post_category_id') == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Trạng thái</label>
                            <select name="status"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="">Tất cả</option>
                                <option value="draft" @selected(request('status') === 'draft')>Bản nháp</option>
                                <option value="published" @selected(request('status') === 'published')>Công khai</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 flex items-center gap-2">
                            <button type="submit"
                                class="flex-1 inline-flex justify-center items-center gap-2 rounded-xl bg-slate-900 h-11 text-sm font-bold text-white shadow-md hover:bg-slate-800 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Lọc dữ liệu
                            </button>
                            <a href="{{ route('posts.index') }}" 
                                class="inline-flex justify-center items-center rounded-xl bg-white border border-slate-200 h-11 px-4 text-slate-600 hover:bg-slate-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left w-12">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="select-all" class="h-4 w-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Bài viết</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Phân loại</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tác giả</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Trạng thái</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Thời gian</th>
                                <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($posts as $post)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="row-checkbox h-4 w-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" value="{{ $post->id }}">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-12 w-20 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden border border-slate-200 shadow-sm relative group">
                                                @if($post->media_id)
                                                    <img src="{{ get_media_url($post->media?->url) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                @if($post->is_featured)
                                                    <div class="absolute -top-1 -left-1">
                                                        <span class="flex h-4 w-4">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-amber-500 items-center justify-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="max-w-[200px] lg:max-w-md">
                                                <div class="text-sm font-bold text-slate-900 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $post->title }}</div>
                                                <div class="text-[11px] text-slate-400 font-medium flex items-center gap-1.5 mt-0.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101" />
                                                    </svg>
                                                    {{ $post->slug }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg font-bold text-[10px] uppercase border border-indigo-100">
                                            {{ $post->category?->name ?? 'Mặc định' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                        {{ $post->author?->name ?? 'Quản trị viên' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($post->status === 'published')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100 uppercase">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Công khai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-600 border border-slate-200 uppercase">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Bản nháp
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-[11px] text-slate-500 font-medium">
                                        <div class="flex flex-col">
                                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                            <span class="text-slate-400 italic">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('posts.edit', $post->id) }}" 
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                                title="Chỉnh sửa">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                                    title="Xóa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center bg-white">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-bold text-slate-900">Không có bài viết nào</p>
                                            <p class="text-xs text-slate-400 mt-1">Hãy bắt đầu bằng cách tạo bài viết đầu tiên của bạn.</p>
                                            <a href="{{ route('posts.create') }}" class="mt-4 text-blue-600 text-sm font-bold hover:underline">Tạo bài viết ngay</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                        {{ $posts->links() }}
                    </div>
            </div>
        </div>

        {{-- Bulk Action Form --}}
        <form id="bulk-delete-form" action="{{ route('posts.bulk-delete') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountBadge = document.getElementById('selected-count-badge');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateBulkActionState() {
                const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
                const count = checkedBoxes.length;

                // Clear hidden inputs
                bulkDeleteForm.querySelectorAll('input[name="ids[]"]').forEach(i => i.remove());

                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                    selectedCountBadge.textContent = count;
                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        bulkDeleteForm.appendChild(input);
                    });
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkActionState();
            });

            checkboxes.forEach(cb => cb.addEventListener('change', updateBulkActionState));
        });
    </script>
    @endpush

@endsection

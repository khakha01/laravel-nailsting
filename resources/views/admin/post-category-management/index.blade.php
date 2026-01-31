@extends('admin.layouts.layout')

@section('title', 'Danh mục bài viết')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Header Section --}}
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl font-bold text-slate-900 sm:truncate sm:tracking-tight">
                            Danh mục Bài viết
                        </h2>
                        <p class="mt-1 text-sm text-slate-500 font-medium">Quản lý cấu trúc phân cấp các chủ đề Blog.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('post-categories.create') }}"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Thêm danh mục
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
                <form method="GET" action="{{ route('post-categories.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                        <div class="md:col-span-5">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Tìm kiếm danh mục</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên danh mục hoặc slug..."
                                    class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Danh mục cha</label>
                            <select name="parent_id"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="">Tất cả</option>
                                @foreach($parentCategories as $parent)
                                    @if(!$parent->parent_id)
                                        <option value="{{ $parent->id }}" @selected(request('parent_id') == $parent->id)>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Trạng thái</label>
                            <select name="is_active"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 h-11 text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                <option value="">Tất cả</option>
                                <option value="1" @selected(request('is_active') === '1')>Hoạt động</option>
                                <option value="0" @selected(request('is_active') === '0')>Tạm ngừng</option>
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
                            <a href="{{ route('post-categories.index') }}" 
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
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tên danh mục</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Đường dẫn (Slug)</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Thứ tự</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Trạng thái</th>
                                <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($category->parent_id)
                                                <div class="w-6 h-px bg-slate-200 mr-2 relative top-[2px]"></div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                    {{ $category->name }}
                                                </div>
                                                @if($category->parent)
                                                    <div class="text-[10px] text-slate-400 font-medium">Thuộc: {{ $category->parent->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center font-bold">
                                        {{ $category->display_order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($category->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100 uppercase">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Hoạt động
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-600 border border-slate-200 uppercase">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Tạm ngừng
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('post-categories.edit', $category->id) }}" 
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                                title="Chỉnh sửa">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('post-categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Xác nhận xóa danh mục này? Các bài viết liên quan sẽ mất danh mục.')">
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
                                    <td colspan="5" class="px-6 py-20 text-center bg-white">
                                        <div class="flex flex-col items-center justify-center text-slate-400 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <p>Chưa có danh mục nào được tạo.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@extends('admin.layouts.layout')

@section('title', 'Cập nhật Quyền')

@section('content')

    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar: Sticky --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('permissions.index') }}"
                            class="p-2 rounded-full hover:bg-slate-100 text-slate-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Cập nhật Quyền</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">ID:
                                #{{ $permission->id }} -
                                Permission Management System</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.location='{{ route('permissions.index') }}'"
                            class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-gray-300 rounded-lg hover:bg-slate-50 shadow-sm transition-all">
                            Hủy
                        </button>
                        <button type="submit" form="main-permission-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Cập nhật thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Error Message --}}
            @if ($errors->any())
                <div class="mb-6 flex items-center p-4 text-red-800 border-t-4 border-red-500 bg-red-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">Có lỗi xảy ra khi gửi form:</h3>
                        <ul class="mt-2 text-sm list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="main-permission-form" action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Cột Trái: Content --}}
                    <div class="lg:col-span-8 space-y-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                    Thông tin quyền
                                </h3>
                            </div>

                            <div class="p-6 space-y-6">
                                {{-- Group --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Nhóm Quyền <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="group" id="group"
                                        value="{{ old('group', $permission->group) }}" required
                                        placeholder="Ví dụ: User Management, Admin Panel"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400">
                                    @error('group')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Tên Quyền <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}"
                                        required placeholder="Ví dụ: Xem danh sách, Tạo mới"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 placeholder:text-slate-400">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Code --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">
                                        Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="code" id="code" value="{{ old('code', $permission->code) }}"
                                        required placeholder="user-list, user-create"
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-slate-900 font-mono">
                                    @error('code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-slate-500">Code duy nhất để xác định quyền.</p>
                                </div>

                                {{-- Description --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-800 mb-2">Mô Tả</label>
                                    <textarea id="description" name="description" rows="4"
                                        placeholder="Nhập mô tả chi tiết về quyền này..."
                                        class="w-full rounded-xl border border-gray-300 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all px-4 py-3 text-sm text-slate-700">{{ old('description', $permission->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cột Phải: Sidebar --}}
                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Thông tin
                            </h3>

                            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50">
                                <div class="space-y-2 text-xs text-slate-600">
                                    <p class="flex justify-between">
                                        <span>Ngày tạo:</span>
                                        <span class="font-medium">{{ $permission->created_at->format('d/m/Y H:i') }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span>Cập nhật cuối:</span>
                                        <span class="font-medium">{{ $permission->updated_at->format('d/m/Y H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg shadow-blue-200 p-6 text-white">
                            <h3 class="font-bold mb-2">Cập nhật ngay?</h3>
                            <p class="text-blue-100 text-sm mb-4">Các thay đổi sẽ được áp dụng ngay lập tức trên hệ thống
                                website.</p>
                            <button type="submit" form="main-permission-form"
                                class="w-full py-3 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                                Lưu thay đổi Quyền
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
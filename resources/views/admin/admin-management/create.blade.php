@extends('admin.layouts.layout')

@section('title', 'Create Admin')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Thêm Admin Mới
                </h2>
                <p class="mt-1 text-sm text-gray-500">Tạo tài khoản admin mới và gán quyền hạn.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('admins.index') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    Quay lại danh sách
                </a>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Có lỗi xảy ra khi gửi form:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admins.store') }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Thông Tin Cơ Bản --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Thông Tin Cơ Bản</h3>
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                {{-- Name --}}
                                <div class="sm:col-span-6">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Tên Admin <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('name') ring-red-300 focus:ring-red-500 @enderror"
                                            placeholder="Ví dụ: Nguyễn Văn A">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="sm:col-span-6">
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('email') ring-red-300 focus:ring-red-500 @enderror"
                                            placeholder="admin@example.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="sm:col-span-3">
                                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">
                                        Số Điện Thoại
                                    </label>
                                    <div class="mt-2">
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                            placeholder="+84 9xx xxx xxx">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">
                                        Mật Khẩu <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="password" name="password" id="password" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('password') ring-red-300 focus:ring-red-500 @enderror"
                                            placeholder="Tối thiểu 8 ký tự">
                                        @error('password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password Confirmation --}}
                                <div class="sm:col-span-3">
                                    <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">
                                        Xác Nhận Mật Khẩu <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 @error('password_confirmation') ring-red-300 focus:ring-red-500 @enderror"
                                            placeholder="Nhập lại mật khẩu">
                                        @error('password_confirmation')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Phân Quyền
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Phân Quyền</h3>
                            <div class="space-y-6">
                                @forelse($permissionsByGroup as $group => $permissions)
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3 pb-2 border-b">
                                            {{ $group }}
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($permissions as $permission)
                                                <div class="flex items-start">
                                                    <div class="flex h-6 items-center">
                                                        <input id="permission-{{ $permission->id }}" name="permission_ids[]"
                                                            type="checkbox" value="{{ $permission->id }}"
                                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                                            {{ old('permission_ids') && in_array($permission->id, old('permission_ids', [])) ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="ml-3 text-sm leading-6">
                                                        <label for="permission-{{ $permission->id }}" class="font-medium text-gray-900 cursor-pointer">
                                                            {{ $permission->name }}
                                                        </label>
                                                        @if($permission->description)
                                                            <p class="text-gray-500 text-xs">{{ $permission->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">Chưa có quyền nào. Vui lòng tạo quyền trước.</p>
                                @endforelse
                            </div>
                            @error('permission_ids')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    --}}
                </div>

                {{-- Right Column: Settings & Actions --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Status Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Trạng thái</h3>

                            <div class="flex items-start">
                                <div class="flex h-6 items-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Hoạt động</span>
                                    </label>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Bật: Admin có thể đăng nhập và sử dụng hệ thống.<br>
                                Tắt: Admin sẽ không thể đăng nhập.
                            </p>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-[#0c8fe1] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Tạo Admin
                            </button>

                            <a href="{{ route('admins.index') }}"
                                class="mt-3 flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                                Hủy bỏ
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

@endsection

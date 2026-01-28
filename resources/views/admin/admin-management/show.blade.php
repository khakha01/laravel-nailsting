@extends('admin.layouts.layout')

@section('title', 'Admin Details')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    {{ $admin->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Xem chi tiết thông tin và quyền hạn.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 gap-2">
                <a href="{{ route('admins.edit', $admin) }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Chỉnh Sửa
                </a>
                <a href="{{ route('admins.index') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                            clip-rule="evenodd" />
                    </svg>
                    Quay lại
                </a>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if ($message = Session::get('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Thông Tin Cơ Bản --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:p-8">
                        <h3 class="text-lg font-semibold mb-6 text-gray-900">Thông Tin Cơ Bản</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tên</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Số Điện Thoại</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->phone ?? 'Chưa cập nhật' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Trạng thái</dt>
                                <dd class="mt-1">
                                    @if($admin->is_active)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Hoạt động
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Vô hiệu hóa
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tạo lúc</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Cập nhật lúc</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admin->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quyền Hạn --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Quyền Hạn</h3>
                            <a href="{{ route('admins.assign-permissions', $admin) }}"
                                class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Thay Đổi Quyền
                            </a>
                        </div>

                        @if($permissions->count() > 0)
                            <div class="space-y-4">
                                @php
                                    $groupedPermissions = $permissions->groupBy('group');
                                @endphp
                                @foreach($groupedPermissions as $group => $groupPerms)
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">{{ $group }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($groupPerms as $permission)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1.5 text-sm font-medium text-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm">Chưa có quyền nào được gán</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Avatar Card --}}
                @if($admin->media_id)
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Avatar</h3>
                            <img src="{{ get_media_url($admin->media_id) }}" alt="{{ $admin->name }}" class="w-full rounded-lg">
                        </div>
                    </div>
                @endif

                {{-- Actions Card --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Hành Động</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admins.edit', $admin) }}"
                                class="flex w-full justify-center items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Chỉnh Sửa
                            </a>
                            <button onclick="confirmDelete({{ $admin->id }})"
                                class="flex w-full justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Xóa Admin
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- Delete Form --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(adminId) {
            if (confirm('Bạn có chắc chắn muốn xóa admin này?')) {
                const form = document.getElementById('deleteForm');
                form.action = `{{ url('admin/admin') }}/${adminId}`;
                form.submit();
            }
        }
    </script>

@endsection
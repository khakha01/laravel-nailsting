@extends('admin.layouts.layout')

@section('title', 'Permission Details')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    {{ $permission->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Xem chi tiết quyền hạn.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 gap-2">
                <a href="{{ route('permissions.edit', $permission) }}"
                    class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Chỉnh Sửa
                </a>
                <a href="{{ route('permissions.index') }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
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

                {{-- Thông Tin Chi Tiết --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:p-8">
                        <h3 class="text-lg font-semibold mb-6 text-gray-900">Thông Tin Chi Tiết</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nhóm Quyền</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $permission->group }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tên Quyền</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $permission->name }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Code</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded border border-gray-200">
                                    {{ $permission->code }}
                                </dd>
                            </div>
                            @if($permission->description)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Mô Tả</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $permission->description }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tạo lúc</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $permission->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Cập nhật lúc</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $permission->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Admin được gán quyền này --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-6 sm:p-8">
                        <h3 class="text-lg font-semibold mb-6 text-gray-900">Admin Được Gán Quyền Này</h3>

                        @if($admins->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                                Tên
                                            </th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Email
                                            </th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Trạng thái
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                                <span class="sr-only">Hành động</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($admins as $admin)
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                    {{ $admin->name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ $admin->email }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                                    @if($admin->is_active)
                                                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                            Hoạt động
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                                            Vô hiệu hóa
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium">
                                                    <a href="{{ route('admins.show', $admin) }}" class="text-blue-600 hover:text-blue-900 transition">
                                                        Xem
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17.343C2.28 14.654 6.158 12 12 12c5.842 0 9.72 2.654 9.998 5.343M12 21c-5.842 0-9.72-2.654-10-5.343" />
                                </svg>
                                <p class="text-gray-500 text-sm">Chưa có admin nào được gán quyền này</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Code Badge Card --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-blue-900 mb-3">Code Quyền</h3>
                    <div class="bg-white rounded px-3 py-2 font-mono text-xs text-gray-900 break-all">
                        {{ $permission->code }}
                    </div>
                </div>

                {{-- Actions Card --}}
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">Hành Động</h3>
                        <div class="space-y-2">
                            <a href="{{ route('permissions.edit', $permission) }}"
                                class="flex w-full justify-center items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Chỉnh Sửa
                            </a>
                            <button onclick="confirmDelete({{ $permission->id }})" class="flex w-full justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Xóa Quyền
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
        function confirmDelete(permissionId) {
            if (confirm('Bạn có chắc chắn muốn xóa quyền này? Hành động này không thể hoàn tác.')) {
                const form = document.getElementById('deleteForm');
                form.action = `{{ url('admin/permissions') }}/${permissionId}`;
                form.submit();
            }
        }
    </script>

@endsection

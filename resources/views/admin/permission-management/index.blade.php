@extends('admin.layouts.layout')

@section('title', 'Quản lý quyền hạn')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Quản Lý Quyền Hạn
                </h2>
                <p class="mt-1 text-sm text-gray-500">Định nghĩa các quyền (Permissions) để gán cho vai trò (Roles).</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 gap-2">
                {{-- Nút Xóa Nhiều (Ẩn mặc định) --}}
                <button type="submit" form="bulk-delete-form" id="bulkDeleteBtn" style="display: none;"
                    class="inline-flex items-center rounded-md bg-[#e80707] px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa đã chọn <span id="selected-count-badge"
                        class="ml-1 bg-white text-red-600 py-0.5 px-2 rounded-full text-xs font-bold">0</span>
                </button>

                {{-- Nút Thêm Mới --}}
                <a href="{{ route('permissions.create') }}"
                    class="inline-flex items-center rounded-md bg-[#0c8fe1] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all duration-200">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Thêm Quyền Mới
                </a>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if ($message = Session::get('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Filters Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
            <div class="mb-4 flex items-center gap-2 text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0c8fe1]" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
                <h3 class="font-semibold text-sm uppercase tracking-wide">Bộ lọc tìm kiếm</h3>
            </div>

            <form method="GET" action="{{ route('permissions.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    {{-- Search Input --}}
                    <div class="md:col-span-5">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">Tìm kiếm</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nhập tên quyền hoặc mã code..."
                                class="w-full pl-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 transition-colors">
                        </div>
                    </div>

                    {{-- Group Filter --}}
                    <div class="md:col-span-4">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">Nhóm (Module)</label>
                        <div class="relative">
                            <select name="group"
                                class="w-full pl-3 pr-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 transition-colors appearance-none">
                                <option value="">-- Tất cả nhóm --</option>
                                {{-- Bạn có thể loop danh sách group từ controller truyền qua --}}
                                @if(isset($groups))
                                    @foreach($groups as $group)
                                        <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>
                                            {{ ucfirst($group) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="md:col-span-3 flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 rounded-lg bg-[#000] px-4 h-10 text-sm font-medium text-white shadow-sm hover:bg-[#0c8fe1] focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            Tìm
                        </button>
                        <a href="{{ route('permissions.index') }}"
                            class="inline-flex justify-center items-center rounded-lg border border-gray-200 bg-white px-4 h-10 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Main Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                                <input type="checkbox" id="select-all" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tên Quyền
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Mã Code (Slug)
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nhóm (Module)
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Mô tả
                            </th>
                            <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permissions as $permission)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                {{-- Checkbox --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="permission-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $permission->id }}">
                                </td>

                                {{-- Name --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $permission->name }}</div>
                                </td>

                                {{-- Slug / Code --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-xs text-blue-700 bg-blue-50 px-2 py-1 rounded border border-blue-100 font-mono">
                                        {{ $permission->slug ?? $permission->name }}
                                    </code>
                                </td>

                                {{-- Group --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                        {{ ucfirst($permission->group) }}
                                    </span>
                                </td>

                                {{-- Description --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 max-w-xs truncate" title="{{ $permission->description }}">
                                        {{ $permission->description ?? '---' }}
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('permissions.show', $permission->id) }}" class="text-gray-400 hover:text-green-600 transition-colors" title="Xem">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.107.424.107.639a1.012 1.012 0 01-.107.639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178a1.012 1.012 0 010-.639z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('permissions.assign-admins', $permission->id) }}" class="text-gray-400 hover:text-purple-600 transition-colors" title="Gán Admin">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('permissions.destroy', $permission->id) }}" class="inline-block" onsubmit="return confirm('Xóa quyền này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors pt-1" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Chưa có quyền hạn nào được thiết lập.</p>
                                        <a href="{{ route('permissions.create') }}" class="mt-3 text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline">
                                            Tạo quyền đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                {{-- <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                     {{ $permissions->withQueryString()->links() }}
                </div> --}}
            </div>
        </div>

        {{-- Hidden Bulk Delete Form --}}
        {{-- <form method="POST" action="{{ route('permissions.bulk-delete') }}" id="bulk-delete-form" style="display:none"
            onsubmit="return confirm('Bạn có chắc chắn muốn xóa các quyền đã chọn?')">
            @csrf
            @method('DELETE')
        </form> --}}

    </div>

    {{-- Script Logic (Copy từ trang Admin/Category) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountBadge = document.getElementById('selected-count-badge');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateBulkActionState() {
                const checkedBoxes = document.querySelectorAll('.permission-checkbox:checked');
                const count = checkedBoxes.length;

                // Xóa input cũ
                const existingInputs = bulkDeleteForm.querySelectorAll('input[name="permission_ids[]"]');
                existingInputs.forEach(input => input.remove());

                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                    selectedCountBadge.textContent = count;

                    // Tạo input mới
                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'permission_ids[]';
                        input.value = cb.value;
                        bulkDeleteForm.appendChild(input);
                    });

                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateBulkActionState();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateBulkActionState);
            });
        });
    </script>
@endsection

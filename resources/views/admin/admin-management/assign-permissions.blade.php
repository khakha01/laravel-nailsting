@extends('admin.layouts.layout')

@section('title', 'Assign Permissions to Admin')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Gán Quyền cho {{ $admin->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Chọn các quyền hạn cho admin này.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('admins.show', $admin) }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    Quay lại
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
                        <h3 class="text-sm font-medium text-red-800">Có lỗi xảy ra:</h3>
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

        <form method="POST" action="{{ route('admins.assign-permissions.store', $admin) }}">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Permissions List --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="space-y-8">
                                @forelse($permissionsByGroup as $group => $permissions)
                                    <div>
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $group }}</h3>
                                            <button type="button" onclick="toggleGroup('{{ str_replace(' ', '-', strtolower($group)) }}')"
                                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                                                Chọn tất cả
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b">
                                            @foreach($permissions as $permission)
                                                <div class="flex items-start p-3 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition">
                                                    <div class="flex h-6 items-center">
                                                        <input id="permission-{{ $permission->id }}" name="permission_ids[]"
                                                            type="checkbox" value="{{ $permission->id }}"
                                                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600 permission-checkbox"
                                                            data-group="{{ str_replace(' ', '-', strtolower($group)) }}"
                                                            {{ in_array($permission->id, $adminPermissions) ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="ml-3 text-sm leading-6 flex-1">
                                                        <label for="permission-{{ $permission->id }}" class="font-medium text-gray-900 cursor-pointer block">
                                                            {{ $permission->name }}
                                                        </label>
                                                        @if($permission->description)
                                                            <p class="text-gray-500 text-xs mt-1">{{ $permission->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-gray-500 text-sm">Chưa có quyền nào. Vui lòng tạo quyền trước.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Summary & Actions --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Selected Permissions Summary --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-4">
                                Quyền Đã Chọn
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold ml-2" id="selected-count">0</span>
                            </h3>
                            <div id="selected-permissions" class="space-y-2 max-h-64 overflow-y-auto">
                                <p class="text-gray-500 text-sm text-center py-4">Không có quyền nào được chọn</p>
                            </div>
                        </div>
                    </div>

                    {{-- Info Card --}}
                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 mb-3">Thông tin Admin</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>
                                    <span class="font-medium">Tên:</span><br>
                                    {{ $admin->name }}
                                </p>
                                <p>
                                    <span class="font-medium">Email:</span><br>
                                    {{ $admin->email }}
                                </p>
                            </div>
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
                                Lưu Quyền
                            </button>

                            <a href="{{ route('admins.show', $admin) }}"
                                class="mt-3 flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                                Hủy bỏ
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        // Update selected permissions count and display
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            const selectedDiv = document.getElementById('selected-permissions');
            const countBadge = document.getElementById('selected-count');

            countBadge.textContent = checkboxes.length;

            if (checkboxes.length === 0) {
                selectedDiv.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">Không có quyền nào được chọn</p>';
            } else {
                let html = '';
                checkboxes.forEach(checkbox => {
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    if (label) {
                        html += `<div class="flex items-center justify-between bg-blue-50 px-3 py-2 rounded text-sm">
                            <span class="text-gray-700">${label.textContent}</span>
                            <button type="button" onclick="document.getElementById('${checkbox.id}').checked = false; updateSelectedCount();" class="text-red-600 hover:text-red-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>`;
                    }
                });
                selectedDiv.innerHTML = html;
            }
        }

        // Toggle group permissions
        function toggleGroup(groupName) {
            const checkboxes = document.querySelectorAll(`input[data-group="${groupName}"]`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });

            updateSelectedCount();
        }

        // Add event listeners
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // Initialize
        updateSelectedCount();
    </script>

@endsection

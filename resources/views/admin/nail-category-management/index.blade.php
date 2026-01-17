@extends('admin.layouts.layout')

@section('title', 'Nail Categories Management')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Quản Lý Danh Mục Nail
                </h2>
                <p class="mt-1 text-sm text-gray-500">Quản lý phân loại danh mục nail của hệ thống.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0 gap-2">
                {{-- Nút Xóa Nhiều --}}
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
                <a href="{{ route('nail-categories.create') }}"
                    class="inline-flex items-center rounded-md bg-[#0c8fe1] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 transition-all duration-200">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Thêm Mới
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

        @if ($message = Session::get('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                                <input type="checkbox" id="select-all"
                                    class="h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tên Danh Mục</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Slug</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Danh Mục Cha</th>
                            <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($nailCategories as $nailCategory)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                        class="nail-category-checkbox h-4 w-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500"
                                        value="{{ $nailCategory->id }}">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $nailCategory->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code
                                        class="text-xs text-pink-600 bg-pink-50 px-2 py-1 rounded border border-pink-100">{{ $nailCategory->slug }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($nailCategory->parent)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $nailCategory->parent->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('nail-categories.show', $nailCategory->id) }}"
                                            class="text-gray-400 hover:text-indigo-600 transition-colors" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <form method="POST" action="{{ route('nail-categories.delete', $nailCategory->id) }}"
                                            class="inline-block" onsubmit="return confirm('Xóa danh mục nail này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors pt-1"
                                                title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Không có danh mục nail nào được tìm thấy.</p>
                                        <a href="{{ route('nail-categories.create') }}"
                                            class="mt-3 text-sm font-medium text-pink-600 hover:text-pink-500 hover:underline">
                                            Thêm danh mục nail mới
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Hidden Bulk Delete Form --}}
        <form method="POST" action="{{ route('nail-categories.bulk-delete') }}" id="bulk-delete-form" style="display:none"
            onsubmit="return confirm('Xóa các danh mục nail đã chọn?')">
            @csrf
            @method('DELETE')
        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.nail-category-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCountBadge = document.getElementById('selected-count-badge');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function updateBulkActionState() {
                const checkedBoxes = document.querySelectorAll('.nail-category-checkbox:checked');
                const count = checkedBoxes.length;

                const existingInputs = bulkDeleteForm.querySelectorAll('input[name="nail_category_ids[]"]');
                existingInputs.forEach(input => input.remove());

                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                    selectedCountBadge.textContent = count;

                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'nail_category_ids[]';
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


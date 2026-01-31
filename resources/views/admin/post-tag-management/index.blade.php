@extends('admin.layouts.layout')

@section('title', 'Quản lý Tags')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Tags Bài Viết
                </h2>
                <p class="mt-1 text-sm text-gray-500">Quản lý nhãn giúp tìm kiếm và phân loại bài viết chi tiết hơn.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <button type="button" onclick="openCreateModal()"
                    class="inline-flex items-center rounded-md bg-[#0c8fe1] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 transition-all duration-200">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Thêm Tag mới
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tags as $tag)
                <div
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-400"></span>
                            <h3 class="font-bold text-slate-800">{{ $tag->name }}</h3>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">{{ $tag->slug }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="openEditModal({{ $tag->id }}, '{{ $tag->name }}', '{{ $tag->slug }}')"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <form action="{{ route('post-tags.destroy', $tag->id) }}" method="POST"
                            onsubmit="return confirm('Xóa tag này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-12 text-center text-slate-400 bg-white rounded-xl border border-dashed border-slate-300">
                    Chưa có tag nào được tạo.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    <div id="tag-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="tag-form" method="POST">
                    @csrf
                    <div id="method-field"></div>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4" id="modal-title">Thêm Tag Mới</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="tag_name" class="block text-sm font-bold text-slate-700 mb-2">Tên Tag</label>
                                <input type="text" name="name" id="tag_name" required
                                    class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="tag_slug" class="block text-sm font-bold text-slate-700 mb-2">Slug</label>
                                <input type="text" name="slug" id="tag_slug"
                                    class="w-full rounded-xl border-gray-300 bg-slate-50 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:w-auto sm:text-sm transition-colors">
                            Lưu cấu hình
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/slug.js') }}"></script>
        <script>
            const modal = document.getElementById('tag-modal');
            const form = document.getElementById('tag-form');
            const title = document.getElementById('modal-title');
            const nameInput = document.getElementById('tag_name');
            const slugInput = document.getElementById('tag_slug');
            const methodField = document.getElementById('method-field');

            function openCreateModal() {
                form.action = '{{ route('post-tags.store') }}';
                methodField.innerHTML = '';
                title.innerText = 'Thêm Tag Mới';
                nameInput.value = '';
                slugInput.value = '';
                modal.classList.remove('hidden');
            }

            function openEditModal(id, name, slug) {
                form.action = '{{ route('post-tags.update', ['post_tag' => '__ID__']) }}'.replace('__ID__', id);
                methodField.innerHTML = '@method('PUT')';
                title.innerText = 'Chỉnh Sửa Tag';
                nameInput.value = name;
                slugInput.value = slug;
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            nameInput.addEventListener('input', function () {
                if (this.value) {
                    slugInput.value = changeToSlug(this.value);
                }
            });
        </script>
    @endpush

@endsection
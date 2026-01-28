@extends('admin.layouts.layout')

@section('title', 'Cài đặt hệ thống')

@section('content')
    <div class="min-h-screen bg-[#f8fafc] pb-12">
        {{-- Top Bar --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">Cài đặt hệ thống</h2>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Cấu hình thông tin
                                Website
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" form="settings-form"
                            class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md shadow-blue-200 transition-all">
                            Lưu cấu hình
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-6 flex items-center p-4 text-green-800 border-t-4 border-green-500 bg-green-50 rounded-lg shadow-sm"
                    role="alert">
                    <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                {{-- Tabs Header --}}
                <div class="flex border-b border-slate-200 overflow-x-auto bg-slate-50/50">
                    <button type="button" onclick="switchTab('general')"
                        class="tab-btn active px-6 py-4 text-sm font-bold text-slate-600 hover:text-blue-600 border-b-2 border-transparent transition-all whitespace-nowrap flex items-center gap-2"
                        data-tab="general">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Thông tin chung
                    </button>
                    <button type="button" onclick="switchTab('social')"
                        class="tab-btn px-6 py-4 text-sm font-bold text-slate-600 hover:text-blue-600 border-b-2 border-transparent transition-all whitespace-nowrap flex items-center gap-2"
                        data-tab="social">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Mạng xã hội
                    </button>
                    <button type="button" onclick="switchTab('images')"
                        class="tab-btn px-6 py-4 text-sm font-bold text-slate-600 hover:text-blue-600 border-b-2 border-transparent transition-all whitespace-nowrap flex items-center gap-2"
                        data-tab="images">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Hình ảnh & Logo
                    </button>
                    <button type="button" onclick="switchTab('options')"
                        class="tab-btn px-6 py-4 text-sm font-bold text-slate-600 hover:text-blue-600 border-b-2 border-transparent transition-all whitespace-nowrap flex items-center gap-2"
                        data-tab="options">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Tùy chọn khác
                    </button>
                </div>

                <form id="settings-form" action="{{ route('settings.update') }}" method="POST" class="p-8">
                    @csrf

                    {{-- Tab 1: General Settings --}}
                    <div id="general-tab" class="tab-content space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Email hỗ trợ</label>
                                <input type="email" name="email" value="{{ old('email', $settings->email ?? '') }}"
                                    placeholder="ví dụ: contact@nailsting.com"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Số điện thoại 1</label>
                                <input type="text" name="phone1" value="{{ old('phone1', $settings->phone1 ?? '') }}"
                                    placeholder="Số điện thoại chính"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Số điện thoại 2</label>
                                <input type="text" name="phone2" value="{{ old('phone2', $settings->phone2 ?? '') }}"
                                    placeholder="Số điện thoại phụ"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Số điện thoại 3</label>
                                <input type="text" name="phone3" value="{{ old('phone3', $settings->phone3 ?? '') }}"
                                    placeholder="Số điện thoại dự phòng"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Số điện thoại Zalo</label>
                                <input type="text" name="phone_zalo"
                                    value="{{ old('phone_zalo', $settings->phone_zalo ?? '') }}"
                                    placeholder="SĐT liên hệ Zalo"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">Địa chỉ</label>
                            <textarea name="address" rows="3"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">{{ old('address', $settings->address ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Tab 2: Social Links --}}
                    <div id="social-tab" class="tab-content hidden space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Facebook URL</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="link_fb" value="{{ old('link_fb', $settings->link_fb ?? '') }}"
                                        placeholder="https://facebook.com/..."
                                        class="w-full rounded-xl border border-gray-300 pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">TikTok URL</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.17-2.89-.6-4.09-1.47-.88-.64-1.6-1.51-2.09-2.52v7.7c.1 2.04-.6 4.2-2.15 5.56-1.69 1.54-4.23 2.05-6.38 1.42-1.95-.57-3.66-2.19-4.27-4.14-.85-2.6.22-5.69 2.56-7.14 1-.61 2.19-.94 3.4-.94.13 0 .27 0 .4.01V12a5.57 5.57 0 00-4.03 1.55 5.57 5.57 0 00-1.6 4c0 3.08 2.5 5.58 5.58 5.58 3.08 0 5.58-2.5 5.58-5.58V0z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="link_tiktok"
                                        value="{{ old('link_tiktok', $settings->link_tiktok ?? '') }}"
                                        placeholder="https://tiktok.com/@..."
                                        class="w-full rounded-xl border border-gray-300 pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-2">Zalo URL</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C6.477 2 2 6.477 2 12c0 5.523 4.477 10 10 10s10-4.477 10-10c0-5.523-4.477-10-10-10zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8zm-1-11v4h2v-4h-2zm0 6v2h2v-2h-2z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="link_zalo"
                                        value="{{ old('link_zalo', $settings->link_zalo ?? '') }}"
                                        placeholder="https://zalo.me/..."
                                        class="w-full rounded-xl border border-gray-300 pl-12 pr-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab 3: Images & Logos --}}
                    <div id="images-tab" class="tab-content hidden space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Logo --}}
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-slate-800">Logo Website</label>
                                <div
                                    class="p-6 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center bg-slate-50/50">
                                    <div id="logo-preview" class="mb-4">
                                        @if($settings && $settings->logo_id)
                                            @php
                                                $logo = \App\Models\Media::find($settings->logo_id);
                                            @endphp
                                            <img src="{{ get_media_url($logo) }}" class="max-h-32 object-contain">
                                        @else
                                            <div
                                                class="h-32 w-48 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 italic">
                                                Chưa có logo</div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="logo_id" id="logo_id" value="{{ $settings->logo_id ?? '' }}">
                                    <button type="button" onclick="openMediaModal('logo')"
                                        class="px-4 py-2 text-sm font-bold text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">
                                        Thay đổi Logo
                                    </button>
                                </div>
                            </div>

                            {{-- Favicon --}}
                            <div class="space-y-4">
                                <label class="block text-sm font-bold text-slate-800">Favicon (Biểu tượng trình
                                    duyệt)</label>
                                <div
                                    class="p-6 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center bg-slate-50/50">
                                    <div id="favicon-preview" class="mb-4">
                                        @if($settings && $settings->favicon_id)
                                            @php
                                                $favicon = \App\Models\Media::find($settings->favicon_id);
                                            @endphp
                                            <img src="{{ get_media_url($favicon) }}" class="h-16 w-16 object-contain">
                                        @else
                                            <div
                                                class="h-16 w-16 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400 italic">
                                                ...</div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="favicon_id" id="favicon_id"
                                        value="{{ $settings->favicon_id ?? '' }}">
                                    <button type="button" onclick="openMediaModal('favicon')"
                                        class="px-4 py-2 text-sm font-bold text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 transition-all">
                                        Thay đổi Favicon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab 4: Options --}}
                    <div id="options-tab" class="tab-content hidden space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">Tên Website</label>
                            <input type="text" name="website_name"
                                value="{{ old('website_name', $settings->website_name ?? '') }}"
                                placeholder="Tên hiển thị trên trình duyệt"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">Google Map Iframe</label>
                            <textarea name="map_iframe" rows="5"
                                placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 font-mono text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">{{ old('map_iframe', $settings->map_iframe ?? '') }}</textarea>
                            <p class="mt-2 text-xs text-slate-500 italic">Dán mã nhúng từ Google Maps vào đây.</p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @include('admin.components.media-manager-modal')

    <style>
        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            background-color: white;
        }
    </style>

    @push('scripts')
        <script src="{{ asset('js/media-manager.js') }}"></script>
        <script>
            function switchTab(tabId) {
                // Hide all contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected content
                document.getElementById(tabId + '-tab').classList.remove('hidden');

                // Update buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
            }

            // Media Manager Integration
            const mediaManager = new MediaManager({
                urls: {
                    index: '{{ route('media.index') }}',
                    store: '{{ route('media.store') }}',
                    folderStore: '{{ route('media.folders.store') }}',
                    folderDelete: '{{ route('media.folders.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                    mediaDelete: '{{ route('media.destroy', ['id' => '__ID__']) }}'.replace('__ID__', ''),
                    mediaBulkDelete: '{{ route('media.bulk-delete') }}',
                },
                csrfToken: '{{ csrf_token() }}'
            });

            let currentTarget = '';

            window.openMediaModal = function (target) {
                currentTarget = target;
                mediaManager.openMediaModal();
            };

            mediaManager.confirmSelection = function () {
                const selected = Array.from(this.state.selectedItemsMap.values());
                if (selected.length > 0) {
                    const item = selected[0]; // Chỉ lấy 1 ảnh
                    if (currentTarget === 'logo') {
                        document.getElementById('logo_id').value = item.id;
                        document.getElementById('logo-preview').innerHTML = `<img src="${item.url}" class="max-h-32 object-contain">`;
                    } else if (currentTarget === 'favicon') {
                        document.getElementById('favicon_id').value = item.id;
                        document.getElementById('favicon-preview').innerHTML = `<img src="${item.url}" class="h-16 w-16 object-contain">`;
                    }
                }
                this.closeMediaModal();
                this.state.selectedItemsMap.clear();
            }
        </script>
    @endpush
@endsection
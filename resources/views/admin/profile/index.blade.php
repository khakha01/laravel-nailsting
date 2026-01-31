@extends('admin.layouts.layout')

@section('header_title', 'Hồ sơ cá nhân')

@section('content')
    <div class="max-w-6xl mx-auto pb-12">
        {{-- Cover Area --}}
        <div
            class="relative h-64 md:h-80 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-b-3xl shadow-lg">
            {{-- Decorative Pattern --}}
            <div class="absolute inset-0 opacity-20"
                style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

            {{-- Profile Avatar Overlap --}}
            <div class="absolute -bottom-16 left-6 md:left-12 flex items-end">
                <div class="relative group">
                    <div
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gray-100">
                        <img id="profile-preview"
                            src="{{ get_media_url($admin->media_id, 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=6366f1&color=fff&size=200') }}"
                            alt="{{ $admin->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute bottom-2 right-2 flex space-x-2">
                        <div class="w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                </div>

                <div class="mb-4 ml-6 hidden md:block">
                    <h1 class="text-3xl font-black text-white drop-shadow-md tracking-tight">{{ $admin->name }}</h1>
                    <p class="text-indigo-50 font-medium opacity-90 tracking-wide uppercase text-xs">
                        {{ $admin->isSuperAdmin() ? 'Super Administrator' : 'Hệ thống Quản trị' }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="absolute bottom-6 right-6 md:right-12 space-x-3">
                <button
                    class="px-6 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white border border-white/30 rounded-xl font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                        </path>
                    </svg>
                    Đổi ảnh bìa
                </button>
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="mt-20 px-4 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left Column: Info & Stats --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- User Basic Info (Mobile Only Friendly) --}}
                <div class="md:hidden text-center mb-8">
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">{{ $admin->name }}</h1>
                    <p class="text-indigo-600 font-bold tracking-wide uppercase text-[10px] mt-1">
                        {{ $admin->isSuperAdmin() ? 'Super Administrator' : 'Hệ thống Quản trị' }}</p>
                </div>

                {{-- Intro Card --}}
                <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-50">
                    <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        Giới thiệu
                    </h3>
                    <div class="space-y-4">
                        <p class="text-slate-500 text-sm leading-relaxed italic">
                            "Làm việc với đam mê và sự tận tâm để mang lại trải nghiệm tốt nhất cho khách hàng tại
                            NailsTing."
                        </p>
                        <div class="pt-4 space-y-3 border-t border-slate-50">
                            <div class="flex items-center text-sm text-slate-600 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <span class="font-medium">{{ $admin->email }}</span>
                            </div>
                            <div class="flex items-center text-sm text-slate-600 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <span class="font-medium">{{ $admin->phone ?? 'Chưa cập nhật' }}</span>
                            </div>
                            <div class="flex items-center text-sm text-slate-600 group">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center mr-3 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <span class="font-medium italic text-slate-400">Gia nhập:
                                    {{ $admin->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-indigo-600 rounded-3xl p-5 text-white shadow-lg shadow-indigo-200">
                        <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mb-1">Quyền hạn</p>
                        <p class="text-2xl font-black">{{ $permissions->count() }}</p>
                    </div>
                    <div class="bg-white rounded-3xl p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-50">
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Trạng thái</p>
                        <div class="flex items-center gap-2">
                            <span
                                class="w-2 h-2 rounded-full {{ $admin->is_active ? 'bg-green-500 animate-pulse' : 'bg-red-500' }}"></span>
                            <span
                                class="text-sm font-black text-slate-700 uppercase tracking-tight">{{ $admin->is_active ? 'Online' : 'Offline' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Permissions & Activity --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Permissions Section --}}
                <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-50">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Quyền hạn đang sở hữu</h3>
                            <p class="text-sm text-slate-400 mt-1">Danh sách các quyền bạn có thể thực hiện trên hệ thống
                            </p>
                        </div>
                        @if($admin->isSuperAdmin())
                            <span
                                class="px-4 py-1.5 bg-rose-100 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-200 shadow-sm shadow-rose-50">Full
                                Access</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($permissions as $permission)
                            <div
                                class="flex items-start p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 hover:bg-indigo-50/30 transition-all group">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700 tracking-tight">{{ $permission->name }}</p>
                                    <p class="text-[11px] text-slate-400 font-medium mt-0.5 tracking-tight">Code: <code
                                            class="bg-gray-200/50 px-1 rounded text-slate-500">{{ $permission->code }}</code>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-2 py-12 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-5963428-4931437.png"
                                    class="w-32 mx-auto mb-4 opacity-50" alt="Null">
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Bạn chưa có quyền hạn nào
                                    cụ thể</p>
                            </div>
                        @endforelse
                    </div>

                    @if($admin->isSuperAdmin())
                        <div
                            class="mt-8 p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl border border-indigo-100">
                            <h4 class="font-black text-indigo-800 uppercase tracking-widest text-[10px] mb-2">Thông báo đặc
                                quyền</h4>
                            <p class="text-indigo-600/80 text-sm leading-relaxed">
                                Bạn là <b>Super Admin</b>, có toàn quyền quản trị hệ thống NailsTing. Bao gồm các quyền quản lý
                                nhân sự, bảo mật hệ thống và cấu hình thanh toán.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Action Area --}}
                <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-50">
                    <h3 class="text-lg font-bold text-slate-800 mb-6">Thao tác tài khoản</h3>
                    <div class="flex flex-wrap gap-4">
                        <button
                            class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all active:scale-95">
                            Cập nhật thông tin
                        </button>
                        <button
                            class="px-8 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-2xl font-bold transition-all active:scale-95">
                            Đổi mật khẩu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
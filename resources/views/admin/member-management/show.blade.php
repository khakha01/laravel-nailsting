@extends('admin.layouts.layout')

@section('title', 'Chi tiết thành viên')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 min-h-screen">

        {{-- Breadcrumb --}}
        <div class="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('members.index') }}" class="hover:text-blue-600 transition-colors">Quản lý thành viên</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-900 font-medium">{{ $member->name }}</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
            {{-- Header card --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-8 py-10 flex items-center gap-6">
                @if ($member->avatar)
                    <img src="{{ $member->avatar }}" alt="{{ $member->name }}"
                        class="w-20 h-20 rounded-full object-cover ring-4 ring-white/20">
                @else
                    <div
                        class="w-20 h-20 rounded-full bg-emerald-400 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-white/20">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $member->name }}</h2>
                    <p class="text-slate-400 text-sm mt-1">{{ $member->email }}</p>
                    @if ($member->google_id)
                        <span
                            class="inline-flex items-center gap-1 mt-2 rounded-full bg-blue-500/20 px-3 py-1 text-xs font-medium text-blue-200">
                            <svg class="w-3 h-3" viewBox="0 0 48 48">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C36.5 2.5 30.6 0 24 0 14.7 0 6.6 4.9 2.5 12.2l7.9 6.1C12.5 13.2 17.8 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.5 24c0-1.6-.1-3.2-.4-4.7H24v9h12.7c-.5 2.9-2 5.4-4.3 7.1l6.7 5.2c3.9-3.6 6.1-9 6.1-15.6z" />
                                <path fill="#FBBC05"
                                    d="M12.4 28.3c-.5-1.5-.8-3.1-.8-4.8s.3-3.3.8-4.8l-7.9-6.1C3.5 15.5 2.5 19.6 2.5 24c0 4.4 1 8.5 2.9 12.1l7.9-6.1z" />
                                <path fill="#34A853"
                                    d="M24 48c6.6 0 12.5-2.2 16.7-6l-7.9-6.1c-2.2 1.5-5 2.4-8.8 2.4-6.2 0-11.5-3.7-14.2-9l-7.9 6.1C6.6 43.1 14.7 48 24 48z" />
                            </svg>
                            Đăng nhập bằng Google
                        </span>
                    @else
                        <span
                            class="inline-flex items-center mt-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-slate-300">
                            Email / Mật khẩu
                        </span>
                    @endif
                </div>
            </div>

            {{-- Detail info --}}
            <div class="p-8 space-y-5">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">ID</p>
                        <p class="text-sm font-medium text-gray-800">{{ $member->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Google ID</p>
                        <p class="text-sm text-gray-800 truncate">{{ $member->google_id ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ngày đăng ký</p>
                        <p class="text-sm text-gray-800">{{ $member->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Lần cuối cập nhật</p>
                        <p class="text-sm text-gray-800">{{ $member->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Email đã xác minh</p>
                        <p class="text-sm text-gray-800">
                            {{ $member->email_verified_at ? $member->email_verified_at->format('d/m/Y H:i') : '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="px-8 py-5 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('members.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Quay lại danh sách
                </a>
                <form method="POST" action="{{ route('members.destroy', $member->id) }}"
                    onsubmit="return confirm('Bạn có chắc muốn xóa thành viên này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Xóa thành viên
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
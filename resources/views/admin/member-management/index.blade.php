@extends('admin.layouts.layout')

@section('title', 'Quản lý thành viên')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 min-h-screen">

        {{-- Header --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Quản lý thành viên
                </h2>
                <p class="mt-1 text-sm text-gray-500">Danh sách người dùng đăng ký qua website hoặc đăng nhập Google.</p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 border-l-4 border-green-500">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
            <form method="GET" action="{{ route('members.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    {{-- Search --}}
                    <div class="md:col-span-5">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">Tìm kiếm</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên hoặc Email..."
                                class="w-full pl-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 transition-colors">
                        </div>
                    </div>

                    {{-- Provider --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-500 uppercase mb-1.5 ml-1">Loại tài khoản</label>
                        <div class="relative">
                            <select name="provider"
                                class="w-full pl-3 pr-10 rounded-lg border-gray-200 bg-gray-50 text-gray-700 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm h-10 transition-colors appearance-none">
                                <option value="">-- Tất cả --</option>
                                <option value="google" {{ request('provider') === 'google' ? 'selected' : '' }}>Google
                                </option>
                                <option value="email" {{ request('provider') === 'email' ? 'selected' : '' }}>Email / Mật khẩu
                                </option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="md:col-span-4 flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 rounded-lg bg-[#000] px-4 h-10 text-sm font-medium text-white shadow-sm hover:bg-[#0c8fe1] transition-all w-full md:w-auto">
                            Tìm kiếm
                        </button>
                        <a href="{{ route('members.index') }}"
                            class="inline-flex justify-center items-center rounded-lg border border-gray-200 bg-white px-4 h-10 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Thành viên</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Loại</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Ngày đăng ký</th>
                            <th class="relative px-6 py-4"><span class="sr-only">Hành động</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($members as $member)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                {{-- Avatar + Info --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if ($member->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200"
                                                src="{{ $member->avatar }}" alt="{{ $member->name }}">
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-sm">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $member->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Provider --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($member->google_id)
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
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
                                            Google
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            Email
                                        </span>
                                    @endif
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $member->created_at->format('d/m/Y H:i') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('members.show', $member->id) }}"
                                            class="text-gray-400 hover:text-green-600 transition-colors" title="Xem">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.107.424.107.639a1.012 1.012 0 01-.107.639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178a1.012 1.012 0 010-.639z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('members.destroy', $member->id) }}"
                                            class="inline-block" onsubmit="return confirm('Xóa thành viên này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors pt-1" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
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
                                <td colspan="4" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Không tìm thấy thành viên nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                    {{ $members->withQueryString()->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection
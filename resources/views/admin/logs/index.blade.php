@extends('admin.layouts.layout')

@section('title', 'System Logs')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-10 bg-gray-50 h-full min-h-screen">
        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    System Logs
                </h2>
                <p class="mt-1 text-sm text-gray-500">Monitor system activities and debug errors.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('logs.download', ['file' => $selectedFile]) }}"
                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Tải về
                </a>
                @if(auth()->guard('admin')->user()?->hasPermission('system-log-delete'))
                    <form action="{{ route('logs.destroy') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sạch file log này?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="file" value="{{ $selectedFile }}">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Xóa sạch Log
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
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
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Filter Section --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
            <form action="{{ route('logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="file" class="block text-xs font-semibold text-gray-500 uppercase mb-1">File Log</label>
                    <select name="file" id="file" onchange="this.form.submit()"
                        class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                        @foreach($files as $file)
                            <option value="{{ $file }}" @selected($selectedFile == $file)>{{ $file }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="level" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cấp độ</label>
                    <select name="level" id="level" onchange="this.form.submit()"
                        class="block w-full rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="">Tất cả</option>
                        @foreach($levels as $level)
                            <option value="{{ $level }}" @selected(request('level') == $level)>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="q" class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tìm kiếm</label>
                    <div class="flex gap-2">
                        <input type="text" name="q" id="q" value="{{ request('q') }}"
                            placeholder="Tìm kiếm trong nội dung log..."
                            class="block flex-1 rounded-lg border-gray-300 text-sm focus:ring-pink-500 focus:border-pink-500">
                        <button type="submit"
                            class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        @if(request()->has('q') || request()->has('level'))
                            <a href="{{ route('logs.index', ['file' => $selectedFile]) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Xóa lọc
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Content --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48">
                                Thời gian</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">
                                Cấp độ</th>
                            <th scope="col"
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nội
                                dung</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 font-mono text-xs">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $log['timestamp'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                                                    @if(in_array($log['level'], ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'])) bg-red-100 text-red-700
                                                                    @elseif($log['level'] == 'WARNING') bg-yellow-100 text-yellow-700
                                                                    @elseif($log['level'] == 'INFO') bg-blue-100 text-blue-700
                                                                    @elseif($log['level'] == 'DEBUG') bg-gray-100 text-gray-700
                                                                    @else bg-green-100 text-green-700 @endif">
                                        {{ $log['level'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="max-w-4xl @if(in_array($log['level'], ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'])) text-red-600 font-semibold @endif">
                                        {{ $log['message'] }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center bg-gray-50">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-500">Không tìm thấy log nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
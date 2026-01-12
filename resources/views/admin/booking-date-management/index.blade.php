@extends('admin.layouts.layout')

@section('title', 'Booking Date')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Quản lý ngày làm việc</h1>

        <a href="{{ route('booking-dates.create') }}"
           class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
            + Thêm ngày
        </a>
    </div>
 @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-3">Ngày</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3">Khung giờ</th>
                    <th class="px-4 py-3 w-32">Thao tác</th>
                </tr>
            </thead>
<tbody>
                @forelse ($dates as $date)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-medium">
                            {{ $date->date->format('d/m/Y') }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($date->is_open)
                                <span class="text-green-600 font-semibold">Mở</span>
                            @else
                                <span class="text-red-500 font-semibold">Đóng</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            @if ($date->timeSlots->isEmpty())
                                <span class="text-gray-400 italic">Chưa có</span>
                            @else
                                <ul class="space-y-1">
                                    @foreach ($date->timeSlots as $slot)
                                        <li>
                                            {{ $slot->start_time }} - {{ $slot->end_time }}
                                            @if (! $slot->is_open)
                                                <span class="text-red-400">(đóng)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href=""
                                   class="text-blue-600 hover:underline">
                                    Sửa
                                </a>

                                <form method="POST"
                                      action=""
                                      onsubmit="return confirm('Xóa ngày này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Chưa có ngày nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

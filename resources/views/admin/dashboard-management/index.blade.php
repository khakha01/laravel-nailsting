@extends('admin.layouts.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Card thống kê -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">Tổng lịch hẹn hôm nay</h2>
            <p class="text-2xl">15</p>  <!-- Dữ liệu từ controller -->
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">Khách hàng mới</h2>
            <p class="text-2xl">5</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold">Doanh thu tháng</h2>
            <p class="text-2xl">10,000,000 VNĐ</p>
        </div>
    </div>

    <!-- Bảng lịch hẹn mẫu -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Lịch hẹn sắp tới</h2>
        <table class="w-full border-collapse bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Khách hàng</th>
                    <th class="p-2 border">Thời gian</th>
                    <th class="p-2 border">Dịch vụ</th>
                    <th class="p-2 border">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dữ liệu từ controller, ví dụ -->
                <tr>
                    <td class="p-2 border">1</td>
                    <td class="p-2 border">Nguyễn Thị A</td>
                    <td class="p-2 border">13/01/2026 10:00</td>
                    <td class="p-2 border">Làm móng gel</td>
                    <td class="p-2 border">
                        <a href="#" class="text-blue-500">Sửa</a> | <a href="#" class="text-red-500">Xóa</a>
                    </td>
                </tr>
                <!-- Thêm rows khác -->
            </tbody>
        </table>
    </div>
@endsection

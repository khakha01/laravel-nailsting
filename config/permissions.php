<?php

/**
 * Config định nghĩa các quyền hạn theo group
 *
 * Cấu trúc:
 * 'group_name' => [
 *     'permission-code' => 'Permission Name',
 *     ...
 * ]
 */

return [
    // Quản lý Admin
    'admin' => [
        'admin-view' => 'Xem danh sách admin',
        'admin-create' => 'Tạo admin mới',
        'admin-edit' => 'Chỉnh sửa thông tin admin',
        'admin-delete' => 'Xóa admin',
        'admin-assign-permission' => 'Gán quyền cho admin',
    ],

    // Quản lý Permission
    'permission' => [
        'permission-view' => 'Xem danh sách quyền',
        'permission-create' => 'Tạo quyền mới',
        'permission-edit' => 'Chỉnh sửa quyền',
        'permission-delete' => 'Xóa quyền',
    ],

    // Quản lý Category
    'category' => [
        'category-view' => 'Xem danh sách danh mục',
        'category-create' => 'Tạo danh mục mới',
        'category-edit' => 'Chỉnh sửa danh mục',
        'category-delete' => 'Xóa danh mục',
    ],

    // Quản lý Product
    'product' => [
        'product-view' => 'Xem danh sách sản phẩm',
        'product-create' => 'Tạo sản phẩm mới',
        'product-edit' => 'Chỉnh sửa sản phẩm',
        'product-delete' => 'Xóa sản phẩm',
    ],

    // Quản lý Booking
    'booking' => [
        'booking-view' => 'Xem danh sách đặt lịch',
        'booking-edit' => 'Chỉnh sửa đặt lịch',
        'booking-delete' => 'Xóa đặt lịch',
    ],

    // Quản lý User
    'user' => [
        'user-view' => 'Xem danh sách người dùng',
        'user-edit' => 'Chỉnh sửa thông tin người dùng',
        'user-delete' => 'Xóa người dùng',
    ],

    // Quản lý Report
    'report' => [
        'report-view' => 'Xem báo cáo',
        'report-export' => 'Xuất báo cáo',
    ],

    // Super Admin - Quyền tối cao
    'super-admin' => [
        'super-admin' => 'Super Admin - Quyền tối cao',
    ],
];

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

    // Quản lý Nail Category
    'nail-category' => [
        'nail-category-view' => 'Xem danh sách danh mục nail',
        'nail-category-create' => 'Tạo danh mục nail mới',
        'nail-category-edit' => 'Chỉnh sửa danh mục nail',
        'nail-category-delete' => 'Xóa danh mục nail',
    ],

    // Quản lý Product
    'product' => [
        'product-view' => 'Xem danh sách sản phẩm',
        'product-create' => 'Tạo sản phẩm mới',
        'product-edit' => 'Chỉnh sửa sản phẩm',
        'product-delete' => 'Xóa sản phẩm',
    ],

    // Quản lý Nails
    'nail' => [
        'nail-view' => 'Xem danh sách nail',
        'nail-create' => 'Tạo nail mới',
        'nail-edit' => 'Chỉnh sửa nail',
        'nail-delete' => 'Xóa nail',
    ],

    // Quản lý Booking
    'booking' => [
        'booking-view' => 'Xem danh sách đặt lịch',
        'booking-edit' => 'Chỉnh sửa đặt lịch',
        'booking-delete' => 'Xóa đặt lịch',
    ],

    // Quản lý Nail Booking
    'nail-booking' => [
        'nail-booking-view' => 'Xem danh sách đặt lịch nail',
        'nail-booking-edit' => 'Chỉnh sửa đặt lịch nail',
        'nail-booking-delete' => 'Xóa đặt lịch nail',
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

    // Quản lý Media
    'media' => [
        'media-view' => 'Xem thư viện ảnh',
        'media-upload' => 'Tải ảnh lên',
        'media-delete' => 'Xóa ảnh',
    ],

    // Quản lý Settings
    'setting' => [
        'setting-view' => 'Xem cài đặt hệ thống',
        'setting-edit' => 'Cập nhật cài đặt hệ thống',
    ],

    // Quản lý Post
    'post' => [
        'post-view' => 'Xem danh sách bài viết',
        'post-create' => 'Tạo bài viết mới',
        'post-edit' => 'Chỉnh sửa bài viết',
        'post-delete' => 'Xóa bài viết',
    ],

    // Quản lý Post Category
    'post-category' => [
        'post-category-view' => 'Xem danh sách danh mục bài viết',
        'post-category-create' => 'Tạo danh mục bài viết mới',
        'post-category-edit' => 'Chỉnh sửa danh mục bài viết',
        'post-category-delete' => 'Xóa danh mục bài viết',
    ],

    // Quản lý Post Tag
    'post-tag' => [
        'post-tag-view' => 'Xem danh sách tag bài viết',
        'post-tag-create' => 'Tạo tag bài viết mới',
        'post-tag-edit' => 'Chỉnh sửa tag bài viết',
        'post-tag-delete' => 'Xóa tag bài viết',
    ],

    // Hệ thống
    'system' => [
        'system-log-view' => 'Xem log hệ thống',
        'system-log-delete' => 'Xóa log hệ thống',
        'redis-view' => 'Xem thống kê Redis',
        'redis-delete' => 'Xóa cache Redis',
    ],

    // Super Admin - Quyền tối cao
    'super-admin' => [
        'super-admin' => 'Super Admin - Quyền tối cao',
    ],
];

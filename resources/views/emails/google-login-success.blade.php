@component('mail::message')
# Đăng nhập thành công 🎉

Xin chào **{{ $user->name }}**,

Bạn vừa đăng nhập vào tài khoản bằng **Google** thành công.

Nếu bạn không thực hiện đăng nhập này, vui lòng liên hệ với chúng tôi ngay lập tức để được hỗ trợ.

@component('mail::button', ['url' => url('/'), 'color' => 'success'])
Về trang chủ
@endcomponent

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
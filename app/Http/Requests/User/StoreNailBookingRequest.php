<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreNailBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'nail_id' => 'required|exists:nails,id',
            'nail_price' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'notes' => 'nullable|string',
            'terms_accepted' => 'required|boolean|accepted',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'nail_id.required' => 'Vui lòng chọn mẫu nail.',
            'booking_date.required' => 'Vui lòng chọn ngày đặt.',
            'booking_time.required' => 'Vui lòng chọn giờ đặt.',
            'terms_accepted.accepted' => 'Bạn phải đồng ý với các điều khoản.',
            'payment_proof.image' => 'File phải là hình ảnh.',
            'payment_proof.max' => 'Dung lượng ảnh tối đa là 5MB.',
        ];
    }
}

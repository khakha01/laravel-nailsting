<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'services' => 'required|array',
            'services.*' => 'exists:products,id',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
            'payment_proof' => 'nullable|image|max:5120', // Max 5MB
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Vui lòng nhập họ tên.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'booking_date.required' => 'Vui lòng chọn ngày đặt.',
            'booking_time.required' => 'Vui lòng chọn giờ đặt.',
            'services.required' => 'Vui lòng chọn ít nhất một dịch vụ.',
            'payment_proof.image' => 'File phải là hình ảnh.',
            'payment_proof.max' => 'Dung lượng ảnh tối đa là 5MB.',
        ];
    }
}

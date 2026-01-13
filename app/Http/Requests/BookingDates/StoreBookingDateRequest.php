<?php

namespace App\Http\Requests\BookingDates;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingDateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'is_open' => ['nullable', 'boolean'],

            'time_slots' => ['nullable', 'array'],

            'time_slots.*.start' => ['nullable', 'date_format:H:i'],
            'time_slots.*.end' => ['nullable', 'date_format:H:i'],
            'time_slots.*.is_open' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Vui lòng chọn ngày',
            'date.date' => 'Ngày không hợp lệ',

            'time_slots.*.start.date_format' => 'Giờ bắt đầu không đúng định dạng',
            'time_slots.*.end.date_format' => 'Giờ kết thúc không đúng định dạng',
        ];
    }
}

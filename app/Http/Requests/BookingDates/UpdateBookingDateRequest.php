<?php

namespace App\Http\Requests\BookingDates;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingDateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'unique:booking_dates,date,' . $this->route('id') . ',id'],
            'is_open' => ['required', 'boolean'],
            'time_slots' => ['nullable', 'array'],
            'time_slots.*.start' => ['required_with:time_slots.*.end', 'date_format:H:i'],
            'time_slots.*.end' => ['required_with:time_slots.*.start', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Ngày là bắt buộc.',
            'date.date' => 'Ngày không hợp lệ.',
            'date.unique' => 'Ngày đã tồn tại.',
            'is_open.required' => 'Trạng thái ngày là bắt buộc.',
            'time_slots.*.start.required_with' => 'Giờ bắt đầu là bắt buộc nếu có khung giờ.',
            'time_slots.*.end.required_with' => 'Giờ kết thúc là bắt buộc nếu có khung giờ.',
        ];
    }
}

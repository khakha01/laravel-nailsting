<?php

namespace App\Http\Requests\Nails;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nailId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nails', 'slug')->ignore($nailId),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'images' => ['nullable', 'array'],
            'images.*.media_id' => ['required', 'exists:media,id'],
            'images.*.is_primary' => ['nullable', 'boolean'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'prices' => ['nullable', 'array'],
            'prices.*.price_type' => ['required', 'string', 'in:fixed,range,per_nail'],
            'prices.*.price' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.price_min' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.price_max' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.note' => ['nullable', 'string', 'max:500'],
            'prices.*.is_default' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nail không được bỏ trống',
            'name.max' => 'Tên nail không được vượt quá 255 ký tự',
            'slug.required' => 'Slug không được bỏ trống',
            'slug.unique' => 'Slug đã tồn tại',
            'description.max' => 'Mô tả không được vượt quá 5000 ký tự',
            'status.required' => 'Trạng thái không được bỏ trống',
            'status.in' => 'Trạng thái không hợp lệ',
            'images.*.media_id.required' => 'Media ID là bắt buộc',
            'images.*.media_id.exists' => 'Media không tồn tại',
            'prices.*.price_type.required' => 'Loại giá là bắt buộc',
            'prices.*.price_type.in' => 'Loại giá không hợp lệ',
            'prices.*.price.regex' => 'Giá không đúng định dạng số',
            'prices.*.price_min.regex' => 'Giá tối thiểu không đúng định dạng số',
            'prices.*.price_max.regex' => 'Giá tối đa không đúng định dạng số',
        ];
    }
}


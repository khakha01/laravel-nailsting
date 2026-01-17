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
            'images.*.image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'], // nullable vì có thể giữ ảnh cũ
            'images.*.image_path' => ['nullable', 'string', 'max:500'], // Giữ path cũ nếu không upload mới
            'images.*.is_primary' => ['nullable', 'boolean'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'prices' => ['nullable', 'array'],
            'prices.*.title' => ['required', 'string', 'max:255'],
            'prices.*.price' => ['required', 'numeric', 'min:0'],
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
            'images.*.image.image' => 'File phải là hình ảnh',
            'images.*.image.mimes' => 'Hình ảnh phải có định dạng: jpeg, jpg, png, gif, webp',
            'images.*.image.max' => 'Kích thước hình ảnh không được vượt quá 5MB',
            'prices.*.title.required' => 'Tiêu đề giá là bắt buộc',
            'prices.*.title.max' => 'Tiêu đề giá không được vượt quá 255 ký tự',
            'prices.*.price.required' => 'Giá là bắt buộc',
            'prices.*.price.numeric' => 'Giá phải là số',
            'prices.*.price.min' => 'Giá phải lớn hơn hoặc bằng 0',
        ];
    }
}


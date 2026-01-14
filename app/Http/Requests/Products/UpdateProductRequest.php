<?php

namespace App\Http\Requests\Products;

use App\Enums\ProductUnitEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');
        $unitValues = implode(',', ProductUnitEnum::values());

        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'code')->ignore($productId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'unit' => ['required', 'string', 'in:' . $unitValues],
            'is_active' => ['required', 'boolean'],
            'display_order' => ['required', 'integer', 'min:0', 'max:999'],
            'prices' => ['nullable', 'array'],
            'prices.*.price_type' => ['required', 'string', 'in:fixed,range,per_nail'],
            'prices.*.price' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.price_min' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.price_max' => ['nullable', 'string', 'regex:/^[0-9\.\,]+$/'],
            'prices.*.note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Danh mục không được bỏ trống',
            'category_id.exists' => 'Danh mục không tồn tại',
            'name.required' => 'Tên sản phẩm không được bỏ trống',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'code.unique' => 'Mã sản phẩm đã tồn tại',
            'code.max' => 'Mã sản phẩm không được vượt quá 100 ký tự',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự',
            'unit.required' => 'Đơn vị không được bỏ trống',
            'unit.in' => 'Đơn vị không hợp lệ',
            'is_active.required' => 'Trạng thái không được bỏ trống',
            'display_order.required' => 'Thứ tự hiển thị không được bỏ trống',
            'display_order.min' => 'Thứ tự hiển thị phải lớn hơn hoặc bằng 0',
            'prices.*.price_type.required' => 'Loại giá không được bỏ trống',
            'prices.*.price_type.in' => 'Loại giá không hợp lệ',
            'prices.*.price.numeric' => 'Giá phải là số',
            'prices.*.price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'prices.*.price_min.numeric' => 'Giá tối thiểu phải là số',
            'prices.*.price_max.numeric' => 'Giá tối đa phải là số',
        ];
    }
}
